<?php

namespace Aaran\BMS\Billing\Common\Database\Seeders;

use Aaran\BMS\Billing\Common\Database\Seeders\CountrySeeder;
use Aaran\BMS\Billing\Common\Database\Seeders\GstPercentSeeder;
use Aaran\BMS\Billing\Common\Database\Seeders\StateSeeder;
use Illuminate\Database\Seeder;

class CommonSeeder extends Seeder
{
    public static function run(): void
    {
       CitySeeder::run();
       DistrictSeeder::run();
       StateSeeder::run();
       CountrySeeder::run();
       PincodeSeeder::run();
       HsncodeSeeder::run();
       UnitSeeder::run();
       CategorySeeder::run();
       ColourSeeder::run();
       SizeSeeder::run();
       DepartmentSeeder::run();
       TransportSeeder::run();
       BankSeeder::run();
       ReceipttypeSeeder::run();
       DespatcheSeeder::run();
       GstPercentSeeder::run();
       ContactTypeSeeder::run();
       PaymentModeSeeder::run();
       TransactionTypeSeeder::run();
       AccountTypeSeeder::run();
    }
}
