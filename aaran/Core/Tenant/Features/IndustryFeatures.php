<?php

namespace Aaran\Core\Tenant\Features;

use Aaran\Core\Tenant\Models\IndustryFeature;

class IndustryFeatures
{
    public static function all(int $industryId): array
    {
        return IndustryFeature::where('industry_id', $industryId)->pluck('feature')->toArray();
    }

    public static function has(int $industryId, string $feature): bool
    {
        return in_array($feature, self::all($industryId));
    }
}
