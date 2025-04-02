<?php

namespace Aaran\Common\Database\Factories;

use Aaran\Common\Models\Size;
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
