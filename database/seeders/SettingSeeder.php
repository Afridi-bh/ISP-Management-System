<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'router_ip' => '192.168.10.1',
            'router_username' => 'admin',
            'router_password' => 'DhakaBD2024',
            'mail_server' => 'smtp.gmail.com',
            'mail_username' => 'noreply@betternet.com.bd',
            'mail_password' => 'mail_password_here',
            'mail_port' => 587,
            'mail_from_address' => 'noreply@betternet.com.bd',
            'mail_from_name' => 'BetterNet ISP',
            'app_name' => 'BetterNet ISP Bangladesh',
            'db' => 'betternet_db',
            'db_username' => 'root',
            'db_password' => '',
            'timezone' => 'Asia/Dhaka',
            'currency' => 'BDT',
            'bill_at' => 1,
            'disconnect_at' => 5,
        ]);
    }
}