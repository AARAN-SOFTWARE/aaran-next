<?php

namespace Aaran\BMS\Billing\Common\Database\Factories;

use Aaran\BMS\Billing\Common\Models\Colour;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColourFactory extends Factory
{
    protected $model = Colour::class;

    public function definition(): array
    {
        return [
            'vname' => $this->faker->name,
            'active_id' => 1
        ];
    }
}
