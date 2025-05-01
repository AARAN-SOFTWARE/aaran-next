<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('b_name'); // Business Name
            $table->string('t_name')->unique(); // Tenant Name
            $table->string('email')->unique();
            $table->string('contact')->nullable();
            $table->string('phone')->nullable();
            // Database Details
            $table->string('db_name')->unique();
            $table->string('db_host')->default('127.0.0.1');
            $table->string('db_port')->default('3306');
            $table->string('db_user');
            $table->text('db_pass');
            // Subscription & Limits
            $table->decimal('storage_limit', 13, 2)->default(10);
            $table->integer('user_limit')->default(5);
            $table->boolean('active_id')->default(true);
            // Multi-Tenant Features
            $table->string('industry_code')->nullable();
            $table->json('settings')->nullable();
            $table->json('enabled_features')->nullable();
            // Security
            $table->boolean('two_factor_enabled')->default(false);
            $table->text('api_key')->nullable();
            $table->json('whitelisted_ips')->nullable();
            $table->boolean('allow_sso')->default(false);
            // Performance & Usage
            $table->integer('active_users')->default(0);
            $table->integer('requests_count')->default(0);
            $table->decimal('disk_usage', 10, 2)->default(0);
            // Lifecycle
            $table->timestamp('last_active_at')->nullable();
            $table->string('migration_status')->default('pending')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('t_name');
            $table->index('email');
            $table->index('industry_code');
            $table->index('active_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};



