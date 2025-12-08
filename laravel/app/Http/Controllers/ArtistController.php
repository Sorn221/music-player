<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    /**
     * Отображает детальную страницу артиста.
     */
    public function show(Artist $artist)
    {
        // Загружаем альбомы, тех, кто повлиял (influencers), и тех, на кого повлиял артист (influenced)
        $artist->load([
            'albums' => function($query) {
                // Сортировка альбомов по году выпуска
                $query->orderBy('release_year', 'desc');
            },
            'influencers', // Артисты, которые повлияли на текущего (например, Bathory)
            'influenced'   // Артисты, на которых повлиял текущий (например, Darkthrone)
        ]);

        return view('artist.show', [
            'artist' => $artist,
        ]);
    }
}