<?php

namespace Aaran\Core\Tenant\Database\Factories;

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
            'plan_name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'status' => 'active',
            'started_at' => now(),
            'expires_at' => now()->addMonth(),
        ];
    }
}

