<?php

namespace Aaran\Common\Database\Seeders;

use Aaran\Common\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public static function run(): void
    {
        Department::create([
            'vname' => '-',
            'active_id' => '1'
        ]);

        Department::create([
            'vname' => 'cs',
            'active_id' => '1'
        ]);
    }
}

