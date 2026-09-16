<?php

namespace Database\Seeders;

use App\Models\SupportNotification;
use Illuminate\Database\Seeder;

class SupportNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultEmail = config('mail.customer_support_mail');

        SupportNotification::firstOrCreate(
            ['email' => $defaultEmail],
            [
                'firstname' => 'Customer',
                'lastname' => 'Support Officer',
                'status' => 'Active',
            ]
        );
    }
}
