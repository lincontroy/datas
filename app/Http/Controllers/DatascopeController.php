<?php

namespace App\Http\Controllers;

use App\Models\PayheroDeposit;
use App\Services\PayheroSTKService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DatascopeController extends Controller
{
    protected $payheroService;

    public function __construct(PayheroSTKService $payheroService)
    {
        $this->payheroService = $payheroService;
    }

    // Main page
    public function index()
    {
        $packages = [
            ['id' => 1, 'limit' => 'Ksh 5,000', 'fee' => 'Ksh 150', 'amount' => 150],
            ['id' => 2, 'limit' => 'Ksh 10,000', 'fee' => 'Ksh 250', 'amount' => 250],
            ['id' => 3, 'limit' => 'Ksh 20,000', 'fee' => 'Ksh 350', 'amount' => 350],
            ['id' => 4, 'limit' => 'Ksh 30,000', 'fee' => 'Ksh 450', 'amount' => 450],
            ['id' => 5, 'limit' => 'Ksh 50,000', 'fee' => 'Ksh 600', 'amount' => 600],
            ['id' => 6, 'limit' => 'Ksh 100,000', 'fee' => 'Ksh 850', 'amount' => 850],
        ];

        return view('datascope.index', ['packages' => $packages]);
    }

    // Process payment
    public function processPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|digits:10|starts_with:07',
            'amount' => 'required|numeric|min:10|max:100000',
            'id_number' => 'required|digits_between:7,9',
            'limit_amount' => 'required|string',
            'package_name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please check your input',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate unique reference
        $externalReference = 'DS-' . date('YmdHis') . '-' . strtoupper(substr(md5(microtime()), 0, 8));

        // Create deposit record
        $deposit = PayheroDeposit::create([
            'external_reference' => $externalReference,
            'phone' => $request->phone,
            'amount' => $request->amount,
            'id_number' => $request->id_number,
            'fuliza_limit' => $request->limit_amount,
            'status' => 'pending',
            'result_desc' => 'STK Push initiated',
        ]);

        try {
            // Send STK Push via PayHero
            $customerName = "Fuliza ID: {$request->id_number}";
            $result = $this->payheroService->sendSTKPush(
                $request->phone,
                $request->amount,
                $externalReference,
                $customerName
            );

            if ($result['success']) {
                // Extract checkout request ID based on PayHero response structure
                $checkoutRequestId = null;
                $merchantRequestId = null;
                
                // Try different response structures
                if (isset($result['data']['response']['CheckoutRequestID'])) {
                    $checkoutRequestId = $result['data']['response']['CheckoutRequestID'];
                    $merchantRequestId = $result['data']['response']['MerchantRequestID'] ?? null;
                } elseif (isset($result['data']['CheckoutRequestID'])) {
                    $checkoutRequestId = $result['data']['CheckoutRequestID'];
                    $merchantRequestId = $result['data']['MerchantRequestID'] ?? null;
                } elseif (isset($result['checkout_request_id'])) {
                    $checkoutRequestId = $result['checkout_request_id'];
                    $merchantRequestId = $result['merchant_request_id'] ?? null;
                }

                // Update deposit with PayHero IDs
                $deposit->update([
                    'merchant_request_id' => $merchantRequestId,
                    'checkout_request_id' => $checkoutRequestId,
                    'result_desc' => 'STK Push sent to phone',
                    'response' => $result['data'] ?? null,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => $result['message'] ?? 'STK Push sent successfully!',
                    'checkout_request_id' => $checkoutRequestId,
                    'merchant_request_id' => $merchantRequestId,
                    'external_reference' => $externalReference,
                    'debug' => config('app.debug') ? $result : null,
                ]);
            }

            // Handle failure
            $deposit->update([
                'status' => 'failed',
                'result_desc' => $result['message'] ?? 'Payment failed',
                'response' => $result['data'] ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Failed to initiate payment. Please try again.',
                'debug' => config('app.debug') ? $result : null,
            ], 400);

        } catch (\Exception $e) {
            Log::error('Payment Processing Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            $deposit->update([
                'status' => 'failed',
                'result_desc' => 'System error: ' . $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.',
                'debug' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    // PayHero Callback Webhook
    public function payheroCallback(Request $request)
    {
        $callbackData = $request->all();
        
        Log::info('PayHero Callback Received:', $callbackData);

        try {
            // Validate callback data
            if (!isset($callbackData['response']['ExternalReference'])) {
                Log::error('Invalid callback: Missing ExternalReference', $callbackData);
                return response()->json(['success' => false, 'message' => 'Invalid callback'], 400);
            }

            $externalReference = $callbackData['response']['ExternalReference'];
            $resultCode = $callbackData['response']['ResultCode'] ?? null;
            $status = $callbackData['status'] ?? false;

            // Find deposit
            $deposit = PayheroDeposit::where('external_reference', $externalReference)->first();

            if (!$deposit) {
                Log::warning('Deposit not found for reference: ' . $externalReference);
                return response()->json(['success' => false, 'message' => 'Deposit not found'], 404);
            }

            // Update deposit with callback data
            $updateData = [
                'callback_data' => $callbackData,
                'callback_received_at' => now(),
            ];

            // Check payment status
            if ($status === true && $resultCode == 0) {
                // Payment successful
                $updateData['status'] = 'success';
                $updateData['mpesa_receipt_number'] = $callbackData['response']['MpesaReceiptNumber'] ?? null;
                $updateData['merchant_request_id'] = $callbackData['response']['MerchantRequestID'] ?? $deposit->merchant_request_id;
                $updateData['checkout_request_id'] = $callbackData['response']['CheckoutRequestID'] ?? $deposit->checkout_request_id;
                $updateData['result_code'] = $resultCode;
                $updateData['result_desc'] = $callbackData['response']['ResultDesc'] ?? 'Payment successful';

                Log::info('Payment successful for: ' . $externalReference, [
                    'mpesa_receipt' => $updateData['mpesa_receipt_number'],
                    'phone' => $deposit->phone,
                    'amount' => $deposit->amount,
                ]);

            } elseif ($status === false || $resultCode != 0) {
                // Payment failed
                $updateData['status'] = 'failed';
                $updateData['result_code'] = $resultCode;
                $updateData['result_desc'] = $callbackData['response']['ResultDesc'] ?? 'Payment failed';

                Log::warning('Payment failed for: ' . $externalReference, [
                    'result_code' => $resultCode,
                    'result_desc' => $updateData['result_desc'],
                ]);
            }

            $deposit->update($updateData);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Callback Processing Error: ' . $e->getMessage(), [
                'callback_data' => $callbackData,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['success' => false, 'message' => 'Callback processing error'], 500);
        }
    }

    // Check payment status
    public function checkStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checkout_request_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Checkout Request ID is required',
            ], 422);
        }

        $deposit = PayheroDeposit::where('checkout_request_id', $request->checkout_request_id)
        ->where('status', '==', 'pending')
        ->first();

        if($deposit) {
           $deposit->update([
                'status' => 'completed',
                'result_desc' => 'STk push accepted',
            ]);
        }
        if (!$deposit) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction not found',
            ], 404);
        }



        return response()->json([
            'success' => true,
            'status' => $deposit->status,
            'result_code' => $deposit->result_code,
            'result_desc' => $deposit->result_desc,
            'mpesa_receipt_number' => $deposit->mpesa_receipt_number,
            'fuliza_limit' => $deposit->fuliza_limit,
            'amount' => $deposit->amount,
            'created_at' => $deposit->created_at->format('Y-m-d H:i:s'),
            'is_successful' => $deposit->status === 'success' && $deposit->result_code == 0,
        ]);
    }


}