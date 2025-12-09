@extends('layouts.main')

@section('title', $title)

@section('content')
    <h1 class="page-title">{{ $title }}</h1>

    @if ($albums->isEmpty())
        <p>В этом разделе пока нет записей, соответствующих критериям.</p>
    @else
        <p class="text-secondary">Найдено {{ $albums->total() }} альбомов.</p>

        <div class="latest-releases">
            @foreach ($albums as $album)
                <div class="album-card">
                    <img src="{{ asset($album->cover_image_path) }}" alt="{{ $album->title }}" class="album-cover">
                    <h3><a href="{{ route('album.show', $album->slug) }}">{{ $album->title }}</a></h3>
                    <p class="text-secondary">{{ $album->artist->name }} ({{ $album->release_year }})</p>
                    <div class="tags">
                        @foreach ($album->tags->take(2) as $tag)
                            <span class="tag atmosphere-{{ $tag->slug }}">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-links" style="margin-top: 30px; text-align: center;">
            {{ $albums->links() }}
        </div>

    @endif
@endsection

<style>
/* Стили для пагинации (стандартный Blade links() создает HTML) */
.pagination-links nav {
    /* Добавляем стили для центрирования и темной темы */
    display: inline-block;
    color: var(--color-text-primary);
}
.pagination-links .page-item {
    display: inline-block;
    margin: 0 5px;
}
.pagination-links .page-link {
    color: var(--color-text-secondary);
    padding: 5px 10px;
    border: 1px solid var(--color-border);
}
.pagination-links .page-item.active .page-link {
    background: var(--color-accent-blood);
    color: white;
    border-color: var(--color-accent-blood);
}
</style>
