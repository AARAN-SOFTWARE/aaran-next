<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['vname' => 'User',                     'code' => '100', 'description' => 'Basic common functionality', 'active_id' => true],
            ['vname' => 'Invoice Creation',         'code' => '101', 'description' => 'Master module access', 'active_id' => true],
            ['vname' => 'Recurring Invoices',       'code' => '102', 'description' => 'Generate recurring invoices for subscriptions', 'active_id' => true],
            ['vname' => 'Online Payments',          'code' => '103', 'description' => 'Integration with payment gateways like Stripe or PayPal', 'active_id' => true],
            ['vname' => 'Custom Invoice Branding',  'code' => '104', 'description' => 'Allows adding your logo, color scheme, and custom footer', 'active_id' => true],
            ['vname' => 'Tax Handling',             'code' => '105', 'description' => 'Automatic tax calculation (e.g., VAT, GST)', 'active_id' => true],
            ['vname' => 'Multi-Currency Support',   'code' => '106', 'description' => 'Supports billing in multiple currencies', 'active_id' => true],
            ['vname' => 'Analytics Reports',        'code' => '107', 'description' => 'Provides insights and financial reports', 'active_id' => true],
            ['vname' => 'Multi-User Access',        'code' => '108', 'description' => 'Allows multiple users to access the system with roles', 'active_id' => true],
            ['vname' => 'API Access',               'code' => '109', 'description' => 'Access to developer API for custom integrations', 'active_id' => true],
            ['vname' => 'Audit Logs',               'code' => '110', 'description' => 'Track user actions for compliance', 'active_id' => true],
            ['vname' => 'Priority Support',         'code' => '111', 'description' => 'Priority Support with Dedicated Manager', 'active_id' => true],
        ];


        DB::table('features')->insert($features);
    }
}
