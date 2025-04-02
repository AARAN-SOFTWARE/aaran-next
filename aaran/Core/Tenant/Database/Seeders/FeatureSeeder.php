<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['name' => 'Common', 'code' => 'common'],
            ['name' => 'Master', 'code' => 'master'],
            ['name' => 'Entries', 'code' => 'entries'],
            ['name' => 'Core', 'code' => 'core'],
            ['name' => 'Blog', 'code' => 'blog'],
            ['name' => 'GST API', 'code' => 'gstapi'],
            ['name' => 'Transaction', 'code' => 'transaction'],
            ['name' => 'Export Sales', 'code' => 'exportSales'],
            ['name' => 'Report', 'code' => 'report'],
            ['name' => 'Log Books', 'code' => 'logbooks'],
            ['name' => 'Books', 'code' => 'books'],
        ];

        DB::table('features')->insert($features);
    }
}
