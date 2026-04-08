<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@betternet.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Md. Rahman',
                'email' => 'rahman@betternet.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Fatima Akter',
                'email' => 'fatima@betternet.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Karim Hossain',
                'email' => 'karim@betternet.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Ayesha Begum',
                'email' => 'ayesha@betternet.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}