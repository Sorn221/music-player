<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Track;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    // Заглушка для URL аудиофайла
    private $demoAudioUrl = 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3';

    /**
     * Получить метаданные одного трека.
     * @param Track $track
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTrack(Track $track)
    {
        // Загружаем связанные данные (Artist и Album)
        $track->load('album.artist');

        return response()->json([
            'id' => $track->id,
            'title' => $track->title,
            'artist' => $track->album->artist->name,
            'album' => $track->album->title,
            'cover_url' => asset($track->album->cover_image_path), // Полный URL к обложке
            'audio_url' => $this->demoAudioUrl, // ДЕМО-URL, здесь будет ваш реальный файл
            'duration' => $track->duration,
            'track_number' => $track->track_number,
        ]);
    }

    /**
     * Получить список всех треков альбома.
     * @param Album $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAlbumTracks(Album $album)
    {
        // Загружаем треки, артиста и обложку
        $tracks = $album->tracks()->orderBy('track_number')->get();
        $artistName = $album->artist->name;
        $coverUrl = asset($album->cover_image_path);

        $tracksData = $tracks->map(function ($track) use ($artistName, $album, $coverUrl) {
            return [
                'id' => $track->id,
                'title' => $track->title,
                'artist' => $artistName,
                'album' => $album->title,
                'cover_url' => $coverUrl,
                'audio_url' => $this->demoAudioUrl, // ДЕМО-URL
                'duration' => $track->duration,
                'track_number' => $track->track_number,
            ];
        });

        return response()->json([
            'album_title' => $album->title,
            'tracks' => $tracksData
        ]);
    }
}
