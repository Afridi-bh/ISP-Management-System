<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Router;

class RouterSeeder extends Seeder
{
    public function run(): void
    {
        $routers = [
            [
                'name' => 'Dhanmondi-Router-01',
                'location' => 'Dhanmondi, Dhaka',
                'ip' => '192.168.10.1',
                'username' => 'admin',
                'password' => 'DhakaBD2024',
            ],
            [
                'name' => 'Mirpur-Router-01',
                'location' => 'Mirpur-10, Dhaka',
                'ip' => '192.168.20.1',
                'username' => 'admin',
                'password' => 'MirpurBD2024',
            ],
            [
                'name' => 'Gulshan-Router-01',
                'location' => 'Gulshan-2, Dhaka',
                'ip' => '192.168.30.1',
                'username' => 'admin',
                'password' => 'GulshanBD2024',
            ],
            [
                'name' => 'Uttara-Router-01',
                'location' => 'Uttara Sector-7, Dhaka',
                'ip' => '192.168.40.1',
                'username' => 'admin',
                'password' => 'UttaraBD2024',
            ],
            [
                'name' => 'Chittagong-Router-01',
                'location' => 'Agrabad, Chittagong',
                'ip' => '192.168.50.1',
                'username' => 'admin',
                'password' => 'ChittagongBD2024',
            ],
        ];

        foreach ($routers as $router) {
            Router::create($router);
        }
    }
}