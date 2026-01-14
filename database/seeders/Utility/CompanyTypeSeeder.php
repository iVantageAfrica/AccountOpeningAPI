<?php

namespace Database\Seeders\Utility;

use App\Models\Utility\CompanyType;
use Illuminate\Database\Seeder;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanyType::insert([
            ['name' => 'Limited Partnership'],
            ['name' => 'Unlimited Company'],
            ['name' => 'Public Limited Company (PLC)'],
            ['name' => 'Incorporated Trustee'],
            ['name' => 'Company Limited by Guarantee (CLG)'],
            ['name' => 'Limited Liability Partnership'],
            ['name' => 'Limited Liability Company (LTD)'],
            ['name' => 'Business Name/Sole Proprietorship'],
            ['name' => 'Clubs, Societies & Associations'],
            ['name' => 'NGOs / Foundation/ Trusts'],
            ['name' => 'Foreign-Owned/ Foreign-Controlled Entities (Additions)'],
            ['name' => 'Franchise'],
        ]);
    }
}
