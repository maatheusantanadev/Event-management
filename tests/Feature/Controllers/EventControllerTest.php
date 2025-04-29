<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Producer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use App\Mail\EventEmail;
use App\Jobs\ProcessPaymentJob;

class EventControllerTest extends TestCase
{
    use RefreshDatabase;

    public $seed = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_usuario_nao_autenticado_nao_pode_listar_eventos()
    {
        $response = $this->getJson('/api/events');

        $response->assertStatus(401);
    }

    public function test_usuario_sem_permissao_nao_pode_listar_eventos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/events');

        $response->assertStatus(403);
    }

    public function test_usuario_com_permissao_pode_listar_eventos()
    {
        $user = User::factory()->create();
        $user->assignRole('cliente');

        $this->actingAs($user);

        $response = $this->getJson('/api/events');

        $response->assertStatus(200);
    }

    public function test_usuario_com_permissao_pode_criar_evento()
    {
        Mail::fake();
        Queue::fake();

        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $producer = Producer::factory()->create();
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->postJson('/api/events', [
            'producer_id' => $producer->id,
            'title' => 'Festa da Programação',
            'description' => 'Evento para desenvolvedores',
            'date' => now()->addDays(10)->toDateString(),
            'location' => 'Salvador - BA',
            'banner_url' => 'https://example.com/banner.jpg',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('events', ['title' => 'Festa da Programação']);

        Mail::assertQueued(EventEmail::class);
        
    }

    public function test_usuario_com_permissao_pode_atualizar_evento()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $producer = Producer::factory()->create();
        $event = Event::factory()->create(['producer_id' => $producer->id]);

        $response = $this->putJson("/api/events/{$event->id}", [
            'title' => 'Evento Atualizado',
            'description' => 'Nova descrição',
            'date' => now()->addDays(15)->toDateString(),
            'location' => 'Feira de Santana - BA',
            'banner_url' => 'https://example.com/novo_banner.jpg',
            'producer_id' => $producer->id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('events', ['title' => 'Evento Atualizado']);
    }

    public function test_usuario_com_permissao_pode_deletar_evento()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $producer = Producer::factory()->create();
        $event = Event::factory()->create(['producer_id' => $producer->id]);

        $response = $this->deleteJson("/api/events/{$event->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}