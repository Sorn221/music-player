<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Theme;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Отображает главную страницу с кураторскими подборками.
     */
    public function index()
    {
        // Получаем 6 самых свежих альбомов
        $latestAlbums = Album::with('artist', 'tags')
                            ->orderBy('release_year', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->take(6)
                            ->get();

        // Получаем одну случайную тему для кураторской подборки
        $featuredTheme = Theme::inRandomOrder()->first();

        // Если тема найдена, получаем 4 альбома для этой темы
        $featuredAlbums = collect();
        if ($featuredTheme) {
             $featuredAlbums = $featuredTheme->albums()
                                             ->with('artist')
                                             ->inRandomOrder()
                                             ->take(4)
                                             ->get();
        }

        return view('home.index', [
            'latestAlbums' => $latestAlbums,
            'featuredTheme' => $featuredTheme,
            'featuredAlbums' => $featuredAlbums,
        ]);
    }
}