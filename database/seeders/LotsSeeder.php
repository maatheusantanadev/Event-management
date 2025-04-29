<?php

namespace Database\Seeders;

use App\Models\Lot;
use App\Models\Sector;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class LotsSeeder extends Seeder
{
    public function run(): void
    {
        $sector = Sector::first();

        if (!$sector) {
            $this->command->warn('Nenhum setor encontrado. Execute o SectorsSeeder primeiro.');
            return;
        }

        $today = Carbon::today();

        $lots = [
            [
                'name' => 'Lote 1',
                'price' => 50.00,
                'quantity' => 100,
                'start_date' => $today,
                'end_date' => $today->copy()->addDays(10),
            ],
            [
                'name' => 'Lote 2',
                'price' => 70.00,
                'quantity' => 50,
                'start_date' => $today->copy()->addDays(11),
                'end_date' => $today->copy()->addDays(20),
            ],
        ];

        foreach ($lots as $data) {
            Lot::create(array_merge($data, ['sector_id' => $sector->id]));
        }
    }
}
