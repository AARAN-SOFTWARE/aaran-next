<?php

namespace Aaran\Common\Database\Seeders;

use Aaran\Common\Models\TransactionType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class S118_TransactionTypeSeeder extends Seeder
{
    public static function run(): void
    {
        DB::table('transaction_types')->updateOrInsert(
            ['id' => 109],
            [
                'vname' => 'New Transaction Type',
                'active_id' => 1,
            ]
        );

//        DB::table('payment_modes')->updateOrInsert(
//            ['id' => 111],
//            ['vname' => 'Bank Transfer', 'active_id' => 1]
//        );
//
//        DB::table('payment_modes')->updateOrInsert(
//            ['id' => 112],
//            ['vname' => 'UPI Payment', 'active_id' => 1]
//        );
//
//        DB::table('payment_modes')->updateOrInsert(
//            ['id' => 113],
//            ['vname' => 'Cash', 'active_id' => 1]
//        );

    }
}
