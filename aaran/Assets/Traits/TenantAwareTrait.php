<?php

namespace Aaran\Assets\Traits;

use Aaran\Core\Tenant\Facades\TenantManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

trait TenantAwareTrait
{
    private function getTenantConnection(): string
    {


        if (config('database.default') === 'tenant' && Session::has('tenant_db_config')) {
            return 'tenant';
        }


        $tenantId = session('tenant_id');


        if ($tenantId && TenantManager::switchTenant($tenantId)) {
            \Log::info('💾 DB connection being used: ' . $tenantId);
            return 'tenant';
        } else {
            Log::error("Failed to switch to tenant. Session tenant_id: " . ($tenantId ?? 'null'));
            return "Failed to switch to tenant. Session tenant_id: " . ($tenantId ?? 'null');

        }

        return config('database.default');
    }
}

