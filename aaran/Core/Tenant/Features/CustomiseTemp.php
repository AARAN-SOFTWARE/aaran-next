<?php

namespace Aaran\Core\Tenant\Features;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Aaran\Core\Tenant\Facades\TenantManager;
use Aaran\Core\Tenant\Models\Tenant;

class CustomiseTemp
{
    /**
     * Check if common features exist in config or database.
     */
    public static function hasCommon(): bool
    {
        return !empty(self::getCommon());
    }

    /**
     * Get common features from config and database.
     */
    public static function getCommon(): array
    {
        $configFeatures = Config::get('features.common', []);

        $dbFeatures = Cache::remember('common_features', 600, function () {
            return self::getFeaturesFromDatabase();
        });

        return array_unique(array_merge($configFeatures, $dbFeatures));
    }

    /**
     * Check if a feature is enabled globally.
     */
    public static function isEnabled(string $feature): bool
    {
        return in_array($feature, self::getCommon());
    }

    /**
     * Check if a feature is enabled for the current tenant.
     */
    public static function isTenantFeatureEnabled(string $feature): bool
    {
        $tenant = TenantManager::current();

        if (!$tenant) {
            return false;
        }

        $tenantFeatures = json_decode($tenant->enabled_features ?? '[]', true);

        return in_array($feature, $tenantFeatures);
    }

    /**
     * Fetch features from database.
     */
    private static function getFeaturesFromDatabase(): array
    {
        return Tenant::on('mariadb')
            ->whereNotNull('enabled_features')
            ->pluck('enabled_features')
            ->flatMap(fn($features) => $features) // No need for json_decode()
            ->unique()
            ->toArray();

    }
}
