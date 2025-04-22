<?php

namespace Aaran\Dashboard\Database\Seeders;

use Aaran\BMS\Billing\Books\Models\Ledger;
use Aaran\Dashboard\Models\DefaultCompany;
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
