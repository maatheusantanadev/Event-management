<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Lot;
use Illuminate\Support\Str; 
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    public $seed = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_usuario_nao_autenticado_nao_pode_listar_ingressos()
    {
        $response = $this->getJson('/api/tickets');

        $response->assertStatus(401);
    }

    public function test_usuario_sem_permissao_nao_pode_listar_ingressos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/tickets');

        $response->assertStatus(403);
    }

    public function test_usuario_com_permissao_pode_listar_ingressos()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $response = $this->getJson('/api/tickets');

        $response->assertStatus(200);
    }

    public function test_usuario_pode_criar_ingresso()
    {
        $user = User::factory()->create();
        $user->assignRole('cliente');
        $this->actingAs($user);

        $comprador = User::factory()->create();
        $lot = Lot::factory()->create();

        $response = $this->postJson('/api/tickets', [
            'user_id' => $comprador->id,
            'lot_id' => $lot->id,
            'status' => 'pendente',
            'qr_code' => Str::uuid(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tickets', [
            'user_id' => $comprador->id,
            'lot_id' => $lot->id,
            'status' => 'pendente',
        ]);
    }

    public function test_usuario_com_permissao_pode_visualizar_ingresso()
    {
        $user = User::factory()->create();
        $user->assignRole('cliente');
        $this->actingAs($user);

        $ticket = Ticket::factory()->create();

        $response = $this->getJson("/api/tickets/{$ticket->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $ticket->id]);
    }

    public function test_usuario_com_permissao_pode_atualizar_ingresso()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);        

        $ticket = Ticket::factory()->create([
            'status' => 'pendente',
        ]);

        $response = $this->putJson("/api/tickets/{$ticket->id}", [
            'user_id' => $ticket->user_id,
            'lot_id' => $ticket->lot_id,
            'status' => 'pago',
            'qr_code' => $ticket->qr_code,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tickets', ['status' => 'pago']);
    }

    public function test_usuario_com_permissao_pode_deletar_ingresso()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $ticket = Ticket::factory()->create();

        $response = $this->deleteJson("/api/tickets/{$ticket->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tickets', ['id' => $ticket->id]);
    }
}