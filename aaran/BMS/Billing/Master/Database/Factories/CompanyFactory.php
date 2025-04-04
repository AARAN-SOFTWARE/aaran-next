<?php

namespace Aaran\Master\Database\Factories;

use Aaran\Auth\Identity\Models\User;
use Aaran\BMS\Billing\Common\Models\Bank;
use Aaran\BMS\Billing\Common\Models\City;
use Aaran\BMS\Billing\Common\Models\Pincode;
use Aaran\BMS\Billing\Common\Models\State;
use Aaran\BMS\Billing\Master\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;
    public function definition(): array
    {
        $users = User::pluck('id')->random();
        $cities = City::pluck('id')->random();
        $states = State::pluck('id')->random();
        $pincodes = Pincode::pluck('id')->random();
        $banks = Bank::pluck('id')->random();

        return [
            'vname' => $this->faker->company,
            'display_name' => $this->faker->name,
            'address_1' => $this->faker->address,
//            'address_2' => $this->faker->address,
            'mobile' => $this->faker->phoneNumber,
            'landline' => $this->faker->phoneNumber,
            'gstin' => $this->faker->phoneNumber(),
            'pan' => $this->faker->creditCardNumber(),
            'email' => $this->faker->companyEmail,
            'website' => $this->faker->url,
            'city_id' => $cities,
            'state_id' => $states,
            'pincode_id' => $pincodes,
            'bank' => $banks,
            'acc_no' => $this->faker->creditCardNumber(),
            'ifsc_code' => $this->faker->creditCardNumber(),
            'branch' => $this->faker->creditCardNumber(),
            'msme_no' => $this->faker->creditCardNumber(),
            'msme_type' => $this->faker->creditCardNumber(),
            'active_id' => '1',
            'user_id' => $users,
            'tenant_id' => '1'
        ];
    }
}
