<?php

namespace Aaran\Core\Tenant\Database\Factories;

use Aaran\Core\Tenant\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlanFactory extends Factory
{
    protected $model = Feature::class;

    public function definition()
    {
        return [
            'vname' => $this->faker->safeColorName,
            'price' => $this->faker->unique()->numerify('###'),
            'billing_cycle' => 'monthly',
            'description' => 'description',
            'active_id' => true,
        ];
    }
}

