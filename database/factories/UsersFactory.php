<?php

namespace Database\Factories\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // Não se esqueça de importar o Str para gerar senhas aleatórias

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users\User>
 */
class UsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt(Str::random(10)),
            'phone' => $this->faker->unique()->phoneNumber(),
            'cpf_cnpj' => $this->faker->unique()->numerify('###########'), // CPF/CNPJ numérico
            'role' => $this->faker->randomElement(['admin', 'produtor', 'cliente']), // Compatível com ENUM
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}