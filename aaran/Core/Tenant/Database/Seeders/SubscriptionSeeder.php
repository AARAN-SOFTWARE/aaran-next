<?php

namespace Aaran\Core\Tenant\Database\Seeders;

use Aaran\Core\Tenant\Models\Subscription;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    public function run()
    {
        Subscription::create([
            'tenant_id' => 1,
            'user_id' => 1,
            'plan_id' => '1',
            'status' => 'active',
            'started_at' => now(),
            'expires_at' => now()->addYear(),
        ]);
    }
}
