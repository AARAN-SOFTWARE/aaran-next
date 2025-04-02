<?php

namespace Aaran\Common\Database\Factories;

use Aaran\Common\Models\Colour;
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
