<?php

namespace Aaran\Core\Tenant\Database\Factories;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Crypt;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition()
    {
        return [
            'b_name' => $this->faker->company,
            't_name' => $this->faker->unique()->slug,
            'email' => $this->faker->unique()->safeEmail,
            'contact' => $this->faker->phoneNumber,
            'phone' => $this->faker->phoneNumber,
            'db_name' => $this->faker->unique()->slug,
            'db_host' => '127.0.0.1',
            'db_port' => '3306',
            'db_user' => 'tenant_user',
            'db_pass' => Crypt::encryptString('password'),
            'plan' => 'free',
            'subscription_start' => now(),
            'subscription_end' => now()->addYear(),
            'storage_limit' => 10.00,
            'user_limit' => 5,
            'is_active' => true,
            'settings' => [
                'timezone' => 'UTC',
                'language' => 'en',
                'currency' => 'USD',
                'notifications_enabled' => true,
                'auto_backup' => true,
            ],
            'enabled_features' => [
                'invoice_management' => true,
                'multi_user_support' => true,
                'api_access' => false,
                'custom_reports' => true,
                'live_chat_support' => false,
            ],
            'two_factor_enabled' => false,
            'api_key' => Crypt::encryptString($this->faker->uuid),
            'whitelisted_ips' => ['192.168.1.1', '192.168.1.2'],
            'allow_sso' => false,
            'active_users' => 0,
            'requests_count' => 0,
            'disk_usage' => 0.00,
            'last_active_at' => now(),
        ];
    }
}
