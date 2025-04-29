<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            ProducersSeeder::class,
            EventsSeeder::class,
            SectorsSeeder::class,
            LotsSeeder::class,
            TicketsSeeder::class,
            DiscountCouponsSeeder::class,
            PaymentsSeeder::class,
        ]);
    }
}
