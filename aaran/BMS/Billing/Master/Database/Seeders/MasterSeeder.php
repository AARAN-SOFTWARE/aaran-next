<?php

namespace Aaran\BMS\Billing\Master\Database\Seeders;

use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    public static function run(): void
    {
        CompanySeeder::run();
//        CompanyDetailSeeder::run();
        ContactSeeder::run();
        ProductSeeder::run();
        OrderSeeder::run();
        StyleSeeder::run();
    }
}
