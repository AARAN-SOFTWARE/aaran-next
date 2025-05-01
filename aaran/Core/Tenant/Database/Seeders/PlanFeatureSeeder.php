<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['plan_id' => '1', 'feature_id' => '1', 'active_id' => true],
            ['plan_id' => '1', 'feature_id' => '2', 'active_id' => true],
            ['plan_id' => '2', 'feature_id' => '1', 'active_id' => true],
            ['plan_id' => '2', 'feature_id' => '2', 'active_id' => true],
        ];

        DB::table('plan_features')->insert($features);
    }
}
