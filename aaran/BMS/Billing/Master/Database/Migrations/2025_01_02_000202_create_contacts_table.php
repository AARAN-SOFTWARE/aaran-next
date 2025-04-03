<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        if (Aaran\Assets\Features\Customise::hasMaster()) {

            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->string('vname');
                $table->string('mobile')->nullable();
                $table->string('whatsapp')->nullable();
                $table->string('contact_person')->nullable();
                $table->foreignId('contact_type_id')->references('id')->on('contact_types');
                $table->string('msme_no')->nullable();
                $table->foreignId('msme_type_id')->nullable();
                $table->decimal('opening_balance')->nullable();
                $table->decimal('outstanding',12,2)->nullable();
                $table->string('effective_from')->nullable();
                $table->string('gstin')->nullable();
                $table->string('email')->nullable();
                $table->tinyInteger('active_id')->nullable();
                $table->foreignId('user_id')->references('id')->on('users');
                $table->foreignId('company_id')->references('id')->on('companies');
                $table->unique(['vname', 'gstin']);
                $table->timestamps();
            });

            Schema::create('contact_details', function (Blueprint $table) {
                $table->id();
                $table->foreignId('contact_id')->references('id')->on('contacts');
                $table->string('address_type')->nullable();
                $table->string('address_1')->nullable();
                $table->string('address_2')->nullable();
                $table->foreignId('city_id')->references('id')->on('cities');
                $table->foreignId('state_id')->references('id')->on('states');
                $table->foreignId('pincode_id')->references('id')->on('pincodes');
                $table->foreignId('country_id')->references('id')->on('countries');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_details');

        Schema::dropIfExists('contacts');
    }
};
