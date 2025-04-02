<?php

namespace Aaran\Core\Setup\Database\Seeders;

use Aaran\Core\Tenant\Database\Seeders\TenantSeeder;
use Aaran\Core\User\Database\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            TenantSeeder::class,
            UserSeeder::class,
        ]);
    }
}
