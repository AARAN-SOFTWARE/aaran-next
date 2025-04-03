<?php

namespace Aaran\BMS\Billing\Common\Database\Factories;

use Aaran\BMS\Billing\Common\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'vname' => $this->faker->name,
            'active_id' => 1
        ];
    }
}
