<?php

namespace Aaran\Common\Database\Seeders;

use Illuminate\Database\Seeder;

class S000_CommonSeeder extends Seeder
{
    public static function run(): void
    {
       S101_CitySeeder::run();
       S101_DistrictSeeder::run();
       S102_StateSeeder::run();
       S103_CountrySeeder::run();
       S104_PincodeSeeder::run();
       S105_HsncodeSeeder::run();
       S106_UnitSeeder::run();
       S107_CategorySeeder::run();
       S108_ColourSeeder::run();
       S109_SizeSeeder::run();
       S110_DepartmentSeeder::run();
       S111_TransportSeeder::run();
       S112_BankSeeder::run();
       S113_ReceipttypeSeeder::run();
       S114_DespatcheSeeder::run();
       S115_GstPercentSeeder::run();
       S116_ContactTypeSeeder::run();
       S117_PaymentModeSeeder::run();
       S118_TransactionTypeSeeder::run();
       S119_AccountTypeSeeder::run();
    }
}
