<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('account_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_type_id')->nullable()->constrained('transaction_types')->onDelete('cascade');
            $table->string('vname');

            $table->string('account_no')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->foreignId('bank_id')->references('id')->on('banks');
            $table->foreignId('account_type_id')->references('id')->on('account_types');
            $table->string('branch')->nullable();

            $table->decimal('opening_balance', 15, 2)->default(0)->nullable();
            $table->date('opening_balance_date');
            $table->decimal('current_balance', 15, 2)->default(0)->nullable();
            $table->string('current_balance_date')->nullable();
            $table->string('current_entry_id')->nullable();

            $table->longText('notes')->nullable();

            $table->foreignId('company_id')->references('id')->on('companies');
            $table->string('active_id',3)->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('account_books');
    }
};
