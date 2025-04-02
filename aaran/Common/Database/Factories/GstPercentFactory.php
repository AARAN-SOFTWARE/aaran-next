<?php

namespace Aaran\Common\Database\Factories;

use Aaran\Common\Models\GstPercent;
use Illuminate\Database\Eloquent\Factories\Factory;

class GstPercentFactory extends Factory
{
    protected $model = GstPercent::class;

    public function definition(): array
    {
        return [
            'vname' => $this->faker->name,
            'active_id' => 1
        ];
    }
}
