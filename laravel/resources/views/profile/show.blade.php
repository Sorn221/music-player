@extends('layouts.main')

@section('title', 'Профиль: ' . $user->name)

@section('content')

    <div class="profile-header">
        <h1 class="page-title">Архивист: {{ $user->name }}</h1>
        <p class="text-secondary">Дата регистрации: {{ $user->created_at->format('Y-m-d') }}</p>
    </div>

    <hr style="border-color: var(--color-border); margin: 30px 0;">

    <div class="stats-grid">
        <div class="stat-card">
            <h3>🎧 Аудио Диета</h3>
            <p>Прослушано альбомов: <strong>{{ $user->albums_listened_count ?? 174 }}</strong></p>
            <p>Топ-5 самых мрачных альбомов за месяц: <span class="stat-value">Burzum - Filosofem</span></p>
        </div>
        <div class="stat-card">
            <h3>🇳🇴 География</h3>
            <p>Процент норвежского блэка: <strong class="stat-value">{{ $user->norway_percent ?? '23%' }}</strong></p>
            <p>Самая популярная страна: <span class="stat-value">Швеция</span></p>
        </div>
        <div class="stat-card">
            <h3>🏷️ Атмосфера</h3>
            <p>Доминирующий тег: <span class="stat-value">Atmospheric (45%)</span></p>
            <p>Любимая концепция: <span class="stat-value">Cosmic Horror</span></p>
        </div>
    </div>

    <hr style="border-color: var(--color-border); margin: 30px 0;">

    <h2 class="section-title">Виртуальная Полка Коллекционера</h2>
    <p class="text-secondary">Ваша коллекция физических и цифровых носителей ({{ $user->collection_count ?? 12 }} записей).</p>
    
    <div class="latest-releases">
        @forelse ($user->collection_albums ?? collect() as $album)
            <div class="album-card">
                <img src="{{ asset($album->cover_image_path) }}" alt="{{ $album->title }}" class="album-cover">
                <h3><a href="{{ route('album.show', $album->slug) }}">{{ $album->title }}</a></h3>
                <p class="text-secondary">{{ $album->artist->name }}</p>
                <div class="tags"><span class="tag atmosphere-lo-fi-rawness">Кассета</span></div>
            </div>
        @empty
            <p style="grid-column: 1 / -1;">Ваша полка пуста. Добавьте свои первые сокровища!</p>
        @endforelse
    </div>

@endsection

<style>
/* Стили для profile/show.blade.php */
.profile-header {
    margin-bottom: 20px;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}
.stat-card {
    background: #1a1a1a;
    padding: 20px;
    border: 1px solid #222;
}
.stat-card h3 {
    border: none;
    margin-top: 0;
    font-size: 1.2em;
    color: var(--color-accent-blood);
}
.stat-value {
    color: var(--color-text-primary);
    font-weight: bold;
}
/* Временные стили для демонстрации: */
.latest-releases {
    /* Чтобы не было конфликта с общими стилями */
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
}
</style>