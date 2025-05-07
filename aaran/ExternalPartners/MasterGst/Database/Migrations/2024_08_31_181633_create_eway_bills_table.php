<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasExportSales()) {

            Schema::create('eway_bills', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sales_id')->references('id')->on('sales')->onDelete('cascade');
                $table->longText('ewayBillNo');
                $table->longText('ewayBillDate');
                $table->longText('validUpto');
                $table->string('status')->nullable();
                $table->timestamps();
            });
        }
    }


    public function down(): void
    {
        Schema::dropIfExists('eway_bills');
    }
};
