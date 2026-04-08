<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $tickets = [
            [
                'number' => 'TKT-' . now()->format('Ymd') . '-001',
                'subject' => 'Internet Connection Problem',
                'message' => 'আমার ইন্টারনেট সংযোগ গত কাল থেকে কাজ করছে না। দয়া করে সমস্যাটি দ্রুত সমাধান করুন।',
                'status' => 'open',
                'priority' => 'high',
                'user_id' => 2,
            ],
            [
                'number' => 'TKT-' . now()->format('Ymd') . '-002',
                'subject' => 'Slow Internet Speed',
                'message' => 'আমার প্যাকেজ ৫০ এমবিপিএস কিন্তু আমি মাত্র ১০-১৫ এমবিপিএস পাচ্ছি। অনুগ্রহ করে চেক করুন।',
                'status' => 'in_progress',
                'priority' => 'medium',
                'user_id' => 3,
            ],
            [
                'number' => 'TKT-' . now()->subDays(2)->format('Ymd') . '-003',
                'subject' => 'Package Upgrade Request',
                'message' => 'আমি আমার প্যাকেজ আপগ্রেড করতে চাই। ২০ এমবিপিএস থেকে ৫০ এমবিপিএস এ যেতে চাই।',
                'status' => 'closed',
                'priority' => 'low',
                'user_id' => 4,
            ],
            [
                'number' => 'TKT-' . now()->subDays(1)->format('Ymd') . '-004',
                'subject' => 'Bill Payment Confirmation',
                'message' => 'আমি গত সপ্তাহে বিকাশে বিল পেমেন্ট করেছি কিন্তু এখনও আপডেট হয়নি। বিকাশ নম্বর: 01712345678',
                'status' => 'open',
                'priority' => 'high',
                'user_id' => 5,
            ],
        ];

        foreach ($tickets as $ticket) {
            Ticket::create($ticket);
        }
    }
}