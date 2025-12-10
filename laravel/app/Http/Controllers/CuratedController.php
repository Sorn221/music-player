<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Theme;
use App\Models\Tag;
use Illuminate\Http\Request;

class CuratedController extends Controller
{
    /**
     * Отображает главную страницу подборок (список всех тем и тегов).
     * Соответствует маршруту /curated (curated.index)
     */
    public function index()
    {
        // Получаем все темы и теги для отображения на обзорной странице
        $themes = Theme::orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('curated.index', compact('themes', 'tags'));
    }

    /**
     * Отображает все альбомы, связанные с определенной Темой (Лирика/Концепция).
     * Соответствует маршруту /curated/theme/{slug} (curated.theme)
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
     * Соответствует маршруту /curated/atmosphere/{slug} (curated.tag)
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
     * Соответствует маршруту /underground/demos (demos)
     */
    public function showDemos()
    {
        // Ищем альбомы, помеченные как демо, или артистов, помеченных как андеграунд
        // Используем where/orWhereHas, чтобы найти оба типа контента
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

    /**
     * Отображает карту (заглушка, если вы не реализовали).
     * Соответствует маршруту /map (map)
     */
    public function showMap()
    {
        return view('curated.map', [
            'title' => '🗺️ Карта блэк-метал сцены'
        ]);
    }
}
