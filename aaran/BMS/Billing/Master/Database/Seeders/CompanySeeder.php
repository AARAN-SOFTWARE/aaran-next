<?php

namespace Aaran\BMS\Billing\Master\Database\Seeders;

use Aaran\BMS\Billing\Master\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public static function run(): void
    {
        Company::create([
            'vname' => 'AARAN SOFTWARE PVT LTD',
            'display_name' => 'AARAN SOFTWARE PVT LTD',
            'address_1' => '7, Anjal Nagar 3rd street',
            'address_2' => 'Postal Colony',
            'mobile' => '9655227738',
            'landline' => '-',
            'gstin' => '29AABCT1332L000',
            'pan' => '-',
            'email' => '-',
            'website' => '-',
            'city_id'=>'2',
            'state_id'=>'2',
            'pincode_id'=>'2',
            'country_id'=>'2',
            'bank'=>'Demo Bank',
            'acc_no'=>'D123456789101112',
            'ifsc_code'=>'DEMO1234',
            'branch'=>'DEMO BRANCH',
            'inv_pfx'=>'',
            'iec_no'=>'-',
            'msme_no'=>'-',
            'msme_type_id' => '1',
            'active_id' => true,
            'logo' => 'no_image'
        ]);
    }
}
