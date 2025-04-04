<?php

namespace Aaran\Master\Database\Seeders;

use Aaran\BMS\Billing\Master\Models\Product;
use Illuminate\Database\Seeder;

class S203_ProductSeeder extends Seeder
{
    public static function run(): void
    {
        Product::create([
            'vname' => 'T-SHIRT',
            'producttype_id' => '1',
            'hsncode_id' => '1',
            'unit_id' => '1',
            'gstpercent_id' => '1',
            'initial_quantity' => 0,
            'initial_price' => 0,
            'active_id' => '1',
            'user_id' => '1',
            'company_id' => '1',
        ]);
    }
}
