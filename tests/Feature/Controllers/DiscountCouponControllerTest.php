<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\DiscountCoupon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscountCouponControllerTest extends TestCase
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
        $response = $this->getJson('/api/coupons');
        $response->assertStatus(401);
    }

    public function test_usuario_sem_permissao_nao_pode_acessar_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->getJson('/api/coupons');
        $response->assertStatus(403);
    }

    public function test_usuario_com_permissao_pode_listar_cupons()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        DiscountCoupon::factory()->count(3)->create();

        $response = $this->getJson('/api/coupons');
        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    public function test_usuario_com_permissao_pode_criar_cupom()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $payload = [
            'code' => 'DESCONTO10',
            'discount' => 10,
            'max_uses' => 100,
            'expires_at' => now()->addDays(10)->toDateTimeString(),
        ];

        $response = $this->postJson('/api/coupons', $payload);

        $response->assertStatus(201)
                 ->assertJsonFragment(['code' => 'DESCONTO10']);

        $this->assertDatabaseHas('discount_coupons', ['code' => 'DESCONTO10']);
    }

    public function test_usuario_com_permissao_pode_ver_um_cupom()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $coupon = DiscountCoupon::factory()->create();

        $response = $this->getJson("/api/coupons/{$coupon->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $coupon->id]);
    }

    public function test_usuario_com_permissao_pode_atualizar_cupom()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $coupon = DiscountCoupon::factory()->create();

        $response = $this->putJson("/api/coupons/{$coupon->id}", [
            'code' => 'NOVO10',
            'discount' => 15,
            'max_uses' => 50,
            'expires_at' => now()->addDays(5)->toDateTimeString(),
        ]);

     

        $response->assertStatus(200)
                 ->assertJsonFragment(['code' => 'NOVO10']);

        $this->assertDatabaseHas('discount_coupons', ['code' => 'NOVO10']);
    }

    public function test_usuario_com_permissao_pode_deletar_cupom()
    {
        $user = User::factory()->create();
        $user->assignRole('produtor');
        $this->actingAs($user);

        $coupon = DiscountCoupon::factory()->create();

        $response = $this->deleteJson("/api/coupons/{$coupon->id}");
        $response->assertStatus(200)
                 ->assertJsonFragment(['message' => 'Cupom de desconto deletado com sucesso.']);

        $this->assertDatabaseMissing('discount_coupons', ['id' => $coupon->id]);
    }
}