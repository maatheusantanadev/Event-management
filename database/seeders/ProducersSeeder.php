<?php

namespace Database\Seeders;

use App\Models\Producer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProducersSeeder extends Seeder
{
    public function run(): void
    {

        $user = User::first() ?? User::factory()->create([
            'name' => 'Produtor Exemplo',
            'email' => 'produtor@example.com',
            'password' => bcrypt('password'),
        ]);

        Producer::create([
            'user_id' => $user->id,
            'company_name' => 'Empresa Exemplo LTDA',
            'cnpj' => Str::random(14),
        ]);
    }
}