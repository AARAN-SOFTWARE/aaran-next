<?php

namespace Aaran\Core\Tenant\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use PDO;

class TenantService
{
    /**
     * Switch the database connection to the tenant's database.
     *
     * @param Tenant $tenant
     * @return void
     */
    public function switchDatabase(Tenant $tenant): void
    {
        $config = json_decode($tenant->config, true);

//        config()->set('database.connections.tenant.database', $config['database']);

        // Set tenant-specific database connection
        Config::set("database.connections.tenant", [
            'driver' => 'mariadb',
            'url' => env('DB_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $config['database'],
            'username' => $config['username'],
            'password' => $config['password'],
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ]);

        DB::purge('tenant'); // Clear old DB connection
        DB::reconnect('tenant'); // Reconnect with new DB
        Config::set('database.default', 'tenant');
    }

    public function ensureTenantDatabaseSetup(Tenant $tenant): void
    {
        self::switchDatabase($tenant);

        // Check if the 'tenants' table exists
        if (!Schema::connection('tenant')->hasTable('migrations')) {
            // Run tenant migrations if the table does not exist
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--force' => true
            ]);
        }
    }

}

