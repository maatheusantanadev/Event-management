<?php

namespace Tests\Unit\Models;

use App\Models\DiscountCoupon;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscountCouponTest extends TestCase
{
    use RefreshDatabase;

    public function test_cupom_valido_quando_a_data_nao_expirou_e_nao_excedeu_o_limite_de_usos()
    {
       
        $coupon = DiscountCoupon::factory()->create([
            'expires_at' => Carbon::now()->addDays(1),  
            'max_uses' => 5,  
            'used_count' => 2,  
        ]);

       
        $this->assertTrue($coupon->isValid());
    }

    public function test_cupom_invalido_quando_a_data_expirou()
    {

        $coupon = DiscountCoupon::factory()->create([
            'expires_at' => Carbon::now()->subDays(1),  
            'max_uses' => 5,  
            'used_count' => 2, 
        ]);

        $this->assertFalse($coupon->isValid());
    }

    public function test_cupom_invalido_quando_excedeu_o_limite_de_usos()
    {
        $coupon = DiscountCoupon::factory()->create([
            'expires_at' => Carbon::now()->addDays(1),  
            'max_uses' => 3,  
            'used_count' => 4,  
        ]);


        $this->assertFalse($coupon->isValid());
    }

    public function test_relacionamento_cupom_tem_muitos_pagamentos()
    {
        
        $coupon = DiscountCoupon::factory()->create();

        $payments = Payment::factory()->count(3)->create([
            'discount_coupon_id' => $coupon->id,
        ]);

        $this->assertCount(3, $coupon->payments);
        $this->assertTrue($coupon->payments->contains($payments[0]));
        $this->assertTrue($coupon->payments->contains($payments[1]));
        $this->assertTrue($coupon->payments->contains($payments[2]));
    }
}