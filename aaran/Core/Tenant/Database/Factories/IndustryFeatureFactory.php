<?php

namespace Aaran\Core\Tenant\Database\Factories;

use Aaran\Core\Tenant\Models\Feature;
use Aaran\Core\Tenant\Models\Industry;
use Aaran\Core\Tenant\Models\IndustryFeature;
use Illuminate\Database\Eloquent\Factories\Factory;

class IndustryFeatureFactory extends Factory
{
    protected $model = IndustryFeature::class;

    public function definition()
    {
        return [
            'industry_id' => Industry::factory(),
            'feature_id' => Feature::factory(),
            'is_active' => true,
        ];
    }
}

