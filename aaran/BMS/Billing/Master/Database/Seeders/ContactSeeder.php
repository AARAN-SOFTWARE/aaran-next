<?php

namespace Aaran\BMS\Billing\Master\Database\Seeders;

use Aaran\BMS\Billing\Master\Models\Contact;
use Aaran\BMS\Billing\Master\Models\ContactAddress;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    public static function run(): void
    {
        Contact::create([
            'vname'=>'XYZ company pvt ltd',
            'gstin'=>'29AWGPV7107B1Z1',
            'active_id'=> true ,
            'contact_type_id'=>'1',
            'whatsapp'=>'0123456789',
            'mobile'=>'0123456789',
            'contact_person'=>'123',
            'msme_no'=>'123456789',
            'msme_type_id'=>'126',
            'effective_from'=>'2024-08-22',
            'opening_balance'=>0,
        ]);
        ContactAddress::create([
            'contact_id'=>'1',
            'address_1'=>'7th block',
            'address_2'=>'kuvempu layout',
            'city_id'=>'2',
            'state_id'=>'2',
            'country_id'=>'2',
            'pincode_id'=>'2',
        ]);
    }
}
