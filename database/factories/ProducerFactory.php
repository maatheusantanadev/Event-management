<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


class ProducerFactory extends Factory
{

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
