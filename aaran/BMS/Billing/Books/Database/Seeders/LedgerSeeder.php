<?php

namespace Aaran\BMS\Billing\Books\Database\Seeders;

use Aaran\BMS\Billing\Books\Models\Ledger;
use Illuminate\Database\Seeder;

class LedgerSeeder extends Seeder
{
    public static function run(): void
    {
        foreach (self::vData() as $head) {

            Ledger::create([
                'id' => $head[0],
                'vname' => $head[1],
                'description' => ucfirst($head[1]),
                'ledger_group_id' => $head[2],
                'opening' => '0',
                'opening_date' => '2024-04-01',
                'current' => '0',
                'active_id' => '1'
            ]);
        }
    }

    private static function vData()
    {
        return [
            ['1', '-', '1'],
        ];
    }
}
