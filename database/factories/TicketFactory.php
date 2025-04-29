<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(), 
            'lot_id' => \App\Models\Lot::factory(), 
            'status' => $this->faker->randomElement(['pendente', 'pago', 'cancelado']),
            'qr_code' => $this->faker->unique()->uuid(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}