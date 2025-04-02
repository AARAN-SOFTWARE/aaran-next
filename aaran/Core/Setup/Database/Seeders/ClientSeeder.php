<?php

namespace Aaran\Core\Setup\Database\Seeders;

use Aaran\Common\Database\Seeders\CommonSeeder;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
           CommonSeeder::class,
        ]);
    }
}
