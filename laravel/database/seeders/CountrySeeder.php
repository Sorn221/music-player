<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            'Norway',
            'Sweden',
            'Finland',
            'United States',
            'Germany',
            'France',
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'name' => $country,
                'slug' => Str::slug($country),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}