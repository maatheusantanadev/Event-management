<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; 


class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt(Str::random(10)),
            'phone' => $this->faker->unique()->phoneNumber(),
            'cpf_cnpj' => $this->faker->unique()->numerify('###########'),
            'role' => $this->faker->randomElement(['admin', 'produtor', 'cliente']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}