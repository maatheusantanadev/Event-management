<?php

namespace Tests\Unit\Models;

use App\Models\Event;
use App\Models\Sector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SectorTest extends TestCase
{
    use RefreshDatabase;

    public function test_sector_pertence_a_um_event()
    {
     
        $event = Event::factory()->create();

        // Cria um setor vinculado ao evento
        $sector = Sector::factory()->create([
            'event_id' => $event->id,
        ]);

        $this->assertInstanceOf(Event::class, $sector->event);
        $this->assertEquals($event->id, $sector->event->id);
    }
}