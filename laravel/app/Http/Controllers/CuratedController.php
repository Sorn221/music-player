<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Theme;
use App\Models\Tag;
use Illuminate\Http\Request;

class CuratedController extends Controller
{
    /**
     * Отображает все альбомы, связанные с определенной Темой (Лирика/Концепция).
     */
    public function showTheme(Theme $theme)
    {
        $albums = $theme->albums()
                        ->with('artist')
                        ->orderBy('release_year', 'desc')
                        ->paginate(12);

        return view('curated.listing', [
            'title' => 'Тема: ' . $theme->name,
            'albums' => $albums,
        ]);
    }

    /**
     * Отображает все альбомы, связанные с определенным Тегом (Атмосфера/Звук).
     */
    public function showTag(Tag $tag)
    {
        $albums = $tag->albums()
                      ->with('artist')
                      ->orderBy('release_year', 'desc')
                      ->paginate(12);

        return view('curated.listing', [
            'title' => 'Атмосфера: ' . $tag->name,
            'albums' => $albums,
        ]);
    }

    /**
     * Отображает раздел "Демо и незнакомцы".
     */
    public function showDemos()
    {
        // Ищем альбомы, помеченные как демо, или артистов, помеченных как андеграунд
        $albums = Album::where('is_demo', true)
                       ->orWhereHas('artist', function ($query) {
                           $query->where('is_underground', true);
                       })
                       ->with('artist')
                       ->orderBy('created_at', 'desc')
                       ->paginate(12);

        return view('curated.listing', [
            'title' => '🕯️ Демо и Незнакомцы (Поддержка Андеграунда)',
            'albums' => $albums,
        ]);
    }
}