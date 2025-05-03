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
            ['vname' => 'Starter', 'price' => '1000', 'billing_cycle' => 'monthly', 'description' => ' Starter Plan', 'active_id' => true],
            ['vname' => 'Standard', 'price' => '2000', 'billing_cycle' => 'monthly', 'description' => 'Standard Plan', 'active_id' => true],
            ['vname' => 'professional', 'price' => '5000', 'billing_cycle' => 'monthly', 'description' => 'Professional Plan', 'active_id' => true],
            ['vname' => 'Enterprises', 'price' => '10000', 'billing_cycle' => 'monthly', 'description' => 'Enterprise Plan', 'active_id' => true],
        ];

        DB::table('plans')->insert($features);
    }
}
