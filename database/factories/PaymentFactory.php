<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class PaymentFactory extends Factory
{
   
    public function definition(): array
    {
        return [
            'ticket_id' => \App\Models\Ticket::factory(), 
            'transaction_id' => $this->faker->unique()->uuid(),
            'amount' => $this->faker->randomFloat(2, 20, 500), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
