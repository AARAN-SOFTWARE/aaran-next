<?php

namespace Aaran\BMS\Billing\Common\Database\Seeders;

use Aaran\BMS\Billing\Common\Models\Transport;
use Illuminate\Database\Seeder;

class TransportSeeder extends Seeder
{

    public static function run(): void
    {

        Transport::create([
            'vname' => '-',
            'vehicle_no' => '1',
            'active_id' => '1',
        ]);

        Transport::create([
            'vname' => 'Transport',
            'vehicle_no' => '1',
            'active_id' => '1',
        ]);
    }
}
