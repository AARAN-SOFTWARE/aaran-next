<?php

namespace Aaran\BMS\Billing\Common\Database\Factories;

use Aaran\BMS\Billing\Common\Models\GstPercent;
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
