<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayheroDeposit extends Model
{
    protected $fillable = [
        'merchant_request_id',
        'checkout_request_id',
        'mpesa_receipt_number',
        'external_reference',
        'phone',
        'amount',
        'result_code',
        'result_desc',
        'status',
        'fuliza_limit',
        'id_number',
        'callback_data',
        'callback_received_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'callback_data' => 'array',
        'callback_received_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    public function isSuccessful()
    {
        return $this->status === self::STATUS_SUCCESS && $this->result_code == 0;
    }

    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function markAsSuccess($callbackData)
    {
        $this->update([
            'status' => self::STATUS_SUCCESS,
            'mpesa_receipt_number' => $callbackData['response']['MpesaReceiptNumber'] ?? null,
            'callback_data' => $callbackData,
            'callback_received_at' => now(),
        ]);
    }

    public function markAsFailed($callbackData)
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'callback_data' => $callbackData,
            'callback_received_at' => now(),
        ]);
    }
}