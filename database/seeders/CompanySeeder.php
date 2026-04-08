<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        Company::create([
            'name' => 'BetterNet ISP Bangladesh',
            'address' => 'House #12, Road #5, Dhanmondi, Dhaka-1205',
            'phone' => '+880 1700-123456',
            'email' => 'info@betternet.com.bd',
        ]);
    }
}