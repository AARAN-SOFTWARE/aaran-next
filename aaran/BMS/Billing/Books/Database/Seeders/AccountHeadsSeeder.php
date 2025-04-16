<?php

namespace Aaran\BMS\Billing\Books\Database\Seeders;

use Aaran\BMS\Billing\Books\Models\AccountHeads;
use Illuminate\Database\Seeder;

class AccountHeadsSeeder extends Seeder
{
    public static function run(): void
    {
        foreach (self::vData() as $head) {

            AccountHeads::create([
                'id' => $head[0],
                'vname' => $head[1],
                'description' => ucfirst($head[1]),
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
            ['1', 'PRIMARY'],
            ['2', 'BRANCH-DIVISION'],
            ['3', 'CAPITAL ACCOUNT'],
            ['4', 'CURRENT ASSETS'],
            ['5', 'CURRENT LIABILITIES'],
            ['6', 'DIRECT EXPENSE'],
            ['7', 'DIRECT INCOME'],
            ['8', 'FIXED ASSETS'],
            ['9', 'INDIRECT EXPENSE'],
            ['10', 'INDIRECT INCOMES'],
            ['11', 'INVESTMENTS'],
            ['12', 'LOANS AND LIABILITIES'],
            ['13', 'MISC EXPENSE'],
            ['14', 'PURCHASES ACCOUNT'],
            ['15', 'SALES ACCOUNT'],
            ['16', 'SUSPENSE ACCOUNT'],
        ];
    }
}
