<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            // Dhanmondi Router Packages
            ['name' => 'Basic-10Mbps', 'price' => 800, 'router_id' => 1],
            ['name' => 'Standard-20Mbps', 'price' => 1200, 'router_id' => 1],
            ['name' => 'Premium-50Mbps', 'price' => 2000, 'router_id' => 1],
            ['name' => 'Ultra-100Mbps', 'price' => 3500, 'router_id' => 1],

            // Mirpur Router Packages
            ['name' => 'Mirpur-Basic-15Mbps', 'price' => 700, 'router_id' => 2],
            ['name' => 'Mirpur-Standard-30Mbps', 'price' => 1100, 'router_id' => 2],
            ['name' => 'Mirpur-Premium-60Mbps', 'price' => 1800, 'router_id' => 2],

            // Gulshan Router Packages
            ['name' => 'Gulshan-Business-50Mbps', 'price' => 2500, 'router_id' => 3],
            ['name' => 'Gulshan-Corporate-100Mbps', 'price' => 4000, 'router_id' => 3],
            ['name' => 'Gulshan-Enterprise-200Mbps', 'price' => 7000, 'router_id' => 3],

            // Uttara Router Packages
            ['name' => 'Uttara-Home-20Mbps', 'price' => 900, 'router_id' => 4],
            ['name' => 'Uttara-Plus-40Mbps', 'price' => 1500, 'router_id' => 4],

            // Chittagong Router Packages
            ['name' => 'CTG-Basic-10Mbps', 'price' => 750, 'router_id' => 5],
            ['name' => 'CTG-Standard-25Mbps', 'price' => 1000, 'router_id' => 5],
            ['name' => 'CTG-Premium-50Mbps', 'price' => 1800, 'router_id' => 5],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}