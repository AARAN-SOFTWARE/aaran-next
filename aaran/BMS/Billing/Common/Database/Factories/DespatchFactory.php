<?php

namespace Aaran\BMS\Billing\Common\Database\Factories;

use Aaran\BMS\Billing\Common\Models\Despatch;
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
