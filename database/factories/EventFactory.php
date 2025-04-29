<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'producer_id' => \App\Models\Producer::factory(), 
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(),
            'date' => $this->faker->dateTimeBetween('+1 week', '+1 year'),
            'location' => $this->faker->address(),
            'banner_url' => $this->faker->imageUrl(640, 480, 'events', true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
