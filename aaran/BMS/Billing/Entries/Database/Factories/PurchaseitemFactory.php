<?php

namespace Aaran\Entries\Database\Factories;

use Aaran\Common\Models\Common;
use Aaran\BMS\Billing\Entries\Models\Purchase;
use Aaran\BMS\Billing\Entries\Models\Purchaseitem;
use Aaran\BMS\Billing\Master\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseitemFactory extends Factory
{
    protected $model = Purchaseitem::class;

    public function definition(): array
    {
        $product = Product::pluck('id')->random();
        $colour = Common::where('label_id', '=', '7')->pluck('id')->random();
        $size = Common::where('label_id', '=', '8')->pluck('id')->random();

        return [
            'purchase_id' => Purchase::factory(),
            'product_id' => $product,
            'description' => $this->faker->text(25),
            'colour_id' => $colour,
            'size_id' => $size,
            'qty' => $this->faker->numberBetween(1, 1000),
            'price' => $this->faker->numberBetween(1, 500),
            'gst_percent' => 5,
        ];
    }
}
