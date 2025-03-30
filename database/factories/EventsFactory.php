<?php

namespace Database\Factories\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Events\Event>
 */
class EventsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
