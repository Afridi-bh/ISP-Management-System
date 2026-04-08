<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Md. Habibur Rahman',
                'email' => 'habib@example.com',
                'phone' => '01712345678',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subMonths(6),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Nusrat Jahan',
                'email' => 'nusrat@example.com',
                'phone' => '01823456789',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subMonths(5),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Abdul Karim',
                'email' => 'karim@example.com',
                'phone' => '01934567890',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subMonths(4),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Fatema Akter',
                'email' => 'fatema@example.com',
                'phone' => '01645678901',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subMonths(3),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Md. Shakib Khan',
                'email' => 'shakib@example.com',
                'phone' => '01756789012',
                'password' => Hash::make('password'),
                'status' => 'inactive',
                'email_verified_at' => Carbon::now()->subMonth(),
                'created_at' => Carbon::now()->subMonths(2),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ayesha Siddika',
                'email' => 'ayesha@example.com',
                'phone' => '01867890123',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subMonth(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rahim Uddin',
                'email' => 'rahim@example.com',
                'phone' => '01978901234',
                'password' => Hash::make('password'),
                'status' => 'suspended',
                'email_verified_at' => Carbon::now()->subMonths(2),
                'created_at' => Carbon::now()->subMonths(8),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sharmin Sultana',
                'email' => 'sharmin@example.com',
                'phone' => '01512345670',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subWeeks(3),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Md. Jahangir Alam',
                'email' => 'jahangir@example.com',
                'phone' => '01623456781',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => null, // Not verified yet
                'created_at' => Carbon::now()->subWeeks(2),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sumaiya Islam',
                'email' => 'sumaiya@example.com',
                'phone' => '01734567892',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subWeek(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Md. Nasir Uddin',
                'email' => 'nasir@example.com',
                'phone' => '01845678903',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subDays(5),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Razia Sultana',
                'email' => 'razia@example.com',
                'phone' => '01956789014',
                'password' => Hash::make('password'),
                'status' => 'inactive',
                'email_verified_at' => Carbon::now()->subWeeks(3),
                'created_at' => Carbon::now()->subMonths(7),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Kamrul Hassan',
                'email' => 'kamrul@example.com',
                'phone' => '01567890125',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subDays(3),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Sabina Yasmin',
                'email' => 'sabina@example.com',
                'phone' => '01678901236',
                'password' => Hash::make('password'),
                'status' => 'active',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now()->subDays(10),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Md. Belal Hossain',
                'email' => 'belal@example.com',
                'phone' => '01789012347',
                'password' => Hash::make('password'),
                'status' => 'suspended',
                'email_verified_at' => Carbon::now()->subMonths(4),
                'created_at' => Carbon::now()->subYear(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}