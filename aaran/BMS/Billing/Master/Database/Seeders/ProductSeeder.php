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
            'hsncode_id' => '1',
            'unit_id' => '1',
            'gst_percent_id' => '1',
            'initial_quantity' => 0,
            'initial_price' => 0,
            'active_id' => true,
        ]);
    }
}
