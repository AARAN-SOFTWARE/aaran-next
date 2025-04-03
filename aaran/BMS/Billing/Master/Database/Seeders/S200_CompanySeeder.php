<?php

namespace Aaran\Master\Database\Seeders;

use Aaran\Master\Models\Company;
use Illuminate\Database\Seeder;

class S200_CompanySeeder extends Seeder
{
    public static function run(): void
    {
        Company::create([
            'vname' => 'CODEXSUN SOFTWARES PVT LTD',
            'display_name' => 'CODEXSUN SOFTWARES PVT LTD',
            'address_1' => '1,44-1, Venkatappa Gounder Layout Main Road',
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
            'active_id' => '1',
            'user_id' => '1',
            'tenant_id' => '1',
            'logo' => 'no_image'
        ]);
    }
}
