<?php

namespace Aaran\BMS\Billing\Master\Database\Seeders;

use Aaran\BMS\Billing\Master\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public static function run(): void
    {
        Product::create([
            'vname' => 'T-SHIRT',
            'product_type_id' => '1',
            'hsncode_id' => '2',
            'unit_id' => '3',
            'gst_percent_id' => '2',
            'initial_quantity' => 0,
            'initial_price' => 0,
            'active_id' => true,
        ]);

        Product::create([
            'vname' => 'Track Pant',
            'product_type_id' => '1',
            'hsncode_id' => '2',
            'unit_id' => '3',
            'gst_percent_id' => '2',
            'initial_quantity' => 0,
            'initial_price' => 0,
            'active_id' => true,
        ]);
    }
}
