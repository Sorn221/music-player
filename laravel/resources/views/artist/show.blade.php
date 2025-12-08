@extends('layouts.main')

@section('title', $artist->name)

@section('content')

    <div class="artist-header">
        <img src="{{ asset('img/artists/' . $artist->slug . '_profile.jpg') }}" 
             alt="{{ $artist->name }}" class="artist-image">
        
        <div class="artist-info">
            <h1 class="page-title">{{ $artist->name }}</h1>
            <p><strong>Страна:</strong> {{ $artist->country->name ?? 'Неизвестна' }}</p>
            <p><strong>Год основания:</strong> {{ $artist->formed_year }}</p>
            <p class="artist-bio">{{ $artist->bio }}</p>
            
            @if ($artist->is_underground)
                <p class="tag underground-flag">Андеграунд | Демо-сцена</p>
            @endif
        </div>
    </div>
    
    <hr style="border-color: var(--color-border); margin: 30px 0;">

    <div class="influence-grid">
        <section>
            <h2>⚔️ Повлиял на (Influenced)</h2>
            @if ($artist->influenced->count())
                <ul class="influence-list">
                    @foreach ($artist->influenced as $inf_artist)
                        <li><a href="{{ route('artist.show', $inf_artist->slug) }}">{{ $inf_artist->name }}</a></li>
                    @endforeach
                </ul>
            @else
                <p class="text-secondary">Пока что в архиве нет известных последователей.</p>
            @endif
        </section>

        <section>
            <h2>🌳 Под влиянием (Influencers)</h2>
            @if ($artist->influencers->count())
                <ul class="influence-list">
                    @foreach ($artist->influencers as $inf_artist)
                        <li><a href="{{ route('artist.show', $inf_artist->slug) }}">{{ $inf_artist->name }}</a></li>
                    @endforeach
                </ul>
            @else
                <p class="text-secondary">Данные о прямых влияниях отсутствуют.</p>
            @endif
        </section>
    </div>
    
    <hr style="border-color: var(--color-border); margin: 30px 0;">

    <h2 class="section-title">Дискография</h2>
    <div class="latest-releases">
        @foreach ($artist->albums as $album)
            <div class="album-card">
                <img src="{{ asset($album->cover_image_path) }}" alt="{{ $album->title }}" class="album-cover">
                <h3><a href="{{ route('album.show', $album->slug) }}">{{ $album->title }}</a></h3>
                <p class="text-secondary">({{ $album->release_year }})</p>
            </div>
        @endforeach
    </div>

@endsection

<style>
.artist-header {
    display: flex;
    gap: 30px;
    align-items: flex-start;
}
.artist-image {
    width: 250px;
    height: 250px;
    object-fit: cover;
    border: 3px solid var(--color-accent-blood);
    flex-shrink: 0;
}
.artist-info {
    flex-grow: 1;
}
.artist-bio {
    margin-top: 15px;
    font-style: italic;
    color: var(--color-text-secondary);
}
.influence-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}
.influence-list {
    list-style: none;
    padding: 0;
    margin-top: 15px;
}
.influence-list li {
    padding: 5px 0;
    border-bottom: 1px dotted #222;
}
.underground-flag {
    color: var(--color-accent-blood);
    font-weight: bold;
}
</style>