<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasCommon()) {

            Schema::create('export_sale_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('export_sales_id')->references('id')->on('export_sales')->onDelete('cascade');
                $table->string('pkgs_type')->nullable();
                $table->string('no_of_count')->nullable();
                $table->foreignId('product_id')->references('id')->on('products');
                $table->string('description')->nullable();
                $table->foreignId('colour_id')->references('id')->on('colours');
                $table->foreignId('size_id')->references('id')->on('sizes');
                $table->decimal('qty');
                $table->decimal('price');
                $table->string('gst_percent')->nullable();
                $table->timestamps();
            });
        }
    }


    public function down(): void
    {
        Schema::dropIfExists('export_sale_items');
    }
};
