<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class DiscountCouponFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->lexify('???-???-???')), 
            'discount' => $this->faker->randomFloat(2, 5, 50), 
            'max_uses' => $this->faker->numberBetween(1, 10), 
            'used_count' => $this->faker->numberBetween(0, 5), 
            'expires_at' => $this->faker->dateTimeBetween('+1 week', '+6 months'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
