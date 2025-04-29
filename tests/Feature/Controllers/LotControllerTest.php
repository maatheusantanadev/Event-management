<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lot;
use App\Models\Sector;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LotControllerTest extends TestCase
{
    use RefreshDatabase;

    public $seed = false;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_usuario_nao_autenticado_nao_pode_listar_lotes()
    {
        $response = $this->getJson('/api/lots');

        $response->assertStatus(401);
    }

    public function test_usuario_sem_permissao_nao_pode_listar_lotes()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/lots');

        $response->assertStatus(403);
    }

    public function test_usuario_com_permissao_pode_listar_lotes()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $sector = Sector::factory()->create();

        // Criar 3 lotes, mas apenas o primeiro estará válido (ativo)
        Lot::factory()->create([
            'sector_id' => $sector->id,
            'quantity' => 10,
            'end_date' => now()->addDays(5),
            'start_date' => now()->subDays(1),
        ]);

        Lot::factory()->create([
            'sector_id' => $sector->id,
            'quantity' => 0, // esgotado
            'end_date' => now()->addDays(5),
            'start_date' => now()->subDays(1),
        ]);

        Lot::factory()->create([
            'sector_id' => $sector->id,
            'quantity' => 10,
            'end_date' => now()->subDay(), // expirado
            'start_date' => now()->subDays(2),
        ]);

        $response = $this->getJson('/api/lots');

        $response->assertStatus(200)
                ->assertJsonCount(1)
                ->assertJsonFragment(['sector_id' => $sector->id]);
    }

    public function test_usuario_com_permissao_pode_criar_lote()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $sector = Sector::factory()->create();

        $data = [
            'sector_id' => $sector->id,
            'name' => 'Lote Premium',
            'price' => 120.00,
            'quantity' => 80,
            'start_date' => now()->toDateTimeString(),
            'end_date' => now()->addDays(7)->toDateTimeString(),
        ];

        $response = $this->postJson('/api/lots', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('lots', ['name' => 'Lote Premium']);
    }

    public function test_usuario_com_permissao_pode_visualizar_um_lote()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $sector = Sector::factory()->create();
        $lot = Lot::factory()->create(['sector_id' => $sector->id]);

        $response = $this->getJson("/api/lots/{$lot->id}");

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $lot->id]);
    }

    public function test_usuario_com_permissao_pode_atualizar_um_lote()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $sector = Sector::factory()->create();
        $lot = Lot::factory()->create([
            'sector_id' => $sector->id,
            'name' => 'Lote Antigo',
        ]);

        $data = [
            'sector_id' => $sector->id,
            'name' => 'Lote Atualizado',
            'price' => 200.00,
            'quantity' => 60,
            'start_date' => now()->toDateTimeString(),
            'end_date' => now()->addDays(5)->toDateTimeString(),
        ];

        $response = $this->putJson("/api/lots/{$lot->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('lots', ['name' => 'Lote Atualizado']);
    }

    public function test_usuario_com_permissao_pode_deletar_um_lote()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $sector = Sector::factory()->create();
        $lot = Lot::factory()->create(['sector_id' => $sector->id]);

        $response = $this->deleteJson("/api/lots/{$lot->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('lots', ['id' => $lot->id]);
    }
}
