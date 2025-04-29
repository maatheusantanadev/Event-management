<?php

namespace Tests\Feature\Middleware;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;
use Illuminate\Http\Request;

class RoleMiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();


        // Define uma rota temporária para teste com os middlewares 'auth' e 'role'
        Route::middleware(['auth:sanctum'])->get('/teste-admin', function (Request $request) {
            $user = $request->user(); // Recupera o usuário autenticado
        
            if ($user && $user->role === 'admin') {
                return response()->json(['message' => 'Acesso permitido']);
            }
        
            return response()->json(['message' => 'Acesso negado'], 403);
        });
    }

    public function test_usuario_com_role_correta_pode_acessar()
    {

        $user = User::factory()->create(['role' => 'admin']);

        // Simula a autenticação do usuário e faz a requisição
        $response = $this->actingAs($user)->get('/teste-admin');

  
        $response->assertStatus(200)
                 ->assertJson(['message' => 'Acesso permitido']);
    }

    public function test_usuario_com_role_errada_recebe_403()
    {
      
        $user = User::factory()->create(['role' => 'cliente']);

        // Simula a autenticação do usuário e faz a requisição
        $response = $this->actingAs($user)->get('/teste-admin');

       
        $response->assertStatus(403)
                 ->assertJson(['message' => 'Acesso negado']);
    }

}