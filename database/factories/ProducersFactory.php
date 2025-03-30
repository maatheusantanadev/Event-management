<?php

namespace Database\Factories\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producers\Producer>
 */
class ProducersFactory extends Factory
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
            'company_name' => $this->faker->company(),
            'cnpj' => $this->faker->unique()->numerify('##.###.###/####-##'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
