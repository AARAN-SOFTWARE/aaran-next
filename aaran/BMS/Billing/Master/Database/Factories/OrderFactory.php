<?php

namespace Aaran\Master\Database\Factories;

use Aaran\Master\Models\Company;
use Aaran\Master\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;


class OrderFactory extends Factory
{
    protected $model = Order::class;


    public function definition(): array
    {
        $company = Company::pluck('id');

        return [
            'vname' => $this->faker->name(),
            'order_name' => $this->faker->name(),
            'company_id' => $company->random(),
            'active_id' => '1'
        ];
    }
}
