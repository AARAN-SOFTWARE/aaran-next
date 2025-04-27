<?php

namespace Aaran\BMS\Billing\Baseline\Database\Seeders;

use Aaran\BMS\Billing\Baseline\Models\DefaultCompany;
use Illuminate\Database\Seeder;

class DefaultCompanySeeder extends Seeder
{
    public static function run(): void
    {
        DefaultCompany::create([
            'company_id' => '1',
            'acyear_id' => '1'
        ]);
    }

}
