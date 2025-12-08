<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Track;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Отображает детальную страницу альбома.
     */
    public function show(Album $album)
    {
        // Загружаем связанные данные: артиста, треки (по номеру) и теги/темы
        $album->load([
            'artist',
            'label',
            'tracks' => function($query) {
                $query->orderBy('track_number', 'asc');
            },
            'tags',
            'themes'
        ]);

        // --- Реализация Уникального Алгоритма Рекомендаций (Пункт 2) ---
        
        // 1. Получаем ID тегов текущего альбома
        $tagIds = $album->tags->pluck('id')->toArray();

        // 2. Используем Query Scope для поиска похожих (см. раздел 5 прошлого ответа)
        $recommendations = Album::withSimilarAtmosphere($tagIds, 2)
                                ->with('artist')
                                ->take(5)
                                ->get();
        // -----------------------------------------------------------------

        return view('album.show', [
            'album' => $album,
            'recommendations' => $recommendations,
        ]);
    }

    /**
     * Пример метода для фичи "Найди свой кавер" (пока заглушка).
     */
    public function showCovers(Album $album)
    {
        // В реальном проекте здесь будет сложный запрос, ищущий треки,
        // чья лирика или название содержат отсылку к $album->artist->name.

        $covers = []; // Здесь будут результаты

        return view('album.covers', [
            'album' => $album,
            'covers' => $covers,
        ]);
    }
}