<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Producer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_tem_muitos_producers()
    {
  
        $user = User::factory()->create();

        // Cria 3 producers associados a esse usuário
        $producers = Producer::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

 
        $this->assertCount(3, $user->producers);
        $this->assertTrue($user->producers->contains($producers[0]));
        $this->assertTrue($user->producers->contains($producers[1]));
        $this->assertTrue($user->producers->contains($producers[2]));
    }
}