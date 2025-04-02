<?php

namespace Aaran\Common\Database\Factories;

use Aaran\Common\Models\Despatch;
use Illuminate\Database\Eloquent\Factories\Factory;

class DespatchFactory extends Factory
{
    protected $model = Despatch::class;

    public function definition(): array
    {
        return [
            'vname' => $this->faker->randomNumber(5),
            'vdate' => $this->faker->date,
            'active_id' => '1'
        ];
    }
}
