<?php


namespace Aaran\Core\Setup\Tests\Feature;

use Aaran\Core\Setup\Jobs\RunTenantMigrationJob;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class RunTenantMigrationJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_sets_migration_status_success_when_migration_runs()
    {
        // Fake Artisan call
        Artisan::shouldReceive('call')
            ->once()
            ->with('aaran:migrate', [
                'tenant' => 'test_tenant',
                '--fresh' => true,
                '--seed' => true,
            ])
            ->andReturn(0);

        // Create mock tenant
        $tenant = Tenant::factory()->create([
            't_name' => 'test_tenant',
            'db_name' => 'test_db',
            'migration_status' => 'pending',
        ]);

        // Fake DB exists
        DB::shouldReceive('select')
            ->once()
            ->with("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", ['test_db'])
            ->andReturn([(object)['SCHEMA_NAME' => 'test_db']]);

        // Fake purge to avoid real reconnections
        DB::shouldReceive('purge')->once()->with('tenant');

        // Run job
        (new RunTenantMigrationJob($tenant))->handle();

        $tenant->refresh();
        $this->assertEquals('success', $tenant->migration_status);
    }

    public function test_job_sets_migration_status_failed_when_database_missing()
    {
        $tenant = Tenant::factory()->create([
            't_name' => 'fail_tenant',
            'db_name' => 'missing_db',
            'migration_status' => 'pending',
        ]);

        // Simulate missing DB
        DB::shouldReceive('select')
            ->once()
            ->with("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?", ['missing_db'])
            ->andReturn([]); // No DB

        DB::shouldReceive('purge')->once()->with('tenant');

        (new RunTenantMigrationJob($tenant))->handle();

        $tenant->refresh();
        $this->assertEquals('failed', $tenant->migration_status);
    }
}
