<?php

namespace Aaran\Common\Database\Seeders;

use Aaran\Common\Models\Category;
use Aaran\Common\Models\Despatch;
use Illuminate\Database\Seeder;

class S114_DespatcheSeeder extends Seeder
{
    public static function run(): void
    {
        Despatch::create([
            'vname' => '-',
            'vdate' => '-',
            'active_id' => '1'
        ]);
    }
}

