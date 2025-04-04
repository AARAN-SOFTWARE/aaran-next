<?php

namespace Aaran\BMS\Billing\Common\Database\Seeders;

use Aaran\BMS\Billing\Common\Models\GstPercent;
use Illuminate\Database\Seeder;

class GstPercentSeeder extends Seeder
{
    public static function run(): void
    {
        $gstRates = [
            '0' => '0%',
            '5' => '5%',
            '12' => '12%',
            '18' => '18%',
            '28' => '28%'
        ];

        foreach ($gstRates as $vname => $description) {
            GstPercent::create([
                'vname' => $vname,
                'description' => $description,
                'active_id' => '1'
            ]);
        }
    }
}

