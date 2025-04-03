<?php

namespace Aaran\BMS\Billing\Common\Database\Factories;

use Aaran\BMS\Billing\Common\Models\Transport;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransportFactory extends Factory
{
    protected $model = Transport::class;

    public function definition(): array
    {
        return [
            'vname' => $this->faker->name,
            'vehicle_no' => $this->faker->bothify(),
            'active_id' => 1
        ];
    }
}
