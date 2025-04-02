<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
//        if (Aaran\Core\Tenant\Features\Customise::hasCommon()) {

            Schema::create('slider_images', function (Blueprint $table) {
                $table->id();
                $table->string('url')->nullable();
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
            });

//        }
    }

    public function down(): void
    {
        Schema::dropIfExists('slider_images');
    }
};
