<?php


namespace Aaran\Core\Tenant\Tests\Feature;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class TenantCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_tenant_with_nullable_fields()
    {
        $data = [
            'b_name' => 'Test Business',
            't_name' => 'test_tenant',
            'email' => 'test@example.com',
            'contact' => null,
            'phone' => null,
            'db_name' => 'test_db',
            'db_host' => '127.0.0.1',
            'db_port' => '3306',
            'db_user' => 'tenant_user',
            'db_pass' => 'password',
            'plan' => 'free',
            'subscription_start' => now()->toDateString(),
            'subscription_end' => now()->addYear()->toDateString(),
            'storage_limit' => 10.00,
            'user_limit' => 5,
            'is_active' => true,
            'settings' => [],
            'enabled_features' => [],
            'two_factor_enabled' => false,
            'api_key' => 'test_api_key',
            'whitelisted_ips' => null,
            'allow_sso' => false,
            'active_users' => 0,
            'requests_count' => 0,
            'disk_usage' => 0.00,
            'last_active_at' => now(),
        ];

        $tenant = Tenant::create($data);

        $this->assertDatabaseHas('tenants', ['t_name' => 'test_tenant']);

        foreach ($data as $key => $value) {
            if ($key === 'subscription_start' || $key === 'subscription_end') {
                $this->assertEquals($tenant->$key->toDateString(), $value);
            } elseif ($key === 'last_active_at') {
                $this->assertEquals($tenant->$key->format('Y-m-d H:i'), now()->format('Y-m-d H:i'));
            } else {
                $this->assertEquals($tenant->$key, $value);
            }
        }
    }


    public function test_it_can_read_a_tenant()
    {
        $tenant = Tenant::factory()->create();
        $this->assertDatabaseHas('tenants', ['t_name' => $tenant->t_name]);
    }

    public function test_it_can_update_a_tenant()
    {
        $tenant = Tenant::factory()->create();
        $tenant->update(['b_name' => 'Updated Business']);
        $this->assertDatabaseHas('tenants', ['b_name' => 'Updated Business']);
    }

    public function test_it_can_delete_a_tenant()
    {
        $tenant = Tenant::factory()->create();
        $tenant->delete();
        $this->assertSoftDeleted('tenants', ['t_name' => $tenant->t_name]);
    }
}
