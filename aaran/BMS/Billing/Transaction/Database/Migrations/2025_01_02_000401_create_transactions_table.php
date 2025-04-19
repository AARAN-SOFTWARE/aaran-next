<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('acyear')->nullable();
            $table->foreignId('company_id')->references('id')->on('companies');

            $table->foreignId('account_book_id')->references('id')->on('account_books');
            $table->tinyInteger('transaction_mode')->nullable();

            $table->foreignId('contact_id')->references('id')->on('contacts');
            $table->string('vch_no')->nullable();
            $table->string('vdate');
            $table->decimal('amount', 15, 2);

            $table->text('remarks')->nullable();

            $table->tinyInteger('payment_method')->nullable();

            $table->string('chq_no')->nullable();
            $table->string('chq_date')->nullable();
            $table->foreignId('instrument_bank_id')->references('id')->on('banks');
            $table->string('deposit_on')->nullable();
            $table->string('realised_on')->nullable();

            $table->tinyInteger('active_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
