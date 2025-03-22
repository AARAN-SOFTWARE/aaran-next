<?php

namespace Aaran\Core\Tenant\Services;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantManager
{
    protected static $tenant;

    public static function setTenant(Tenant $tenant): void
    {
        static::$tenant = $tenant;

        static::setDatabaseConnection($tenant);
    }

    public static function getTenant()
    {
        return static::$tenant;
    }


    protected static function setDatabaseConnection(Tenant $tenant): void
    {
        Config::set("database.connections.tenant", [
            'driver'   => 'mysql',
            'host'     => env('DB_HOST', '127.0.0.1'),
            'database' => $tenant->database,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset'  => 'utf8mb4',
            'collation'=> 'utf8mb4_unicode_ci',
            'prefix'   => '',
            'strict'   => false,
            'engine'   => null,
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');
    }

    /**
     * Find a tenant by domain and return the Tenant model.
     */
    public function findByDomain(string $domain): ?Tenant
    {
        return Tenant::where('domain', $domain)->first();
    }

    /**
     * Create a new tenant.
     */
    public function create(array $data): Tenant
    {
        return Tenant::create($data);
    }
}
