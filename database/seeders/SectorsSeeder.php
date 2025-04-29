<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Sector;
use Illuminate\Database\Seeder;

class SectorsSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();

        if (!$event) {
            $this->command->warn('Nenhum evento encontrado. Execute o EventsSeeder primeiro.');
            return;
        }

        $sectors = [
            ['name' => 'Pista', 'capacity' => 1000],
            ['name' => 'VIP', 'capacity' => 300],
            ['name' => 'Camarote', 'capacity' => 100],
        ];

        foreach ($sectors as $data) {
            Sector::create([
                'event_id' => $event->id,
                'name' => $data['name'],
                'capacity' => $data['capacity'],
            ]);
        }
    }
}