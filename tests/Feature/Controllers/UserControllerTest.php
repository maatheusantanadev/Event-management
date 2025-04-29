<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    public $seed = false;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_usuario_nao_autenticado_nao_pode_acessar_index()
    {
        $response = $this->getJson('/api/users');

        $response->assertStatus(401);
    }

    public function test_usuario_sem_permissao_nao_pode_acessar_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->getJson('/api/users');

        $response->assertStatus(403);
    }

    public function test_usuario_com_permissao_pode_listar_usuarios()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');

        $this->actingAs($user);

        $response = $this->getJson('/api/users');

        $response->assertStatus(200);
    }

    public function test_usuario_com_permissao_pode_criar_usuario()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $response = $this->postJson('/api/users', [
            'name' => 'Teste',
            'email' => 'teste@email.com',
            'password' => '12345678',
            'password_confirmation' => '12345678', 
            'phone' => '75999999999',
            'cpf_cnpj' => '12345678900',
            'role' => 'admin',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'teste@email.com']);
    }

    public function test_usuario_com_permissao_pode_atualizar_usuario()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Nome Atualizado',
            'email' => $user->email,
            'phone' => $user->phone,
            'cpf_cnpj' => $user->cpf_cnpj,
            'role' => 'admin',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['name' => 'Nome Atualizado']);
    }

    public function test_usuario_com_permissao_pode_deletar_usuario()
    {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);

        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
