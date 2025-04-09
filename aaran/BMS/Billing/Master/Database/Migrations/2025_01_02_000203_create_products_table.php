<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasCommon()) {

            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('vname')->unique();
                $table->foreignId('product_type_id')->nullable();
                $table->foreignId('hsncode_id')->references('id')->on('hsncodes');
                $table->foreignId('unit_id')->references('id')->on('units');
                $table->foreignId('gst_percent_id')->references('id')->on('gst_percents');
                $table->decimal('initial_quantity',12,2)->nullable();
                $table->decimal('initial_price',12,2)->nullable();
                $table->tinyInteger('active_id')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
