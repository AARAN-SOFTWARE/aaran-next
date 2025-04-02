<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustrySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            ['name' => 'Developer', 'code' => 'DEVELOPER'],
            ['name' => 'Offset Printing', 'code' => 'OFFSET'],
            ['name' => 'SK Printers', 'code' => 'SK_PRINTERS'],
            ['name' => 'SK Enterprises', 'code' => 'SK_ENTERPRISES'],
        ];

        DB::table('industries')->insert($industries);
    }
}
