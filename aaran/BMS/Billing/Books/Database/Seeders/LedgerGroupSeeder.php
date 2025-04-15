<?php

namespace Aaran\BMS\Billing\Books\Database\Seeders;

use Aaran\BMS\Billing\Books\Models\LedgerGroup;
use Illuminate\Database\Seeder;

class LedgerGroupSeeder extends Seeder
{
    public static function run(): void
    {
        foreach (self::vData() as $head) {

            LedgerGroup::create([
                'id' => $head[0],
                'vname' => $head[1],
                'description' => ucfirst($head[1]),
                'account_head_id' => $head[2],
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

            ['2', 'ADVANCE', '4'],
            ['3', 'BANK ACCOUNT', '4'],
            ['4', 'CASH IN HAND', '4'],
            ['5', 'DEPOSIT ACCOUNT', '4'],
            ['6', 'STOCK IN HAND', '4'],
            ['7', 'DEBTORS', '4'],

            ['8', 'DUTIES & TAXES', '5'],
            ['9', 'PROVISIONS', '5'],
            ['10', 'CREDITORS', '5'],

            ['11', 'DIRECT EXPENSE', '1'],
            ['12', 'DIRECT INCOME', '1'],
            ['13', 'FIXED ASSETS', '1'],
            ['14', 'INDIRECT EXPENSE', '1'],
            ['15', 'INDIRECT INCOMES', '1'],
            ['16', 'INVESTMENTS', '1'],

            ['17', 'BANK OCC ACCOUNT', '12'],
            ['18', 'BANK OD ACCOUNT', '12'],
            ['19', 'UNSECURED LOANS', '12'],

            ['20', 'FABRIC SALE', '15'],
            ['21', 'GARMENT SALE', '15'],
            ['22', 'ACCESSORIES SALE', '15'],

            ['23', 'FABRIC PURCHASE', '14'],
            ['24', 'GARMENT PURCHASE', '14'],
            ['25', 'ACCESSORIES PURCHASE', '14'],

            ['26', 'MISC EXPENSE', '1'],
            ['27', 'RESERVES & SURPLUS', '1'],
            ['28', 'RETAINED EARNINGS', '1'],
            ['29', 'SECURED LOANS', '1'],
            ['30', 'SUSPENSE ACCOUNT', '1'],
        ];
    }
}
