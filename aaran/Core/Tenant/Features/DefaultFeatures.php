<?php

namespace Aaran\Core\Tenant\Features;

class DefaultFeatures
{
    public static function all(): array
    {
        return config('features');
    }

    public static function has(string $feature): bool
    {
        return collect(self::all())->flatten()->contains($feature);
    }
}
