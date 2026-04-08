<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Billing;
use Carbon\Carbon;

class BillingSeeder extends Seeder
{
    public function run(): void
    {
        $billings = [
            [
                'invoice' => 'INV-' . Carbon::now()->format('Ym') . '-001',
                'package_name' => 'Standard-20Mbps',
                'package_price' => 1200,
                'package_start' => Carbon::now()->startOfMonth(),
                'user_id' => 2,
            ],
            [
                'invoice' => 'INV-' . Carbon::now()->format('Ym') . '-002',
                'package_name' => 'Mirpur-Standard-30Mbps',
                'package_price' => 1100,
                'package_start' => Carbon::now()->subMonth()->startOfMonth(),
                'user_id' => 3,
            ],
            [
                'invoice' => 'INV-' . Carbon::now()->format('Ym') . '-003',
                'package_name' => 'Gulshan-Business-50Mbps',
                'package_price' => 2500,
                'package_start' => Carbon::now()->startOfMonth(),
                'user_id' => 4,
            ],
            [
                'invoice' => 'INV-' . Carbon::now()->subMonth()->format('Ym') . '-004',
                'package_name' => 'Uttara-Home-20Mbps',
                'package_price' => 900,
                'package_start' => Carbon::now()->subMonths(2)->startOfMonth(),
                'user_id' => 5,
            ],
            [
                'invoice' => 'INV-' . Carbon::now()->subMonths(2)->format('Ym') . '-005',
                'package_name' => 'Uttara-Home-20Mbps',
                'package_price' => 900,
                'package_start' => Carbon::now()->subMonths(3)->startOfMonth(),
                'user_id' => 5,
            ],
        ];

        foreach ($billings as $billing) {
            Billing::create($billing);
        }
    }
}