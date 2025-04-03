<?php

namespace Aaran\BMS\Billing\Common\Database\Seeders;

use Aaran\BMS\Billing\Common\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public static function run(): void
    {
        Category::create([
            'vname' => '-',
            'active_id' => '1'
        ]);
    }
}

