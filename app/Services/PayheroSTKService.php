<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayheroSTKService
{
    protected $basicAuth;
    protected $channelId;
    protected $callbackUrl;

    public function __construct()
    {
        // Base64 encoded Basic auth: username:password
        $this->basicAuth = config('payhero.basic_auth', 'c1dhSjh5NzZJdDV4TnpteWRUcXU6eWN3elNHaGpuS3V5UWJISm9PbzJyTGxpNW42d2d6dHpjYWgyemx5ag==');
        $this->channelId = config('payhero.channel_id', 133);
        $this->callbackUrl = route('payhero.callback');
    }

    public function sendSTKPush($phone, $amount, $externalReference, $customerName)
    {
        try {
            $url = 'https://backend.payhero.co.ke/api/v2/payments';

            $payload = [
                'amount' => (float) $amount,
                'phone_number' => $this->formatPhone($phone),
                'channel_id' => (int) $this->channelId,
                'provider' => 'm-pesa',
                'external_reference' => $externalReference,
                'customer_name' => $customerName,
                'callback_url' => $this->callbackUrl,
            ];

            Log::info('PayHero STK Request:', [
                'url' => $url,
                'payload' => $payload,
                'channel_id' => $this->channelId,
                'reference' => $externalReference,
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $this->basicAuth,
            ])->timeout(30)->post($url, $payload);

            $data = $response->json();
            $statusCode = $response->status();

            Log::info('PayHero STK Response:', [
                'status_code' => $statusCode,
                'response' => $data,
                'reference' => $externalReference,
            ]);

            if ($response->successful()) {
                // Check response structure based on PayHero documentation
                if (isset($data['status']) && $data['status'] === true) {
                    // Success response format
                    return [
                        'success' => true,
                        'merchant_request_id' => $data['response']['MerchantRequestID'] ?? null,
                        'checkout_request_id' => $data['response']['CheckoutRequestID'] ?? null,
                        'message' => 'STK Push sent successfully! Check your phone.',
                        'data' => $data,
                    ];
                } elseif (isset($data['success']) && $data['success'] === true) {
                    // Alternative success format
                    return [
                        'success' => true,
                        'merchant_request_id' => $data['data']['MerchantRequestID'] ?? null,
                        'checkout_request_id' => $data['data']['CheckoutRequestID'] ?? null,
                        'message' => 'STK Push sent successfully! Check your phone.',
                        'data' => $data,
                    ];
                }
            }

            // Handle specific error cases
            $errorMessage = $this->getErrorMessage($data, $statusCode);
            
            return [
                'success' => false,
                'message' => $errorMessage,
                'data' => $data,
                'status_code' => $statusCode,
            ];

        } catch (\Exception $e) {
            Log::error('PayHero STK Error:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'reference' => $externalReference ?? 'N/A',
            ]);
            
            return [
                'success' => false,
                'message' => 'Service temporarily unavailable. Please try again.',
                'exception' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check transaction status
     */
    public function checkTransactionStatus($checkoutRequestId)
    {
        try {
            $url = 'https://backend.payhero.co.ke/api/v2/transactions/query';

            $payload = [
                'checkout_request_id' => $checkoutRequestId,
            ];

            Log::info('PayHero Status Check:', [
                'checkout_request_id' => $checkoutRequestId,
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $this->basicAuth,
            ])->timeout(30)->post($url, $payload);

            $data = $response->json();
            $statusCode = $response->status();

            Log::info('PayHero Status Response:', [
                'status_code' => $statusCode,
                'response' => $data,
                'checkout_request_id' => $checkoutRequestId,
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $data,
                    'status_code' => $statusCode,
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to check transaction status',
                'data' => $data,
                'status_code' => $statusCode,
            ];

        } catch (\Exception $e) {
            Log::error('PayHero Status Check Error:', [
                'error' => $e->getMessage(),
                'checkout_request_id' => $checkoutRequestId,
            ]);
            
            return [
                'success' => false,
                'message' => 'Failed to check transaction status',
                'exception' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get transaction by external reference
     */
    public function getTransactionByReference($externalReference)
    {
        try {
            $url = "https://backend.payhero.co.ke/api/v2/transactions?external_reference={$externalReference}";

            Log::info('PayHero Reference Check:', [
                'external_reference' => $externalReference,
            ]);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $this->basicAuth,
            ])->timeout(30)->get($url);

            $data = $response->json();
            $statusCode = $response->status();

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $data,
                    'status_code' => $statusCode,
                ];
            }

            return [
                'success' => false,
                'message' => 'Transaction not found',
                'data' => $data,
                'status_code' => $statusCode,
            ];

        } catch (\Exception $e) {
            Log::error('PayHero Reference Check Error:', [
                'error' => $e->getMessage(),
                'external_reference' => $externalReference,
            ]);
            
            return [
                'success' => false,
                'message' => 'Failed to fetch transaction',
                'exception' => $e->getMessage(),
            ];
        }
    }

    /**
     * Cancel a transaction
     */
    public function cancelTransaction($checkoutRequestId)
    {
        try {
            $url = 'https://backend.payhero.co.ke/api/v2/transactions/cancel';

            $payload = [
                'checkout_request_id' => $checkoutRequestId,
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $this->basicAuth,
            ])->timeout(30)->post($url, $payload);

            $data = $response->json();
            $statusCode = $response->status();

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Transaction cancelled successfully',
                    'data' => $data,
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to cancel transaction',
                'data' => $data,
                'status_code' => $statusCode,
            ];

        } catch (\Exception $e) {
            Log::error('PayHero Cancel Error:', [
                'error' => $e->getMessage(),
                'checkout_request_id' => $checkoutRequestId,
            ]);
            
            return [
                'success' => false,
                'message' => 'Failed to cancel transaction',
                'exception' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get error message from response
     */
    private function getErrorMessage($data, $statusCode)
    {
        // Handle HTTP status codes
        if ($statusCode === 401) {
            return 'Authentication failed. Please check your credentials.';
        } elseif ($statusCode === 403) {
            return 'Access denied. Please check your permissions.';
        } elseif ($statusCode === 404) {
            return 'Service endpoint not found.';
        } elseif ($statusCode === 429) {
            return 'Too many requests. Please try again later.';
        } elseif ($statusCode >= 500) {
            return 'Server error. Please try again later.';
        }

        // Handle specific error messages from response
        if (isset($data['message'])) {
            return $data['message'];
        } elseif (isset($data['error'])) {
            return $data['error'];
        } elseif (isset($data['ResponseDescription'])) {
            return $data['ResponseDescription'];
        } elseif (isset($data['result_desc'])) {
            return $data['result_desc'];
        }

        return 'Failed to send STK Push. Please try again.';
    }

    /**
     * Format phone number
     */
    private function formatPhone($phone)
    {
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Convert to 254 format if it's 10 digits starting with 0
        if (strlen($phone) == 10 && substr($phone, 0, 1) == '0') {
            return '254' . substr($phone, 1);
        }
        
        // If it's 9 digits (without leading 0), add 254
        if (strlen($phone) == 9 && substr($phone, 0, 1) == '7') {
            return '254' . $phone;
        }
        
        return $phone;
    }

    /**
     * Verify webhook signature (if implemented by PayHero)
     */
    public function verifyWebhookSignature($payload, $signature)
    {
        // If PayHero provides webhook signature verification
        $webhookSecret = config('payhero.webhook_secret');
        
        if (empty($webhookSecret)) {
            Log::warning('Webhook secret not configured');
            return true; // Skip verification if no secret configured
        }
        
        $expectedSignature = hash_hmac('sha256', json_encode($payload), $webhookSecret);
        
        return hash_equals($expectedSignature, $signature);
    }
}