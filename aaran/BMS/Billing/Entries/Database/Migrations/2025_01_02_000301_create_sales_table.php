<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Aaran\Assets\Features\Customise::hasCommon()) {

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
                $table->foreignId('billing_id')->references('id')->on('contact_addresses');
                $table->foreignId('shipping_id')->references('id')->on('contact_addresses');
                $table->foreignId('style_id')->references('id')->on('styles');
                $table->string('job_no')->nullable();
                $table->string('bundle')->nullable();

                $table->string('trans_mode')->nullable();
                $table->foreignId('trans_id')->references('id')->on('transports');
                $table->string('trans_docs')->nullable();
                $table->string('trans_docs_dt')->nullable();
                $table->string('distance')->nullable();
                $table->string('veh_type')->nullable();
                $table->string('veh_no')->nullable();
                $table->text('term')->nullable();

                $table->decimal('total_qty', 13, 3)->nullable();
                $table->decimal('total_taxable', 13, 2)->nullable();
                $table->decimal('total_gst', 13, 2)->nullable();
                $table->foreignId('ledger_id')->nullable();
                $table->decimal('additional', 13, 2)->nullable();
                $table->decimal('round_off')->nullable();
                $table->decimal('grand_total', 13, 2)->nullable();
                $table->string('received_by')->nullable();
                $table->smallInteger('active_id')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
};
