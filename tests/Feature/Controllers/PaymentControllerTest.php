<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\DiscountCoupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use App\Services\PagguePaymentService;
use App\Jobs\ProcessPaymentJob;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public $seed = false;

    protected function setUp(): void
    {
        parent::setUp();

        // Seeder para as permissões e papéis
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_usuario_nao_autenticado_nao_pode_acessar_index()
    {
        $response = $this->getJson('/api/payments');

        $response->assertStatus(401);
    }

    public function test_usuario_sem_permissao_nao_pode_acessar_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/payments');

        $response->assertStatus(403);
    }

    public function test_usuario_com_permissao_pode_listar_pagamentos()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $response = $this->getJson('/api/payments');

        $response->assertStatus(200);
    }

    public function test_usuario_pode_criar_pagamento()
    {
        $user = User::factory()->create();
        $user->assignRole('cliente');
        $this->actingAs($user);

        $ticket = Ticket::factory()->create();
        $discountCoupon = DiscountCoupon::factory()->create();

        $payload = [
            'ticket_id' => $ticket->id,
            'transaction_id' => (string) \Str::uuid(),
            'discount_coupon_id' => $discountCoupon->id,
            'amount' => 100.00,
        ];

        $response = $this->postJson('/api/payments', $payload);

        $response->assertStatus(200)
                ->assertJsonFragment(['message' => 'Pagamento agendado para processamento.'])
                ->assertJsonFragment(['ticket_id' => $ticket->id]);

        $this->assertDatabaseHas('payments', [
            'ticket_id' => $ticket->id,
            'transaction_id' => $payload['transaction_id'],
            'amount' => 100.00,
        ]);
    }

    public function test_usuario_pode_atualizar_pagamento()
    {
      
        $payment = Payment::factory()->create();

  
        $payload = [
            'amount' => 120.00,
            'status' => 'confirmado',
        ];

        $user = User::factory()->create();
        $payment = Payment::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->putJson("/api/payments/{$payment->id}", $payload);


        $response->assertStatus(200)
                ->assertJsonFragment(['amount' => 120.00])
                ->assertJsonFragment(['status' => 'confirmado']);

        // Verificar se o pagamento foi atualizado no banco
        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'amount' => 120.00,
            'status' => 'confirmado',
        ]);
    }

    public function test_usuario_com_permissao_pode_deletar_pagamento()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $payment = Payment::factory()->create();

        $response = $this->deleteJson("/api/payments/{$payment->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Pagamento deletado com sucesso.']);

        // Verificar se o pagamento foi excluído do banco
        $this->assertDatabaseMissing('payments', [
            'id' => $payment->id,
        ]);
    }


    public function test_usuario_sem_permissao_nao_pode_deletar_pagamento()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $payment = Payment::factory()->create();

        $response = $this->deleteJson("/api/payments/{$payment->id}");

        $response->assertStatus(403);
    }
}