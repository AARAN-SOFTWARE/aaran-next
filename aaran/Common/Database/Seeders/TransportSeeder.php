<?php

namespace Aaran\Common\Database\Seeders;

use Aaran\Common\Models\Transport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'vname' => 'transport',
            'vehicle_no' => '1',
            'active_id' => '1',
        ]);
    }
}
