<?php


namespace Aaran\Core\Tenant\Tests\Feature;

use Aaran\Core\Tenant\Models\Tenant;
use Aaran\Core\Tenant\Services\TenantService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class T06_InsertIntoTenant extends TestCase
{

    private $retrievedTenant;

    public function test_can_create_tenant()
    {
        // Step 5: Retrieve Tenant from user
        $this->retrievedTenant = Tenant::find(1);

        dd($this->retrievedTenant);

        $tenantService = app(TenantService::class);

        // Switch to the correct tenant database
        $tenantService->switchDatabase($this->retrievedTenant);

        $tenant = Tenant::on('tenant')->create([
            'name' => 'Test Tenant',
            'domain' => 'test.local',
            'config' => json_encode(['db' => 'test_db']),
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('tenants', ['domain' => 'test.local']);
    }
}
