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
//                $table->unsignedBigInteger('tenant_id'); // Foreign key or unique tenant identifier
                $table->string('token');
                $table->timestamp('expires_at');
                $table->string('client_id')->nullable();
                $table->string('sek')->nullable();
                $table->string('txn')->nullable();
                $table->string('status_cd')->nullable();
                $table->unsignedBigInteger('user_id')->nullable(); // Who triggered it
                $table->timestamps();

//                $table->unique('tenant_id'); // Ensures one active token per tenant
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('master_gst_tokens');
    }
};
