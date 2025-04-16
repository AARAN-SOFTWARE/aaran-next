<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Aaran\Assets\Features\Customise::hasCommon()) {

            Schema::create('sale_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('sale_id')->references('id')->on('sales');
                $table->string('po_no')->nullable();
                $table->string('dc_no')->nullable();
                $table->foreignId('product_id')->references('id')->on('products');
                $table->string('description')->nullable();
                $table->foreignId('colour_id')->references('id')->on('colours');
                $table->foreignId('size_id')->references('id')->on('sizes');
                $table->string('no_of_roll')->nullable();
                $table->decimal('qty');
                $table->decimal('price');
                $table->string('gst_percent')->nullable();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('sale_items');
    }
};
