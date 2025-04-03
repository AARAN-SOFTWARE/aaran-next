<?php

namespace Aaran\Books\Database\Factories;

use Aaran\BMS\Billing\Books\Models\LedgerGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class LedgerGroupFactory extends Factory
{
    protected $model = LedgerGroup::class;

    public function definition(): array
    {
        return [
            'vname' => $this->faker->name,
            'description' => $this->faker->sentence(10),
            'account_head_id' => '1',
            'opening' => '0',
            'opening_date' => '2025-01-01',
            'current' => '0',
            'active_id' => '1',
            'user_id' => '1',
        ];
    }
}
