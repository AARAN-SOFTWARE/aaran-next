<?php

namespace Aaran\Common\Database\Factories;

use Aaran\Common\Models\PaymentMode;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentModeFactory extends Factory
{
    protected $model = PaymentMode::class;
    public function definition(): array
    {
        return [
            'vname' => $this->faker->name,
            'active_id' => 1
        ];
    }
}
