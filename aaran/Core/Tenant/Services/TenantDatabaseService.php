<?php

namespace Aaran\Core\Tenant\Services;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class TenantDatabaseService
{
    /**
     * Switch to a given tenant.
     *
     * @throws \Throwable
     */
    public static function switchTenant(int|Tenant $tenant): bool
    {
        DB::beginTransaction();

        try {
            $tenantId = $tenant instanceof Tenant ? $tenant->id : $tenant;

            $tenantConfig = Cache::remember("tenant_{$tenantId}_config", 600, function () use ($tenantId) {
                $tenant = Tenant::findOrFail($tenantId);
                return [
                    'id'        => $tenant->id,
                    'host'      => $tenant->db_host,
                    'port'      => $tenant->db_port,
                    'database'  => $tenant->db_name,
                    'username'  => $tenant->db_user,
                    'password'  => $tenant->db_pass,
                ];
            });

            if (!$tenantConfig) {
                throw new \Exception("Tenant {$tenantId} configuration not found.");
            }

            // Store in session
            Session::put('tenant_db_config', $tenantConfig);

            // Apply configuration
            self::applyTenantConfig($tenantConfig);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to switch tenant {$tenantId}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get the currently active tenant.
     */
    public static function current(): ?Tenant
    {
        $tenantConfig = Session::get('tenant_db_config');

        if (!$tenantConfig || !isset($tenantConfig['id'])) {
            return null;
        }

        return Cache::remember("tenant_{$tenantConfig['id']}", 600, function () use ($tenantConfig) {
            return Tenant::find($tenantConfig['id']);
        });
    }

    /**
     * Apply database configuration for a tenant.
     */
    public static function applyTenantConfig(array $tenantConfig): void
    {
        Config::set('database.connections.tenant', [
            'driver'    => 'mysql',
            'host'      => $tenantConfig['host'],
            'port'      => $tenantConfig['port'],
            'database'  => $tenantConfig['database'],
            'username'  => $tenantConfig['username'],
            'password'  => $tenantConfig['password'],
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ]);

        // Reset and reconnect
        DB::purge('tenant');
        DB::reconnect('tenant');

        // Set up tenant-specific logging
        self::setTenantLogger($tenantConfig['database']);
    }

    /**
     * Configure tenant-specific logging.
     */
    public static function setTenantLogger($databaseName): void
    {
        $logPath = storage_path("logs/tenants/{$databaseName}.log");

        Config::set('logging.channels.tenant', [
            'driver' => 'single',
            'path' => $logPath,
            'level' => env('LOG_LEVEL', 'debug'),
        ]);

        Log::info("Switched to tenant: {$databaseName}");
    }
}
