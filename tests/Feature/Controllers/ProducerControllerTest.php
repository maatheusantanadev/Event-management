<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use App\Models\User;
use App\Models\Producer;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProducerControllerTest extends TestCase
{
    use RefreshDatabase;
    public $seed = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_usuario_nao_autenticado_nao_pode_listar_produtores()
    {
        $response = $this->getJson('/api/producers');

        $response->assertStatus(401);
    }

    public function test_usuario_sem_permissao_nao_pode_listar_produtores()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/producers');

        $response->assertStatus(403);
    }

    public function test_usuario_com_permissao_pode_listar_produtores()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->actingAs($user)
            ->getJson('/api/producers')
            ->assertStatus(200);
    }

    public function test_usuario_com_permissao_pode_criar_produtor()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $producerData = [
            'user_id' => User::factory()->create()->id,
            'company_name' => 'Empresa de Teste',
            'cnpj' => '12.345.678/0001-90',
        ];

        $response = $this->postJson('/api/producers', $producerData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['company_name' => 'Empresa de Teste']);

        $this->assertDatabaseHas('producers', ['cnpj' => '12.345.678/0001-90']);
    }

    public function test_usuario_com_permissao_pode_atualizar_produtor()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $producer = Producer::factory()->create();

        $response = $this->putJson("/api/producers/{$producer->id}", [
            'company_name' => 'Empresa Atualizada',
            'cnpj' => $producer->cnpj,
            'user_id' => $producer->user_id,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('producers', ['company_name' => 'Empresa Atualizada']);
    }

    public function test_usuario_com_permissao_pode_deletar_produtor()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $producer = Producer::factory()->create();

        $response = $this->deleteJson("/api/producers/{$producer->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('producers', ['id' => $producer->id]);
    }
}