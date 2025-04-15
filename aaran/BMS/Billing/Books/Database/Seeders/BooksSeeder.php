<?php

namespace Aaran\BMS\Billing\Books\Database\Seeders;

use Aaran\Books\Database\Seeders\AccountHeadsSeeder;
use Aaran\Books\Database\Seeders\LedgerGroupSeeder;
use Aaran\Books\Database\Seeders\LedgerSeeder;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    public static function run(): void
    {
        AccountHeadsSeeder::run();
        LedgerGroupSeeder::run();
        LedgerSeeder::run();
    }
}
