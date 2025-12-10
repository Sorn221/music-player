<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlayerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| ...
*/

Route::middleware('api')->group(function () {

    // ВРЕМЕННЫЙ ТЕСТОВЫЙ МАРШРУТ (должен работать по адресу /api/test-route)
    Route::get('/test-route', function () {
        return response()->json(['status' => 'API is working!']);
    });

    // API для получения данных для плеера
    Route::prefix('player')->name('api.player.')->group(function () {
        // Получить метаданные одного трека по ID
        Route::get('track/{track}', [PlayerController::class, 'getTrack'])->name('track');

        // Получить список всех треков альбома по его slug
        Route::get('album/{album:slug}', [PlayerController::class, 'getAlbumTracks'])->name('album');
    });

    // ...
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
