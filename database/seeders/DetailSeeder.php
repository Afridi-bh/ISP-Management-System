<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Detail;
use Carbon\Carbon;

class DetailSeeder extends Seeder
{
    public function run(): void
    {
        $details = [
            [
                'address' => 'House #45, Road #12, Dhanmondi, Dhaka-1209',
                'phone' => '01712345678',
                'dob' => '1990-05-15',
                'pin' => '1209',
                'router_password' => 'user123',
                'router_name' => 'Dhanmondi-Router-01',
                'package_name' => 'Standard-20Mbps',
                'package_price' => 1200,
                'package_start' => Carbon::now()->startOfMonth(),
                'due' => 0,
                'status' => 'active',
                'user_id' => 2,
            ],
            [
                'address' => 'Flat #3B, Mirpur DOHS, Dhaka-1216',
                'phone' => '01823456789',
                'dob' => '1988-08-20',
                'pin' => '1216',
                'router_password' => 'user456',
                'router_name' => 'Mirpur-Router-01',
                'package_name' => 'Mirpur-Standard-30Mbps',
                'package_price' => 1100,
                'package_start' => Carbon::now()->subMonth()->startOfMonth(),
                'due' => 1100,
                'status' => 'active',
                'user_id' => 3,
            ],
            [
                'address' => 'House #78, Gulshan-1, Dhaka-1212',
                'phone' => '01934567890',
                'dob' => '1985-12-10',
                'pin' => '1212',
                'router_password' => 'user789',
                'router_name' => 'Gulshan-Router-01',
                'package_name' => 'Gulshan-Business-50Mbps',
                'package_price' => 2500,
                'package_start' => Carbon::now()->startOfMonth(),
                'due' => 0,
                'status' => 'active',
                'user_id' => 4,
            ],
            [
                'address' => 'Sector-7, House #23, Uttara, Dhaka-1230',
                'phone' => '01645678901',
                'dob' => '1992-03-25',
                'pin' => '1230',
                'router_password' => 'user321',
                'router_name' => 'Uttara-Router-01',
                'package_name' => 'Uttara-Home-20Mbps',
                'package_price' => 900,
                'package_start' => Carbon::now()->subMonths(2)->startOfMonth(),
                'due' => 2700,
                'status' => 'inactive',
                'user_id' => 5,
            ],
        ];

        foreach ($details as $detail) {
            Detail::create($detail);
        }
    }
}