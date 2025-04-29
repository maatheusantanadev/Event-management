<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;
use App\Models\Sector;


class SectorFactory extends Factory
{
    protected $model = Sector::class;


    public function definition(): array
    {
        return [
            'event_id' => \App\Models\Event::factory(), 
            'name' => $this->faker->word(), 
            'capacity' => $this->faker->numberBetween(10, 500), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}