<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Topic;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Создание тестовых пользователей
        $users = [
            User::create([
                'name' => 'Archivist_Quorthon',
                'email' => 'q@example.com',
                'password' => Hash::make('password')
            ]),
            User::create([
                'name' => 'The_Mayhem_Fan',
                'email' => 'mayhem@example.com',
                'password' => Hash::make('password')
            ]),
            User::create([
                'name' => 'Atmospheric_Drifter',
                'email' => 'drifter@example.com',
                'password' => Hash::make('password')
            ]),
        ];

        $userQuorthon = $users[0];
        $userMayhem = $users[1];
        $userDrifter = $users[2];

        // 2. Создание Тем

        // Тема 1: Классическая
        $topic1 = Topic::create([
            'user_id' => $userQuorthon->id,
            'title' => 'Mayhem vs Darkthrone: Кто оказал большее влияние на сцену 90-х?',
            'slug' => Str::slug('Mayhem-vs-Darkthrone') . '-' . time(),
        ]);

        // Тема 2: Атмосферная
        $topic2 = Topic::create([
            'user_id' => $userDrifter->id,
            'title' => 'Лучшие альбомы для осеннего леса (Atmospheric Black Metal)',
            'slug' => Str::slug('Atmospheric-Black-Metal') . '-' . time(),
        ]);

        // Тема 3: Не блэк-метал (для проверки разнообразия)
        $topic3 = Topic::create([
            'user_id' => $userMayhem->id,
            'title' => 'Обсуждение нового альбома Deftones – стоит ли слушать?',
            'slug' => Str::slug('Deftones-New-Album') . '-' . time(),
        ]);

        // 3. Создание Сообщений (Посты)

        // Посты для Topic 1
        $post1_1 = Post::create([
            'topic_id' => $topic1->id,
            'user_id' => $userQuorthon->id,
            'content' => 'Я считаю, что ранние Mayhem задали эстетику, но Darkthrone с их "нечеловеческим" звуком сделали жанр по-настоящему андеграундным. Ваши мнения?',
        ]);

        $post1_2 = Post::create([
            'topic_id' => $topic1->id,
            'user_id' => $userMayhem->id,
            'content' => 'Без Mayhem и Varg Vikernes не было бы той легенды. Darkthrone – это скорее развитие идеи. Demos! Demos! Demos!',
        ]);

        // Посты для Topic 2
        $post2_1 = Post::create([
            'topic_id' => $topic2->id,
            'user_id' => $userDrifter->id,
            'content' => 'Привет всем! Ищу идеальную музыку для долгих прогулок. Wolves in the Throne Room, конечно, лидеры, но что еще посоветуете?',
        ]);

        // 4. Обновление счетчиков и последнего поста

        // Topic 1
        $topic1->posts_count = 2;
        $topic1->last_post_id = $post1_2->id;
        $topic1->updated_at = $post1_2->created_at; // Важно для сортировки на главной
        $topic1->save();

        // Topic 2
        $topic2->posts_count = 1;
        $topic2->last_post_id = $post2_1->id;
        $topic2->updated_at = $post2_1->created_at;
        $topic2->save();

        // Topic 3 (пока без ответов)
        $topic3->posts_count = 0;
        $topic3->last_post_id = null;
        $topic3->save();
    }
}
