<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Producer;
use App\Models\User;
use Illuminate\Database\Seeder;

class EventsSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create([
            'name' => 'Produtor do Evento',
            'email' => 'evento@produtor.com',
            'password' => bcrypt('password'),
        ]);

        $producer = Producer::first() ?? Producer::factory()->create([
            'user_id' => $user->id,
            'company_name' => 'Eventos Incríveis LTDA',
            'cnpj' => '12345678000199',
        ]);

        Event::create([
            'producer_id' => $producer->id,
            'title' => 'Festival de Música 2025',
            'description' => 'Um evento imperdível com várias atrações musicais.',
            'date' => now()->addMonth(), 
            'location' => 'Parque de Exposições, Salvador - BA',
            'banner_url' => 'https://example.com/banner.jpg',
        ]);
    }
}