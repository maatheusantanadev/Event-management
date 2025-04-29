<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\DiscountCoupon;

class PaymentsSeeder extends Seeder
{
   
    public function run(): void
    {
        $ticket = Ticket::first();
        $coupon = DiscountCoupon::first();

        if (!$ticket) {
            $this->command->warn('Nenhum ticket encontrado. O seed de pagamentos não será executado.');
            return;
        }

        Payment::create([
            'ticket_id' => $ticket->id,
            'transaction_id' => Str::uuid(),
            'discount_coupon_id' => $coupon?->id,
            'amount' => 100.00,
        ]);
    }
}
