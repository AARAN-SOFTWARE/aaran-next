<?php

namespace Aaran\Master\Database\Seeders;

use Aaran\Master\Models\Style;
use Illuminate\Database\Seeder;

class S205_StyleSeeder extends Seeder
{
    public static function run(): void
    {
        Style::create([
            'vname' => '-',
            'desc' => '-',
            'company_id'=>'1',
            'active_id' => '1',
        ]);

    }
}
