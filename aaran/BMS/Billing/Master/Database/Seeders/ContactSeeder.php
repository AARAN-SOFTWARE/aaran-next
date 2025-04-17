<?php

namespace Aaran\BMS\Billing\Master\Database\Seeders;

use Aaran\BMS\Billing\Master\Models\Contact;
use Aaran\BMS\Billing\Master\Models\ContactAddress;
use Aaran\BMS\Billing\Master\Models\ContactBank;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public static function run(): void
    {
        Contact::create([
            'vname'=>'XYZ company pvt ltd',
            'mobile'=>'0123456789',
            'whatsapp'=>'0123456789',
            'contact_person'=>'sundar',
            'contact_type_id'=>'1',
            'gstin'=>'29AWGPV7107B1Z1',
            'email'=>'email@email.com',
            'msme_no'=>'123456789',
            'msme_type_id'=>'1',
            'opening_balance'=>0,
            'outstanding'=>0,
            'effective_from'=>'2025-04-01',
            'active_id'=> true ,
        ]);

        ContactAddress::create([
            'contact_id'=>'1',
            'address_1'=>'3rd street',
            'address_2'=>'Postal Colony',
            'city_id'=>'2',
            'state_id'=>'2',
            'country_id'=>'1',
            'pincode_id'=>'2',
        ]);

        ContactBank::create([
            'contact_id'=>'1',
            'bank_type'=>'CA',
            'acc_no'=>'123456789',
            'ifsc_code'=>'ABCD1234FGH',
            'bank'=>'State Bank Of India',
            'branch'=>'P.N.Road Branch',
        ]);

    }
}
