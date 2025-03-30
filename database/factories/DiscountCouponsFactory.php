<?php

namespace Database\Factories\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discounts_coupons\Discount_coupons>
 */
class DiscountCouponsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
