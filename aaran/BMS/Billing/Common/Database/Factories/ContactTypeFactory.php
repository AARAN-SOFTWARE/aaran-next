<?php

namespace Aaran\BMS\Billing\Common\Database\Factories;

use Aaran\BMS\Billing\Common\Models\ContactType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactTypeFactory extends Factory
{
    protected $model = ContactType::class;

    public function definition(): array
    {
        return [
            'vname' => $this->faker->name,
            'active_id' => 1
        ];
    }
}
