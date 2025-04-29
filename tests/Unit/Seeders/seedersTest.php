<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class SeedersTest extends TestCase
{
    use RefreshDatabase; 

    public function test_all_seeders()
    {
        Artisan::call('db:seed', ['--class' => 'UserSeeder']);
        Artisan::call('db:seed', ['--class' => 'ProducersSeeder']);
        Artisan::call('db:seed', ['--class' => 'EventsSeeder']);
        Artisan::call('db:seed', ['--class' => 'SectorsSeeder']);
        Artisan::call('db:seed', ['--class' => 'LotsSeeder']);
        Artisan::call('db:seed', ['--class' => 'TicketsSeeder']);
        Artisan::call('db:seed', ['--class' => 'DiscountCouponsSeeder']);
        Artisan::call('db:seed', ['--class' => 'PaymentsSeeder']);

        // Testando o seeder de usuários
        $this->assertDatabaseHas('users', [
            'email' => 'matheusfeira2017@gmail.com', 
        ]);

        // Testando o seeder de produtores
        $this->assertDatabaseHas('producers', [
            'company_name' => 'Empresa Exemplo LTDA', 
        ]);

        // Testando o seeder de eventos
        $this->assertDatabaseHas('events', [
            'title' => 'Festival de Música 2025', 
        ]);

        // Testando o seeder de setores
        $this->assertDatabaseHas('sectors', [
            'name' => 'Pista', 
        ]);

        // Testando o seeder de lotes
        $this->assertDatabaseHas('lots', [
            'name' => 'Lote 1', 
        ]);

        // Testando o seeder de tickets
        $this->assertDatabaseHas('tickets', [
            'status' => 'pendente', 
        ]);

        // Testando o seeder de cupons de desconto
        $this->assertDatabaseHas('discount_coupons', [
            'code' => 'BEMVINDO10', 
        ]);

        // Testando o seeder de pagamentos
        $this->assertDatabaseHas('payments', [
            'amount' => 100.00, 
        ]);
    }
}