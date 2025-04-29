<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['vname' => 'Common', 'price' => '1000', 'billing_cycle' => 'monthly', 'description' => 'common description', 'active_id' => true],
            ['vname' => 'Master', 'price' => '2000', 'billing_cycle' => 'yearly', 'description' => 'master description', 'active_id' => true],
        ];

        DB::table('plans')->insert($features);
    }
}
