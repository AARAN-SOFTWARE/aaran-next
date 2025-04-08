<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasCommon()) {

            Schema::create('export_sale_contacts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('export_sales_id')->references('id')->on('export_sales')->onDelete('cascade');
                $table->foreignId('contact_id')->references('id')->on('contacts');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('export_sale_contacts');
    }
};
