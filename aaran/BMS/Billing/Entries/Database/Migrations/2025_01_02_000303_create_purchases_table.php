<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Aaran\Assets\Features\Customise::hasEntries()) {

            Schema::create('purchases', function (Blueprint $table) {
                $table->id();
                $table->string('uniqueno')->unique();
                $table->string('acyear')->nullable();
                $table->foreignId('company_id')->references('id')->on('companies');
                $table->foreignId('contact_id')->references('id')->on('contacts');
                $table->foreignId('order_id')->references('id')->on('orders');
                $table->string('purchase_no')->nullable();
                $table->date('purchase_date');
                $table->integer('Entry_no')->nullable();
                $table->string('sales_type')->nullable();
                $table->foreignId('transport_id')->references('id')->on('transports');
                $table->string('bundle')->nullable();
                $table->text('term')->nullable();
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
        Schema::dropIfExists('purchases');
    }
};
