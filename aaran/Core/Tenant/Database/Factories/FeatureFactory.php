<?php

namespace Aaran\Core\Tenant\Database\Factories;

use Aaran\Core\Tenant\Models\Feature;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureFactory extends Factory
{
    protected $model = Feature::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'code' => $this->faker->unique()->numerify('###'),
            'is_active' => true,
        ];
    }
}

