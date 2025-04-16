<?php

namespace Aaran\BMS\Billing\Entries\Database\Seeders;

use Aaran\BMS\Billing\Entries\Models\Sale;
use Aaran\BMS\Billing\Entries\Models\SaleItem;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{

    public static function run(): void
    {
        Sale::create([
            'uniqueno' => '1',
            'acyear' => session()->get('acyear'),
            'company_id' => '1',
            'contact_id' => '1',
            'order_id' => '1',
            'invoice_no' => '1',
            'invoice_date' => '2024-03-09',
            'sales_type' => '1',
            'transport_id' => '1',
            'destination' => '',
            'bundle' => '1',
            'total_qty' => '200',
            'total_taxable' => '1',
            'total_gst' => '2',
            'ledger_id' => '1',
            'additional' => '0',
            'round_off' => '0',
            'grand_total' => '0',
            'active_id' => '1'

        ]);
        SaleItem::create([
            'sale_id' => '1',
            'product_id' => '1',
            'colour_id' => '1',
            'size_id' => '1',
            'qty' => '200',
            'price' => '0',
            'gst_percent' => '2',
        ]);
    }
}
