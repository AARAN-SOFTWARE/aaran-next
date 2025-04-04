<?php

namespace Aaran\Master\Database\Factories;

use Aaran\Assets\Enums\ProductType;
use Aaran\Auth\Identity\Models\User;
use Aaran\BMS\Billing\Common\Models\GstPercent;
use Aaran\BMS\Billing\Common\Models\Hsncode;
use Aaran\BMS\Billing\Common\Models\Unit;
use Aaran\BMS\Billing\Master\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $product_name = [
            '100% COTTON IN CHECKS FABRIC ',
            '100% Cotton Knitted Dyed Fabrics ',
            '100% Cotton Knitted Hosiery Dyed Fab (180 Gsm)'
        ];
        $users = User::pluck('id');
        $product_type = Arr::random(ProductType::cases());
        $hsncodes = Hsncode::pluck('id')->random();
        $units = Unit::pluck('id')->random();
        $gstpercents = GstPercent::pluck('id')->random();

        return [
            'vname' => $product_name[array_rand($product_name)],
            'producttype_id' => $product_type,
            'hsncode_id' => $hsncodes,
            'unit_id' => $units,
            'gstpercent_id' => $gstpercents,
            'initial_quantity' => $this->faker->numberBetween(1, 100),
            'initial_price' => $this->faker->numberBetween(1, 100),
            'active_id' => '1',
            'user_id' => $users->random(),
            'company_id' => '1',

        ];
    }
}
