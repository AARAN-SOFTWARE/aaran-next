<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasGstApi()) {

            Schema::create('master_gst_tokens', function (Blueprint $table) {
                $table->id();
                $table->string('token');
                $table->string('expires_at')->nullable();
                $table->foreignId('user_id')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('master_gst_tokens');
    }
};
