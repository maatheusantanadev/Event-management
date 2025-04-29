<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Master',
            'email' => 'matheusfeira2017@gmail.com',
            'password' => Hash::make('password123'), 
            'phone' => '11999999999',
            'cpf_cnpj' => '12345678901',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Produtor Teste',
            'email' => 'produtor@example.com',
            'password' => Hash::make('password123'),
            'phone' => '11988888888',
            'cpf_cnpj' => '12345678000199',
            'role' => 'produtor',
        ]);

        User::create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@example.com',
            'password' => Hash::make('password123'),
            'phone' => '11977777777',
            'cpf_cnpj' => '98765432100',
            'role' => 'cliente',
        ]);
    }
}
