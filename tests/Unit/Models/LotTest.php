<?php

namespace Tests\Unit\Models;

use App\Models\Lot;
use App\Models\Sector;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LotTest extends TestCase
{
    use RefreshDatabase;

    public function test_lot_pertence_a_um_sector()
    {

        $sector = Sector::factory()->create();

        // Cria um lote vinculado ao setor
        $lot = Lot::factory()->create([
            'sector_id' => $sector->id,
        ]);

        $this->assertInstanceOf(Sector::class, $lot->sector);
        $this->assertEquals($sector->id, $lot->sector->id);
    }
}