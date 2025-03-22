<?php

namespace Aaran\Core\Tenant\Tests\Feature;

use Aaran\Core\Tenant\Services\TenantService;
use Aaran\Core\User\Models\User;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenantDatabaseSwitchTest extends TestCase
{
    use RefreshDatabase;

    private $tenant;
    private $user;
    private $retrievedTenant;

    /**
     * Set up test environment with a default tenant and user.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Step 1: Ensure tenants table exists
        $this->assertTrue(Schema::hasTable('tenants'), "The tenants table must exist.");

        // Step 2: Create a Tenant
        $this->tenant = Tenant::create([
            'name' => 'Test Tenant',
            'domain' => 'test.local',
            'config' => json_encode([
//                'driver' => 'mariadb',
//                'host' => '127.0.0.1',
//                'port' => '3306',
                'database' => 'test_aaran_1',
                'username' => 'root',
                'password' => 'Computer.1'
            ]),
            'is_active' => true,
        ]);

        // Step 3: Ensure the tenant is created
        $this->assertDatabaseHas('tenants', ['domain' => 'test.local']);

        // Step 4: Create User associated with the Tenant
        $this->user = User::factory()->create([
            'email' => 'tenantuser@example.com',
            'password' => Hash::make('password'),
            'tenant_id' => $this->tenant->id,
        ]);

        // Step 5: Retrieve Tenant from user
        $this->retrievedTenant = Tenant::find($this->user->tenant_id);

        $this->assertNotNull($this->retrievedTenant, "Tenant should be found for the user.");
    }

    /**
     * Test Step 1: Ensure database connection is active
     */
    public function test_Ensure_database_exists()
    {
        $this->assertNotNull(DB::connection(), "Database connection should be active.");
    }

    /**
     * Test Step 2: Retrieve the tenant database using the user's email
     */
    public function test_Retrieve_tenant_using_user_email()
    {
        $tenantDbName = json_decode($this->retrievedTenant->config, true)['database'];

        $this->assertEquals('test_aaran_next', $tenantDbName, "Database name should be retrieved correctly.");
    }

    /**
     * Test Step 3: Switch to the correct tenant database
     */
    public function test_Switch_to_correct_tenant()
    {
        $tenantService = app(TenantService::class);

        $tenantService->switchDatabase($this->retrievedTenant);

        $currentDb = DB::connection('tenant')->getDatabaseName();

        Log::info('Switched to Database: ' . $currentDb);

        $tenantDbName = json_decode($this->retrievedTenant->config, true)['database'];

        $this->assertEquals($tenantDbName, $currentDb, "Database should be switched correctly.");
    }


    public function test_it_checks_table_exists_after_switching_tenant()
    {
        $tenantService = app(TenantService::class);

        // Switch to the correct tenant database
        $tenantService->switchDatabase($this->retrievedTenant);

        // Get the current database name
        $currentDb = DB::connection('tenant')->getDatabaseName();
        Log::info("Switched to Database: " . $currentDb);

        // Check if the `users` table exists
        $tableExists = Schema::connection('tenant')->hasTable('users');

//        // Debugging: Dump table status
//        dd($tableExists);

        // Assert that the table exists
        $this->assertTrue($tableExists, "The users table should exist in the tenant database.");
    }

    //        stancl/tenancy


    public function test_it_tenant_database_has_table_exists_after_switching_tenant()
    {
        $tenantService = app(TenantService::class);

        // Switch to the correct tenant database
        $tenantService->ensureTenantDatabaseSetup($this->retrievedTenant);

        // Create a tenant
        $tenant = Tenant::factory()->create([
            'config' => json_encode(['database' => 'tenant_db']),
        ]);

        // Assert the 'tenants' table exists in the tenant database
        $this->assertTrue(Schema::connection('tenant')->hasTable('tenants'));
    }


    public function test_it_inserts_user_into_tenant_database()
    {
        $tenantService = app(TenantService::class);

        // Step 1: Switch to the correct tenant database
        $tenantService->switchDatabase($this->retrievedTenant);

        $tenant = Tenant::factory()->create([
            'config' => json_encode(['database' => 'tenant_db']),
        ]);

//        $currentConnection = DB::getDefaultConnection();
//        dd($tenant->id);

        // Step 2: Prepare user data
        User::create([
            'tenant_id' => $tenant->id,
            'name' => 'Sundar1',
            'email' => 'sundar@sundar.com1',
            'password' => bcrypt('kalarani'),
        ]);

        // Step 4: Retrieve the inserted user
        $user = DB::connection('tenant')->table('users')->where('email', 'sundar@sundar.com')->first();

        // Debugging: Dump the user data
//        dd($user);

        // Step 5: Assert that the user exists
        $this->assertNotNull($user, "User should be inserted into the tenant database.");
        $this->assertEquals('Sundar', $user->name, "User's name should match.");
        $this->assertEquals('sundar@sundar.com', $user->email, "User's email should match.");

        Log::info("✅ User successfully inserted into tenant database.");
    }


    /**
     * Test Step 4: Attempt login and verify authentication after DB switch
     */
    public function test_it_checks_tenant_database_switching_before_authentication()
    {
        $tenantService = app(TenantService::class);
        $tenantService->switchDatabase($this->retrievedTenant);

        $credentials = ['email' => 'sundar@sundar.com', 'password' => 'kalarani'];

        DB::connection('tenant')->beginTransaction(); // Start transaction

        try {
            // If user does not exist, insert it manually
            DB::connection('tenant')->table('users')->insertOrIgnore([
                'tenant_id' => $this->retrievedTenant->id,
                'name' => 'Sundar',
                'email' => 'sundar@sundar.com',
                'password' => bcrypt('kalarani'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            dd("User created");


            // Re-fetch user after insertion
            $user = DB::connection('tenant')->table('users')->where('email', 'sundar@sundar.com')->first();

            DB::connection('tenant')->commit(); // Commit transaction

        } catch (\Exception $e) {
            DB::connection('tenant')->rollBack(); // Rollback transaction on error
            throw $e;
        }

        dd($user); // Debugging: Ensure user exists

        $this->assertTrue(Auth::attempt($credentials), "User should be able to log in.");
        Log::info("Multi-Tenant Authentication Test Passed ✅");
    }


}
