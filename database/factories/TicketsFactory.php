<?php

namespace Database\Factories\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tickets\Ticket>
 */
class TicketsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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