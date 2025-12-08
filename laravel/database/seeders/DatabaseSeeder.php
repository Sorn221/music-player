<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            TagSeeder::class,
            ThemeSeeder::class,
            // Сначала запускаем справочники, потом основной контент
            ContentSeeder::class, 
        ]);
    }
}