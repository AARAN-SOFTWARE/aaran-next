<?php

namespace Aaran\Master\Database\Seeders;

use Aaran\Master\Models\Order;
use Illuminate\Database\Seeder;

class S204_OrderSeeder extends Seeder
{
    public static function run(): void
    {
        Order::create([
            'vname' => '-',
            'order_name' => '-',
            'company_id' => '1',
            'active_id' => '1'
        ]);

    }
}
