<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupportNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('support_notifications')->insert([
            [
                'name' => 'Customer Support Officer',
                'email' => 'godswill.nzeadibe@imperialmortgagebank.com',
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
//            [
//                'name' => 'Support Team',
//                'email' => 'customersupport',
//                'active' => true,
//                'created_at' => now(),
//                'updated_at' => now(),
//            ],
        ]);
    }
}
