<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Sector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SectorControllerTest extends TestCase
{
    use RefreshDatabase;

    public $seed = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_usuario_nao_autenticado_nao_pode_listar_setores()
    {
        $response = $this->getJson('/api/sectors');

        $response->assertStatus(401);
    }

    public function test_usuario_sem_permissao_nao_pode_listar_setores()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/sectors');

        $response->assertStatus(403);
    }

    public function test_usuario_com_permissao_pode_listar_setores()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $response = $this->getJson('/api/sectors');

        $response->assertStatus(200);
    }

    public function test_usuario_com_permissao_pode_criar_setor()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $event = Event::factory()->create();

        $response = $this->postJson('/api/sectors', [
            'event_id' => $event->id,
            'name' => 'Setor VIP',
            'capacity' => 100,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('sectors', ['name' => 'Setor VIP']);
    }

    public function test_usuario_com_permissao_pode_visualizar_um_setor()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $sector = Sector::factory()->create();

        $response = $this->getJson("/api/sectors/{$sector->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['name' => $sector->name]);
    }

    public function test_usuario_com_permissao_pode_atualizar_um_setor()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $sector = Sector::factory()->create([
            'name' => 'Setor Antigo',
        ]);

        $response = $this->putJson("/api/sectors/{$sector->id}", [
            'event_id' => $sector->event_id,
            'name' => 'Setor Atualizado',
            'capacity' => 200,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('sectors', ['name' => 'Setor Atualizado']);
    }

    public function test_usuario_com_permissao_pode_deletar_um_setor()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $sector = Sector::factory()->create();

        $response = $this->deleteJson("/api/sectors/{$sector->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('sectors', ['id' => $sector->id]);
    }
}