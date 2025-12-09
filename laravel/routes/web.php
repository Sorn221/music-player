<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

// --- AUTH / PROFILE (lightweight demo endpoints - replace with real controllers) ---
Route::get('/login', function () {
    // Front-end handles modal; this route kept for compatibility
    return redirect()->route('home');
})->name('login');

Route::get('/register', function () {
    return redirect()->route('home');
})->name('register');

// Demo JSON endpoints for frontend to POST to (they don't create real users).
Route::post('/auth/login', function (Request $request) {
    // Basic placeholder to keep front-end happy; replace with real auth logic.
    return response()->json([
        'ok' => true,
        'message' => 'Demo login accepted'
    ]);
});
Route::post('/auth/register', function (Request $request) {
    return response()->json([
        'ok' => true,
        'message' => 'Demo register accepted'
    ]);
});
Route::post('/auth/logout', function (Request $request) {
    return response()->json(['ok' => true, 'message' => 'Logged out (demo)']);
});

// Profile page (you have a view at resources/views/profile/show.blade.php)
Route::get('/profile', function (Request $request) {
    // In a real app use auth and controller: return view('profile.show', ['user' => Auth::user()]);
    $demoUser = (object)[
        'name' => 'Demo Fan',
        'created_at' => now(),
        'albums_listened_count' => 174,
        'norway_percent' => '23%',
        'collection_count' => 12,
        'collection_albums' => collect()
    ];
    return view('profile.show', ['user' => $demoUser]);
})->name('profile.show');

