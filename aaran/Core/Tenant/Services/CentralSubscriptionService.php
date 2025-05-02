<?php

namespace Aaran\Core\Tenant\Services;

use Aaran\Core\Tenant\Models\Subscription;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class CentralSubscriptionService
{
    /**
     * Get subscription for a tenant by ID (with caching).
     */
    public static function getForTenant(string $tenantId): ?Subscription
    {
//        return Cache::remember("subscription:$tenantId", now()->addMinutes(5), function () use ($tenantId) {

            return Subscription::with('plan')
                ->where('tenant_id', $tenantId)
                ->where('expires_at', '>', Carbon::now())
                ->latest()
                ->first();
//        });
    }

    /**
     * Check if tenant's subscription is valid.
     */
    public static function isValid(string $tenantId): bool
    {
        $subscription = self::getForTenant($tenantId);
        return $subscription && $subscription->expires_at && now()->lt($subscription->expires_at);
    }

    /**
     * Get plan feature for current tenant.
     */
    public static function getFeature(string $tenantId, string $featureKey, $default = null)
    {
        $subscription = self::getForTenant($tenantId);

        if (!$subscription || !$subscription->plan) {
            return $default;
        }

        $features = $subscription->plan->features;
        return $features[$featureKey] ?? $default;
    }
}
