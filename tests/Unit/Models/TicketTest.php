<?php

namespace Tests\Unit\Models;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Lot;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_ticket_pertence_a_um_usuario()
    {
        
        $user = User::factory()->create();

     
        $lot = Lot::factory()->create();

        // Cria um ticket vinculado ao usuário e lote
        $ticket = Ticket::factory()->create([
            'user_id' => $user->id,
            'lot_id' => $lot->id,
        ]);

     
        $this->assertInstanceOf(User::class, $ticket->user);
        $this->assertEquals($user->id, $ticket->user->id);

       
        $this->assertInstanceOf(Lot::class, $ticket->lot);
        $this->assertEquals($lot->id, $ticket->lot->id);
    }
}