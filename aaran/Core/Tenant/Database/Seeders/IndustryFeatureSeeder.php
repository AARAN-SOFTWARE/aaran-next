<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustryFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $industryFeatures = [
            // Developer Features
            ['industry_id' => 1, 'feature_id' => 1], // Common
            ['industry_id' => 1, 'feature_id' => 2], // Master
            ['industry_id' => 1, 'feature_id' => 3], // Entries

            // Offset Printing Features
            ['industry_id' => 2, 'feature_id' => 1], // Common
            ['industry_id' => 2, 'feature_id' => 4], // Core
            ['industry_id' => 2, 'feature_id' => 5], // Blog

            // SK Printers Features
            ['industry_id' => 3, 'feature_id' => 1], // Common
            ['industry_id' => 3, 'feature_id' => 6], // GST API
            ['industry_id' => 3, 'feature_id' => 7], // Transaction
        ];

        DB::table('industry_features')->insert($industryFeatures);
    }
}
