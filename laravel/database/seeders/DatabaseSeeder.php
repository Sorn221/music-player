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
            ContentSeeder::class,
            ForumSeeder::class,
        ]);
    }
}
