<?php

namespace Aaran\BMS\Billing\Master\Database\Seeders;

use Aaran\BMS\Billing\Master\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public static function run(): void
    {
        Order::create([
            'vname' => 'Demo Order',
            'order_name' => '-',
            'active_id' => true,
        ]);

    }
}
