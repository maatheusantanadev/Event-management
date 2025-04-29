<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        Role::firstOrCreate(['name' => 'cliente']);
    }

    public function test_user_can_register()
    {
        $data = [
            'name' => 'Teste',
            'email' => 'teste@email.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'phone' => '75999999999',
            'cpf_cnpj' => '12345678900',
            'role' => 'cliente',
        ];

        $response = $this->postJson('/api/signup', $data);

        $response->assertStatus(201)
                 ->assertJsonStructure([
                     'user' => ['id', 'name', 'email', 'cpf_cnpj', 'role']
                 ]);

        $this->assertDatabaseHas('users', [
            'email' => 'teste@email.com',
            'cpf_cnpj' => '12345678900',
        ]);

        $user = User::where('cpf_cnpj', '12345678900')->first();
        $this->assertTrue($user->hasRole('cliente'));
    }

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'cpf_cnpj' => '12345678901',
            'password' => bcrypt('senha_secreta'),
        ]);
        $user->assignRole('cliente');

        $credentials = [
            'cpf_cnpj' => '12345678901',
            'password' => 'senha_secreta',
        ];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'token',
                     'user' => ['id', 'name', 'email', 'cpf_cnpj', 'role']
                 ]);

        $this->assertArrayHasKey('token', $response->json());
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        User::factory()->create([
            'cpf_cnpj' => '12345678901',
            'password' => bcrypt('senha_secreta'),
        ]);

        $credentials = [
            'cpf_cnpj' => '12345678901',
            'password' => 'senha_errada',
        ];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(401)
                 ->assertJson(['message' => 'Credenciais inválidas']);
    }
}