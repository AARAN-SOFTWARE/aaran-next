<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Aaran\Assets\Features\Customise::hasEntries()) {

            Schema::create('sales', function (Blueprint $table) {
                $table->id();
                $table->string('uniqueno')->unique();
                $table->string('acyear')->nullable();
                $table->foreignId('company_id')->references('id')->on('companies');
                $table->foreignId('contact_id')->references('id')->on('contacts');
                $table->integer('invoice_no');
                $table->date('invoice_date');
                $table->string('sales_type')->nullable();
                $table->foreignId('order_id')->references('id')->on('orders');
                $table->foreignId('billing_id')->references('id')->on('contact_details');
                $table->foreignId('shipping_id')->references('id')->on('contact_details');
                $table->foreignId('style_id')->references('id')->on('styles');
                $table->foreignId('despatch_id')->references('id')->on('despatches');
                $table->string('job_no')->nullable();
                $table->foreignId('transport_id')->references('id')->on('transports');
                $table->string('destination')->nullable();
                $table->string('bundle')->nullable();

                $table->string('distance')->nullable();
                $table->string('TransMode')->nullable();
                $table->string('Transid')->nullable();
                $table->string('Transname')->nullable();
                $table->string('Transdocno')->nullable();
                $table->string('TransdocDt')->nullable();
                $table->string('Vehno')->nullable();
                $table->string('Vehtype')->nullable();
                $table->text('term')->nullable();

                $table->decimal('total_qty', 11, 3)->nullable();
                $table->decimal('total_taxable', 11, 2)->nullable();
                $table->decimal('total_gst', 11, 2)->nullable();
                $table->foreignId('ledger_id')->nullable();
                $table->decimal('additional', 11, 2)->nullable();
                $table->decimal('round_off')->nullable();
                $table->decimal('grand_total', 11, 2)->nullable();
                $table->string('received_by')->nullable();
                $table->string('active_id', 10)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
