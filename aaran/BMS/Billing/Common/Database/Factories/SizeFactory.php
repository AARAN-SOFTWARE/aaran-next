<?php

namespace Aaran\BMS\Billing\Common\Database\Factories;

use Aaran\BMS\Billing\Common\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

class SizeFactory extends Factory
{
    protected $model = Size::class;

    public function definition(): array
    {
        return [
            'vname' =>  $this->faker->name,
            'active_id' => 1
        ];
    }
}
