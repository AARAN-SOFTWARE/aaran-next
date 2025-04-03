<?php

namespace Aaran\BMS\Billing\Common\Database\Factories;

use Aaran\BMS\Billing\Common\Models\ReceiptType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReceipttypeFactory extends Factory
{

    protected $model = ReceiptType::class;

    public function definition(): array
    {
        return [
            'vname' => $this->faker->name,
            'active_id' => 1
        ];
    }
}
