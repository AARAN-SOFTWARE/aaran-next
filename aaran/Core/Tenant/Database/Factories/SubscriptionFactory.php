<?php

namespace Aaran\Core\Tenant\Database\Factories;

use Aaran\Core\Tenant\Models\Plan;
use Aaran\Core\Tenant\Models\Subscription;
use Aaran\Core\Tenant\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition()
    {
        return [
            'tenant_id' => Tenant::factory(),
            'plain_id' => Plan::factory(),
            'status' => 'active',
            'started_at' => now(),
            'expires_at' => now()->addMonth(),
        ];
    }
}

