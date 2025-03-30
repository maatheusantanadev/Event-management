<?php

namespace Database\Factories\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lots\Lot>
 */
class LotsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
