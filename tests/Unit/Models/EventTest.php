<?php

namespace Tests\Unit\Models;

use App\Models\Event;
use App\Models\Producer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_pertence_a_um_producer()
    {
        $producer = Producer::factory()->create();

        // Cria um evento vinculado ao producer
        $event = Event::factory()->create([
            'producer_id' => $producer->id,
        ]);

        $this->assertInstanceOf(Producer::class, $event->producer);
        $this->assertEquals($producer->id, $event->producer->id);
    }
}