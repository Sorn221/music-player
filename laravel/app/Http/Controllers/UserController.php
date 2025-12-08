<?php

namespace App\Http\Controllers;

use App\Models\User; // Предполагается, что модель User существует
use App\Models\Album;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Отображает профиль пользователя и его коллекцию.
     */
    public function show($username = 'DemoArchivist')
    {
        // В реальном проекте: $user = User::where('username', $username)->firstOrFail();
        
        // --- Демонстрационные данные для курсовой ---
        // Создаем фиктивный объект пользователя
        $user = (object) [
            'name' => $username,
            'created_at' => now()->subYears(2),
            'albums_listened_count' => 174,
            'norway_percent' => '23%',
            'collection_count' => 5,
        ];
        
        // Получаем тестовые альбомы для "коллекции"
        $collectionAlbums = Album::with('artist')->take(5)->get();

        return view('profile.show', [
            'user' => $user,
            'collection_albums' => $collectionAlbums,
        ]);
    }
}