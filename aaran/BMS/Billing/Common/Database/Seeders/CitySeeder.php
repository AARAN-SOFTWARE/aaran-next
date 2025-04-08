<?php

namespace Aaran\BMS\Billing\Common\Database\Seeders;

use Aaran\BMS\Billing\Common\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public static function run(): void
    {
        $cities = [
            '-', 'Chennai', 'Tiruppur', 'Coimbatore', 'Madurai', 'Tiruchirappalli', 'Salem', 'Tirunelveli',
            'Erode', 'Vellore', 'Thoothukudi', 'Dindigul', 'Thanjavur', 'Ranipet', 'Sivakasi', 'Karur',
            'Udhagamandalam', 'Hosur', 'Nagercoil', 'Kancheepuram', 'Kumbakonam', 'Rajapalayam',
            'Pudukkottai', 'Ariyalur', 'Nagapattinam', 'Perambalur', 'Tiruvarur', 'Karaikudi',
            'Ambur', 'Tenkasi', 'Kallakurichi', 'Namakkal', 'Tiruvannamalai', 'Krishnagiri',
            'Thiruvallur', 'Cuddalore', 'Pollachi', 'Avadi', 'Ambattur', 'Pallavaram', 'Tambaram'
        ];

        foreach ($cities as $city) {
            City::create([
                'vname' => $city,
                'active_id' => '1'
            ]);
        }
    }
}
