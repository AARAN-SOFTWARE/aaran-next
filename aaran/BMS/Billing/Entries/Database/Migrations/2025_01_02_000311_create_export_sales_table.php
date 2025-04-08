<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasCommon()) {

            Schema::create('export_sales', function (Blueprint $table) {
                $table->id();
                $table->string('uniqueno')->unique();
                $table->string('acyear')->nullable();
                $table->foreignId('company_id')->references('id')->on('companies');
                $table->foreignId('contact_id')->references('id')->on('contacts');
                $table->integer('invoice_no');
                $table->date('invoice_date');

                $table->decimal('ex_rate', 11, 2)->nullable();
                $table->string('currency_type')->nullable();
                $table->string('sales_type')->nullable();

                $table->foreignId('order_id')->references('id')->on('orders');
                $table->foreignId('style_id')->references('id')->on('styles');

                $table->string('pre_carriage')->nullable();
                $table->string('place_of_Receipt')->nullable();
                $table->string('vessel_flight_no')->nullable();
                $table->string('port_of_loading')->nullable();
                $table->string('port_of_discharge')->nullable();
                $table->string('final_destination')->nullable();

                $table->decimal('total_qty', 11, 3)->nullable();
                $table->decimal('total_taxable', 11, 2)->nullable();
                $table->decimal('total_gst', 11, 2)->nullable();
                $table->decimal('round_off')->nullable();
                $table->decimal('grand_total', 11, 2)->nullable();
                $table->decimal('additional', 11, 2)->nullable();

                $table->string('active_id', 10)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('export_sales');
    }
};
