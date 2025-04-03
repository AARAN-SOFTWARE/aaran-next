<?php

namespace Aaran\BMS\Billing\Common\Database\Seeders;

use Aaran\BMS\Billing\Common\Models\PaymentMode;
use Illuminate\Database\Seeder;

class PaymentModeSeeder extends Seeder
{
    public static function run(): void
    {
        PaymentMode::create([
            'vname' => 'Payment',
            'active_id' => '1'
        ]);

        PaymentMode::create([
            'vname' => 'Receipt',
            'active_id' => '1'
        ]);

    }
}
