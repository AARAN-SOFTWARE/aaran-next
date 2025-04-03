<?php

namespace Aaran\Master\Database\Factories;

use Aaran\Master\Models\Style;
use Illuminate\Database\Eloquent\Factories\Factory;

class StyleFactory extends Factory
{
    protected $model = Style::class;
    public function definition(): array
    {
        return [
            'vname' => $this->faker->name(),
            'desc' => $this->faker->text(200),
            'company_id' => 1,
            'active_id' => '1',
        ];
    }
}
