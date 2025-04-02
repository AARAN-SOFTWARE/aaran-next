<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasCommon()) {

            Schema::create('despatches', function (Blueprint $table) {
                $table->id();
                $table->string('vname');
                $table->string('vdate')->nullable();
                $table->tinyInteger('active_id')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('despatches');
    }
};
