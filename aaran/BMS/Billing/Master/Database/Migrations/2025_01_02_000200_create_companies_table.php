<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {

        if (Aaran\Assets\Features\Customise::hasCommon()) {

            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->string('vname')->unique();
                $table->string('display_name')->nullable();
                $table->string('address_1')->nullable();
                $table->string('address_2')->nullable();
                $table->string('mobile')->nullable();
                $table->string('landline')->nullable();
                $table->string('gstin')->nullable();
                $table->string('pan')->nullable();
                $table->string('email')->nullable();
                $table->string('website')->nullable();
                $table->foreignId('city_id')->references('id')->on('cities');
                $table->foreignId('state_id')->references('id')->on('states');
                $table->foreignId('pincode_id')->references('id')->on('pincodes');
                $table->foreignId('country_id')->references('id')->on('countries');
                $table->string('bank')->nullable();
                $table->string('acc_no')->nullable();
                $table->string('ifsc_code')->nullable();
                $table->string('branch')->nullable();
                $table->string('inv_pfx')->nullable();
                $table->string('iec_no')->nullable();
                $table->string('msme_no')->nullable();
                $table->foreignId('msme_type_id')->nullable();
                $table->tinyInteger('active_id')->nullable();
                $table->longText('logo')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
