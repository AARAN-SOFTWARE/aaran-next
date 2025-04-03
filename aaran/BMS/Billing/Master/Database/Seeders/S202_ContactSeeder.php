<?php

namespace Aaran\Master\Database\Seeders;

use Aaran\Master\Models\Contact;
use Aaran\Master\Models\ContactDetail;
use Illuminate\Database\Seeder;

class S202_ContactSeeder extends Seeder
{
    public static function run(): void
    {
        Contact::create([
            'vname'=>'XYZ company pvt ltd',
            'gstin'=>'29AWGPV7107B1Z1',
            'company_id'=>'1',
            'user_id'=>'1',
            'active_id'=>'1',
            'contact_type_id'=>'1',
            'whatsapp'=>'0123456789',
            'mobile'=>'0123456789',
            'contact_person'=>'123',
            'msme_no'=>'123456789',
            'msme_type_id'=>'126',
            'effective_from'=>'2024-08-22',
            'opening_balance'=>0,
        ]);
        ContactDetail::create([
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
