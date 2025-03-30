<?php

namespace Database\Factories\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notifications\Notification>
 */
class NotificationsFactory extends Factory
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
            'message' => $this->faker->paragraph(), 
            'status' => $this->faker->randomElement(['pendente', 'enviado', 'falha']), 
            'created_at' => now(),
        ];
    }
}
