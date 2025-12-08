@extends('layouts.main')

@section('title', 'Свежие Ритуалы и Кураторство')

@section('content')
    <h1 class="page-title">Свежие Ритуалы в Архиве</h1>

    <section class="latest-releases">
        @foreach ($latestAlbums as $album)
            <div class="album-card">
                <img src="{{ asset($album->cover_image_path) }}" alt="{{ $album->title }}" class="album-cover">
                <h3><a href="{{ route('album.show', $album->slug) }}">{{ $album->title }}</a></h3>
                <p class="text-secondary">{{ $album->artist->name }} ({{ $album->release_year }})</p>
                <div class="tags">
                    @foreach ($album->tags->take(3) as $tag)
                        <span class="tag atmosphere-{{ $tag->slug }}">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </section>

    <hr style="border-color: var(--color-border); margin: 40px 0;">

    @if ($featuredTheme && $featuredAlbums->count())
        <h2 class="section-title">Кураторская Подборка: {{ $featuredTheme->name }}</h2>
        <p class="text-secondary">Альбомы, объединённые концепцией лирики.</p>

        <section class="latest-releases">
            @foreach ($featuredAlbums as $album)
                <div class="album-card">
                    <img src="{{ asset($album->cover_image_path) }}" alt="{{ $album->title }}" class="album-cover">
                    <h3><a href="{{ route('album.show', $album->slug) }}">{{ $album->title }}</a></h3>
                    <p class="text-secondary">{{ $album->artist->name }} ({{ $album->release_year }})</p>
                </div>
            @endforeach
        </section>
        <p style="text-align: right; margin-top: 20px;">
            <a href="{{ route('curated.theme', $featuredTheme->slug) }}">Смотреть все записи по этой теме →</a>
        </p>
    @endif
@endsection

<style>
/* Стили для home/index.blade.php */
.text-secondary { color: var(--color-text-secondary); font-size: 0.9em; }
</style>