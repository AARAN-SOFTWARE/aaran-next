<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Crypt;

class TenantSeeder extends Seeder
{
    public function run()
    {
        $tenants = [
            [
                'b_name' => 'Tenant One Business',
                't_name' => 'tenant_1',
                'email' => 'tenant1@example.com',
                'storage_limit' => 50.00,
                'user_limit' => 20,
                'active_id' => true,
            ],
            [
                'b_name' => 'Tenant Two Business',
                't_name' => 'tenant_2',
                'email' => 'tenant2@example.com',
                'storage_limit' => 10.00,
                'user_limit' => 5,
                'active_id' => true,
            ],
            [
                'b_name' => 'Tenant Three Business',
                't_name' => 'tenant_3',
                'email' => 'tenant3@example.com',
                'storage_limit' => 100.00,
                'user_limit' => 50,
                'active_id' => true,
            ],
        ];

        foreach ($tenants as $tenant) {
            Tenant::create(array_merge($tenant, [
                'contact' => '1234567890',
                'phone' => '9876543210',
                'db_name' => $tenant['t_name'] . '_db',
                'db_host' => '127.0.0.1',
                'db_port' => '3306',
                'db_user' => 'root',
                'db_pass' => 'Computer.1', //Crypt::encryptString('password'), --> this would in future
                'settings' => ['timezone' => 'UTC', 'language' => 'en', 'currency' => 'USD'],
                'enabled_features' => ['invoice_management' => true, 'multi_user_support' => true],
                'two_factor_enabled' => false,
                'api_key' => 'api_key_' . $tenant['t_name'], //Crypt::encryptString('api_key_' . $tenant['t_name']),  //Crypt::encryptString('password'), --> this would in future
                'whitelisted_ips' => ['192.168.1.1'],
                'allow_sso' => false,
                'active_users' => 0,
                'requests_count' => 0,
                'disk_usage' => 0.00,
                'last_active_at' => now(),
            ]));
        }
    }
}
