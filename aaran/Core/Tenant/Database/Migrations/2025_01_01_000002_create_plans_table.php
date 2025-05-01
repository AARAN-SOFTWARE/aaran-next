<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('vname');
            $table->decimal('price', 13, 2);
            $table->enum('billing_cycle', ['monthly', 'yearly']);
            $table->text('description')->nullable();
            $table->boolean('active_id')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};



