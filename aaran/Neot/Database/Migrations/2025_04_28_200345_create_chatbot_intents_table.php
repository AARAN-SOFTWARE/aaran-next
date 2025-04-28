<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chatbot_intents', function (Blueprint $table) {
            $table->id();
            $table->string('title');                      // Friendly title
            $table->string('pattern');                    // Regex pattern to match
            $table->text('static_response')->nullable();  // Static reply (optional)
            $table->string('model_class')->nullable();    // Model to query (optional)
            $table->json('columns')->nullable();          // Select columns (optional)
            $table->json('where_conditions')->nullable(); // Where clauses (optional)
            $table->string('view_template')->nullable();  // Blade template
            $table->integer('priority')->default(0);      // Matching priority
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_intents');
    }
};
