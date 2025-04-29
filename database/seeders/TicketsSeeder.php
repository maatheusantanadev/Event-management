<?php

namespace Database\Seeders;

use App\Models\Lot;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TicketsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $lot = Lot::first();

        if (!$user || !$lot) {
            $this->command->warn('Usuário ou Lote não encontrado. Execute os seeders de Users e Lots primeiro.');
            return;
        }

        $tickets = [
            [
                'user_id' => $user->id,
                'lot_id' => $lot->id,
                'status' => 'pago',
                'qr_code' => Str::uuid(),
            ],
            [
                'user_id' => $user->id,
                'lot_id' => $lot->id,
                'status' => 'pendente',
                'qr_code' => Str::uuid(),
            ],
        ];

        foreach ($tickets as $data) {
            Ticket::create($data);
        }
    }
}