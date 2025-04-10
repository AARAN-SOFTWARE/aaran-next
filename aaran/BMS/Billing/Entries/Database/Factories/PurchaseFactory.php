<?php

namespace Aaran\Entries\Database\Factories;

use Aaran\Common\Models\Common;
use Aaran\BMS\Billing\Entries\Models\Purchase;
use Aaran\BMS\Billing\Master\Models\Company;
use Aaran\BMS\Billing\Master\Models\Contact;
use Aaran\BMS\Billing\Master\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{

    protected $model = Purchase::class;
    public function definition(): array
    {
        $company = Company::pluck('id')->random();
        $contact = Contact::pluck('id')->random();
        $order = Order::pluck('id')->random();
        $transport = Common::where('label_id','=','1')->pluck('id')->random();
        $ledger = Common::where('label_id','=','10')->pluck('id')->random();


        return [
            'uniqueno' => $this->faker->unique()->numberBetween(1, 9999),
            'acyear' => '2024_25',
            'company_id' => $company,
            'contact_id' => $contact,
            'order_id' =>  $order,
            'purchase_no' => $this->faker->unique()->numberBetween(1, 9999),
            'purchase_date' => $this->faker->dateTimeThisMonth()->format('Y-m-d'),
            'Entry_no' => $this->faker->unique()->numberBetween(1, 9999),
            'sales_type' => '1',
            'transport_id' =>  $transport,
            'bundle' => 5,
            'total_qty' => $this->faker->numberBetween(1, 9999),
            'total_taxable' =>$this->faker->numberBetween(1, 9999),
            'total_gst' => $this->faker->numberBetween(1, 9999),
            'ledger_id' => $ledger,
            'additional' => 0,
            'round_off' => 0,
            'grand_total' => $this->faker->numberBetween(1, 9999),
            'active_id' => 1,
        ];
    }
}
