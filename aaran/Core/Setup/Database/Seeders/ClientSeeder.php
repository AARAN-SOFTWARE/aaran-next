<?php

namespace Aaran\Core\Setup\Database\Seeders;

use Aaran\BMS\Billing\Books\Database\Seeders\BooksSeeder;
use Aaran\BMS\Billing\Common\Database\Seeders\CommonSeeder;
use Aaran\BMS\Billing\Master\Database\Seeders\MasterSeeder;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CommonSeeder::class,
            BooksSeeder::class,
            MasterSeeder::class,
        ]);
    }
}
