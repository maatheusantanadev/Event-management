<?php

namespace Database\Factories\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payments\Payment>
 */
class PaymentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_id' => \App\Models\Ticket::factory(), 
            'transaction_id' => $this->faker->unique()->uuid(), 
            'amount' => $this->faker->randomFloat(2, 20, 500), 
            'status' => $this->faker->randomElement(['pendente', 'confirmado', 'falha']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
