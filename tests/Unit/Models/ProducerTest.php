<?php

namespace Tests\Unit\Models;

use App\Models\Producer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProducerTest extends TestCase
{
    use RefreshDatabase;

    public function test_producer_belongs_to_user()
    {
        $user = User::factory()->create();
        $producer = Producer::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $producer->user);
        $this->assertEquals($user->id, $producer->user->id);
    }
}