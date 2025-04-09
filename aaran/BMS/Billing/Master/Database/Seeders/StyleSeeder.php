<?php

namespace Aaran\BMS\Billing\Master\Database\Seeders;

use Aaran\BMS\Billing\Master\Models\Style;
use Illuminate\Database\Seeder;

class StyleSeeder extends Seeder
{
    public static function run(): void
    {
        Style::create([
            'vname' => 'Demo Style',
            'description' => '-',
            'active_id' => true,
        ]);

    }
}
