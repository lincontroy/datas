<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payhero_deposits', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_request_id')->nullable();
            $table->string('checkout_request_id')->nullable();
            $table->string('mpesa_receipt_number')->nullable();
            $table->string('external_reference')->nullable();
            $table->string('phone');
            $table->decimal('amount', 10, 2);
            $table->string('result_code');
            $table->text('result_desc');
            $table->string('status'); // pending, success, failed, cancelled
            $table->string('fuliza_limit')->nullable(); // Store the limit amount
            $table->string('id_number')->nullable();
            $table->json('callback_data')->nullable();
            $table->timestamp('callback_received_at')->nullable();
            $table->timestamps();
            
            $table->index('merchant_request_id');
            $table->index('checkout_request_id');
            $table->index('mpesa_receipt_number');
            $table->index('external_reference');
            $table->index('status');
            $table->index('phone');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payhero_deposits');
    }
};