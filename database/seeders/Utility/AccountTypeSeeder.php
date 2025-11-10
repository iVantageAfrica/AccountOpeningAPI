<?php

namespace Database\Seeders\Utility;

use App\Models\Utility\AccountType;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Current Account', 'category' => 'Individual', 'code' => '101'],
            ['name' => 'Savings Account', 'category' => 'Individual', 'code' => '005'],
            ['name' => 'Corporate Account', 'category' => 'Corporate', 'code' => '101'],
            ['name' => 'POS Merchant', 'category' => 'Merchant'],
        ];
        foreach ($data as $accountType) {
            AccountType::create($accountType);
        }
    }
}
