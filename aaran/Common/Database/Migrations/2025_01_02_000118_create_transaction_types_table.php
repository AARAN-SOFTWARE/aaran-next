<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Aaran\Core\Tenant\Features\Customise::hasCommon()) {

            Schema::create('transaction_types', function (Blueprint $table) {
                $table->id();
                $table->string('vname')->unique();
                $table->tinyInteger('active_id')->nullable();
            });

            DB::table('transaction_types')->insert([
                ['id' => 108, 'vname' => 'Sales'],
                ['id' => 136, 'vname' => 'Purchase'],
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_types');
    }
};
