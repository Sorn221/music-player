<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            'Forest Mysticism', // Лесной мистицизм
            'Cosmic Horror',    // Космический ужас
            'Satanism & Anti-Christianity',
            'Paganism & Norse Mythology',
            'Depression & Isolation',
        ];

        foreach ($themes as $theme) {
            DB::table('themes')->insert([
                'name' => $theme,
                'slug' => Str::slug($theme),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}