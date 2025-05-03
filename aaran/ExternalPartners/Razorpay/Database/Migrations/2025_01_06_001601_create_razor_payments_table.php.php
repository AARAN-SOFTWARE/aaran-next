<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasBlog()) {

            Schema::create('razor_payments', function (Blueprint $table) {
                $table->id();
                $table->string('order_id');// Razorpay order ID
                $table->string('payment_id');// Razorpay payment ID (must be unique)
                $table->string('signature');
                $table->integer('amount'); // Stored in paise
                $table->string('currency')->default('INR');
                $table->string('status')->default('success');

                // Optional but useful:
                $table->string('method')->nullable();      // payment method like card, netbanking
                $table->string('email')->nullable();       // buyer email
                $table->string('phone')->nullable();     // buyer phone
                $table->string('description')->nullable(); // optional payment description

                $table->unsignedBigInteger('tenant_id')->nullable();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->timestamps();
            });

        }
    }

    public function down(): void
    {
        Schema::dropIfExists('razor_payments');
    }
};
