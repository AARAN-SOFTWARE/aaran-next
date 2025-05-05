<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasExportSales()) {

            Schema::create('master_gst_eways', function (Blueprint $table) {
                $table->id();
                $table->foreignId('irn_id')->references('id')->on('master_gst_irns')->onDelete('cascade');
                $table->foreignId('sales_id')->references('id')->on('sales')->onDelete('cascade');
                $table->longText('ewbno');
                $table->longText('ewbdt');
                $table->longText('ewbvalidtill');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('master_gst_eways');
    }
};
