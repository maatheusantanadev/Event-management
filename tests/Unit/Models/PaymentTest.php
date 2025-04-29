<?php

namespace Tests\Unit\Models;

use App\Models\Payment;
use App\Models\User;
use App\Models\Ticket;
use App\Models\DiscountCoupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_relacionamento_payment_com_ticket()
    {
 
        $ticket = Ticket::factory()->create();

        // Cria um pagamento associado ao ticket
        $payment = Payment::factory()->create([
            'ticket_id' => $ticket->id,
        ]);

    
        $this->assertEquals($ticket->id, $payment->ticket->id);
    }

    public function test_relacionamento_payment_com_user()
    {
    
        $user = User::factory()->create();

        // Cria um pagamento associado ao usuário
        $payment = Payment::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->assertEquals($user->id, $payment->user->id);
    }

    public function test_relacionamento_payment_com_discount_coupon()
    {
        
        $coupon = DiscountCoupon::factory()->create();

        // Cria um pagamento associado ao cupom de desconto
        $payment = Payment::factory()->create([
            'discount_coupon_id' => $coupon->id,
        ]);

     
        $this->assertEquals($coupon->id, $payment->discountCoupon->id);
    }

    public function test_payment_status_default_value()
    {
        // Cria um pagamento sem especificar o status
        $payment = Payment::factory()->create();

        $this->assertEquals('pendente', $payment->status);
    }
}