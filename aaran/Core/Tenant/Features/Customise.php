<?php

namespace Aaran\Core\Tenant\Features;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Support\Facades\Cache;

class Customise
{
    protected static ?array $enabledFeatures = null;

    public static function load(Tenant $tenant)
    {
        self::$enabledFeatures = Cache::remember("tenant_{$tenant->id}_features", 600, function () use ($tenant) {
            return $tenant->enabled_features ?? [];
        });
    }

    public static function hasFeature(string $featureCode): bool
    {
        return in_array($featureCode, self::$enabledFeatures ?? []);
    }

    public static function hasCommon(): bool
    {
        return self::hasFeature('hasCommon');
    }

    public static function hasContact(): bool
    {
        return self::hasFeature('hasContact');
    }

    public static function hasSales(): bool
    {
        return self::hasFeature('hasSales');
    }

    public static function hasPurchase(): bool
    {
        return self::hasFeature('hasPurchase');
    }

    public static function hasGSTin(): bool
    {
        return self::hasFeature('hasGSTin');
    }

    public static function hasEway(): bool
    {
        return self::hasFeature('hasEway');
    }

    public static function hasMSME(): bool
    {
        return self::hasFeature('hasMSME');
    }

    public static function hasSecondaryAddress(): bool
    {
        return self::hasFeature('hasSecondaryAddress');
    }

    public static function hasCreditLimit(): bool
    {
        return self::hasFeature('hasCreditLimit');
    }

    public static function hasDc(): bool
    {
        return self::hasFeature('hasDc');
    }

    public static function hasPO(): bool
    {
        return self::hasFeature('hasPO');
    }

    public static function hasStyle(): bool
    {
        return self::hasFeature('hasStyle');
    }

    public static function hasColour(): bool
    {
        return self::hasFeature('hasColour');
    }
}
