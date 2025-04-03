<?php

namespace Aaran\BMS\Billing\Common\Database\Seeders;

use Aaran\BMS\Billing\Common\Models\Despatch;
use Illuminate\Database\Seeder;

class DespatcheSeeder extends Seeder
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

