<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Aaran\Assets\Features\Customise::hasCommon()) {

            Schema::create('credit_notes', function (Blueprint $table) {
                $table->id();
                $table->string('uniqueno')->unique();
                $table->string('acyear')->nullable();
                $table->foreignId('company_id')->references('id')->on('companies');
                $table->foreignId('contact_id')->references('id')->on('contacts');
                $table->foreignId('order_id')->references('id')->on('orders');
                $table->integer('credit_no');
                $table->date('credit_date');
                $table->string('invoice_no');
                $table->date('invoice_date');
                $table->string('sales_type')->nullable();
                $table->decimal('total_qty', 11, 3)->nullable();
                $table->decimal('total_taxable', 11, 2)->nullable();
                $table->decimal('total_gst', 11, 2)->nullable();
                $table->foreignId('ledger_id')->nullable();
                $table->decimal('additional', 11, 2)->nullable();
                $table->decimal('round_off')->nullable();
                $table->decimal('grand_total', 11, 2)->nullable();
                $table->string('active_id', 10)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('credit_notes');
    }
};
