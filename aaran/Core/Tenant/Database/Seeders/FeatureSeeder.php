<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['vname' => 'Common', 'code' => '100', 'description' => 'common description', 'active_id' => true],
            ['vname' => 'Master', 'code' => '101', 'description' => 'master description', 'active_id' => true],
        ];

        DB::table('features')->insert($features);
    }
}
