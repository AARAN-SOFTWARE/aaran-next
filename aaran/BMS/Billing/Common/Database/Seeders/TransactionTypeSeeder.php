<?php

namespace Aaran\BMS\Billing\Common\Database\Seeders;

use Aaran\BMS\Billing\Common\Models\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    public static function run(): void
    {
        TransactionType::create([
           'vname' => 'CASH',
           'active_id' => 1,
        ]);

        TransactionType::create([
            'vname' => 'BANK',
            'active_id' => 1,
        ]);

        TransactionType::create([
            'vname' => 'UPI',
            'active_id' => 1,
        ]);

        TransactionType::create([
            'vname' => '-',
            'active_id' => 1,
        ]);

    }
}
