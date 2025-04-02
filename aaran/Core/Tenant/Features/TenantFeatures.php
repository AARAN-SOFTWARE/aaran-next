<?php

namespace Aaran\Core\Tenant\Features;

use Aaran\Core\Tenant\Models\TenantFeature;

class TenantFeatures
{
    public static function all(int $tenantId): array
    {
        return TenantFeature::where('tenant_id', $tenantId)->pluck('feature')->toArray();
    }

    public static function has(int $tenantId, string $feature): bool
    {
        return in_array($feature, self::all($tenantId));
    }

    public static function enable(int $tenantId, string $feature): void
    {
        TenantFeature::firstOrCreate(['tenant_id' => $tenantId, 'feature' => $feature]);
    }

    public static function disable(int $tenantId, string $feature): void
    {
        TenantFeature::where(['tenant_id' => $tenantId, 'feature' => $feature])->delete();
    }
}
