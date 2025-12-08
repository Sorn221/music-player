<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CuratedController;

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Исполнители
Route::prefix('artist')->name('artist.')->group(function () {
    Route::get('/{artist:slug}', [ArtistController::class, 'show'])->name('show');
});

// Альбомы
Route::prefix('album')->name('album.')->group(function () {
    Route::get('/{album:slug}', [AlbumController::class, 'show'])->name('show');
    // Пример маршрута для фичи "Найди свой кавер"
    Route::get('/{album:slug}/covers', [AlbumController::class, 'showCovers'])->name('covers');
});

// Кураторские подборки (Темы, Теги)
Route::prefix('curated')->name('curated.')->group(function () {
    // Подборки по Лирике/Концепции
    Route::get('/theme/{theme:slug}', [CuratedController::class, 'showTheme'])->name('theme');
    // Подборки по Звуку/Атмосфере
    Route::get('/atmosphere/{tag:slug}', [CuratedController::class, 'showTag'])->name('tag');
});

// Андеграунд и Поддержка
Route::get('/underground/demos', [CuratedController::class, 'showDemos'])->name('demos');
Route::get('/map', [CuratedController::class, 'showMap'])->name('map');

// Форум/Сообщество (если реализуете)
Route::get('/forum', function () {
    // Временно заглушка
    return view('forum.index');
})->name('forum');