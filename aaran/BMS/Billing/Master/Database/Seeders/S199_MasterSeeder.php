<?php

namespace Aaran\Master\Database\Seeders;


use Illuminate\Database\Seeder;

class S199_MasterSeeder extends Seeder
{
    public static function run(): void
    {
        S200_CompanySeeder::run();
//        S201_CompanyDetailSeeder::run();
        S202_ContactSeeder::run();
        S203_ProductSeeder::run();
        S204_OrderSeeder::run();
        S205_StyleSeeder::run();
    }
}
