<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $payments = [
            [
                'invoice' => 'INV-' . now()->format('Ym') . '-001',
                'payment_method' => 'bKash',
                'package_price' => 1200,
                'user_id' => 2,
                'billing_id' => 1,
            ],
            [
                'invoice' => 'INV-' . now()->format('Ym') . '-003',
                'payment_method' => 'Nagad',
                'package_price' => 2500,
                'user_id' => 4,
                'billing_id' => 3,
            ],
            [
                'invoice' => 'INV-' . now()->subMonths(2)->format('Ym') . '-005',
                'payment_method' => 'Bank Transfer',
                'package_price' => 900,
                'user_id' => 5,
                'billing_id' => 5,
            ],
        ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }
    }
}