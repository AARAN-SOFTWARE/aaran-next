<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasCommon()) {

            Schema::create('packing_lists', function (Blueprint $table) {
                $table->id();
                $table->foreignId('export_sales_id')->references('id')->on('export_sales')->onDelete('cascade');
                $table->foreignId('export_sales_item_id')->references('id')->on('export_sale_items');
                $table->string('nos')->nullable();
                $table->decimal('net_wt',10,3)->nullable();
                $table->decimal('grs_wt',10,3)->nullable();
                $table->string('dimension')->nullable();
                $table->decimal('cbm',10,3)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('packing_lists');
    }
};
