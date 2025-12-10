<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\CuratedController;
use App\Http\Controllers\ForumController;

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

// --- КУРАТОРСКИЕ ПОДБОРКИ (Темы, Теги) ---
Route::prefix('curated')->name('curated.')->group(function () {
    // Общая страница со списком всех подборок
    Route::get('/', [CuratedController::class, 'index'])->name('index');

    // Подборки по Лирике/Концепции
    Route::get('/theme/{theme:slug}', [CuratedController::class, 'showTheme'])->name('theme');
    // Подборки по Звуку/Атмосфере
    Route::get('/atmosphere/{tag:slug}', [CuratedController::class, 'showTag'])->name('tag');
});

// Андеграунд и Карта
Route::get('/underground/demos', [CuratedController::class, 'showDemos'])->name('demos');
Route::get('/map', [CuratedController::class, 'showMap'])->name('map');


// --- AUTH / PROFILE (Demo endpoints) ---

// Примечание: Эти маршруты остаются для демонстрации, но должны быть заменены
// на реальную систему аутентификации (Laravel Breeze/Jetstream) в рабочем приложении.
Route::get('/login', fn() => redirect()->route('home'))->name('login');
Route::get('/register', fn() => redirect()->route('home'))->name('register');

// Demo JSON endpoints for frontend
Route::post('/auth/login', function (Request $request) {
    return response()->json(['ok' => true, 'message' => 'Demo login accepted']);
});
Route::post('/auth/register', function (Request $request) {
    return response()->json(['ok' => true, 'message' => 'Demo register accepted']);
});
Route::post('/auth/logout', function (Request $request) {
    return response()->json(['ok' => true, 'message' => 'Logged out (demo)']);
});

// Profile page
Route::get('/profile', function (Request $request) {
    // В реальном приложении: ['user' => Auth::user()]
    $demoUser = (object)[
        'name' => 'Demo Fan',
        'created_at' => now(),
        'albums_listened_count' => 174,
        'norway_percent' => '23%',
        'collection_count' => 12,
        'collection_albums' => App\Models\Album::inRandomOrder()->take(5)->get()
    ];
    return view('profile.show', ['user' => $demoUser]);
})->name('profile.show');


// --- ФОРУМ / СООБЩЕСТВО ---
Route::prefix('forum')->name('forum.')->group(function () {
    // Список всех тем. URL: /forum
    Route::get('/', [ForumController::class, 'index'])->name('index');

    // Страница создания новой темы
    Route::get('/create', [ForumController::class, 'create'])->name('create')->middleware('auth');
    Route::post('/', [ForumController::class, 'store'])->name('store')->middleware('auth');

    // Просмотр конкретной темы (обсуждения)
    Route::get('/{topic:slug}', [ForumController::class, 'show'])->name('show');

    // Отправка нового сообщения в тему
    Route::post('/{topic:slug}/reply', [ForumController::class, 'storePost'])->name('reply')->middleware('auth');
});
