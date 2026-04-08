<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         \App\Models\User::factory()->create();

         \App\Models\User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@betternet.com',
             'role' => 'admin',
         ]);

    
    
        $this->call([
            UserSeeder::class,
            CompanySeeder::class,
            RouterSeeder::class,
            PackageSeeder::class,
            SettingSeeder::class,
            CustomerSeeder::class,
            DetailSeeder::class,
            BillingSeeder::class,
            PaymentSeeder::class,
            TicketSeeder::class,
            CommentSeeder::class,
        ]);
    


        
    }
}
