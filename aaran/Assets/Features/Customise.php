<?php

namespace Aaran\Assets\Features;

class Customise
{
    /**
     * Check if a feature is enabled for the current industry.
     */
    public static function enabled(string $feature): bool
    {
        $industryCode = config('aaran-app.app_code'); // Get current industry code

        $industryName = self::getIndustryName($industryCode);

        return in_array($feature, config("$industryName.customise", []), true);
    }

    /**
     * Convert industry code (e.g., 100) to industry name (e.g., 'developer')
     */
    protected static function getIndustryName(?string $code): ?string
    {
        $industries = array_flip(config('software', [])); // Reverse map ['100' => 'DEVELOPER']

        return isset($industries[$code]) ? strtolower($industries[$code]) : null;
    }

    /**
     * Feature list mapping
     */
    protected static array $features = [
        'common'        => 'Common',
        'company'       => 'Master',
        'entries'       => 'Entries',
        'blog'          => 'Blog',
        'core'          => 'Core',
        'gstapi'        => 'GstApi',
        'transaction'   => 'Transaction',
        'exportSales'   => 'ExportSales',
        'report'        => 'Report',
        'logbooks'      => 'LogBook',
        'books'         => 'Books',
    ];

    /**
     * Magic method for checking features dynamically.
     */
    public static function __callStatic($name, $arguments)
    {
        if (str_starts_with($name, 'has')) {
            $featureKey = lcfirst(str_replace('has', '', $name));
            return isset(self::$features[$featureKey]) ? self::enabled($featureKey) : false;
        }

        return null;
    }
}
