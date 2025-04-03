<?php

namespace Aaran\BMS\Billing\Common\Database\Seeders;

use Aaran\BMS\Billing\Common\Models\ContactType;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    public static function run(): void
    {
        $contactTypes = [
            1 => '-',
            2 => 'Creditors',
            3 => 'Debtors'
        ];

        foreach ($contactTypes as $id => $vname) {
            ContactType::create([
                'id' => $id,
                'vname' => $vname,
                'active_id' => '1'
            ]);
        }
    }

}

