<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class LotFactory extends Factory
{

    public function definition(): array
    {
        return [
            'sector_id' => \App\Models\Sector::factory(),
            'name' => $this->faker->word() . ' Lot',
            'price' => $this->faker->randomFloat(2, 10, 500),
            'quantity' => $this->faker->numberBetween(10, 500),
            'start_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
