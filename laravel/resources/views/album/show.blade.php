@extends('layouts.main')

@section('title', $album->title . ' - ' . $album->artist->name)

@section('content')

    <div class="album-view-grid">
        <aside class="album-sidebar">
            <img src="{{ asset($album->cover_image_path) }}" alt="{{ $album->title }}" class="full-cover">

            <h2>{{ $album->title }}</h2>
            <h4 style="color: var(--color-accent-blood); margin-top: -15px;">
                <a href="{{ route('artist.show', $album->artist->slug) }}">{{ $album->artist->name }}</a>
            </h4>

            <p>Год выпуска: {{ $album->release_year }}</p>
            <p>Лейбл: {{ $album->label->name ?? 'Неизвестен' }}</p>

            {{-- НОВАЯ КНОПКА ВОСПРОИЗВЕДЕНИЯ АЛЬБОМА --}}
            <button class="btn btn-primary btn-block mt-3 mb-4" onclick="playAlbum('{{ $album->slug }}')">
                <i class="fas fa-play"></i> Слушать альбом
            </button>

            <div class="metadata-tags">
                @foreach ($album->tags as $tag)
                    <a href="{{ route('curated.tag', $tag->slug) }}" class="tag atmosphere-{{ $tag->slug }}">{{ $tag->name }}</a>
                @endforeach
                @foreach ($album->themes as $theme)
                    <a href="{{ route('curated.theme', $theme->slug) }}" class="tag theme">{{ $theme->name }}</a>
                @endforeach
            </div>
        </aside>

        <section class="album-main-content">
            <h3>Треклист</h3>
            <ol class="track-list">
                @foreach ($album->tracks as $track)
                    <li class="track-item">
                        <div class="track-header">
                            {{-- ОБРАБОТЧИК КЛИКА НА НАЗВАНИЕ ТРЕКА --}}
                            <div class="d-flex align-items-center">
                            <span class="track-play-icon me-2 text-secondary" style="cursor: pointer;" onclick="playTrack({{ $track->id }}, event, {{ $loop->index }})">
                                <i class="fas fa-play"></i>
                            </span>
                                <a href="#" class="track-title text-white text-decoration-none" onclick="playTrack({{ $track->id }}, event, {{ $loop->index }})">
                                    <strong>{{ $track->track_number }}. {{ $track->title }}</strong>
                                </a>
                            </div>

                            <span class="track-duration">[{{ gmdate("i:s", $track->duration ?? 0) }}]</span>
                            @if ($track->lyrics)
                                <button onclick="toggleLyrics('track-lyrics-{{ $track->id }}')" class="lyrics-toggle">
                                    [Лирика]
                                </button>
                            @endif
                        </div>

                        @if ($track->lyrics)
                            <div id="track-lyrics-{{ $track->id }}" class="lyrics-block lyrics-hidden">
                                <pre>{{ $track->lyrics }}</pre>
                                <p class="small-note">Хочешь предложить перевод? <a href="#" style="color: var(--color-accent-blood);">Внести правки</a></p>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ol>

            @if ($recommendations->count())
                <h3 style="margin-top: 40px;">Схожая атмосфера</h3>
                <div class="latest-releases" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));">
                    @foreach ($recommendations as $recAlbum)
                        <div class="album-card">
                            <a href="{{ route('album.show', $recAlbum->slug) }}">
                                <img src="{{ asset($recAlbum->cover_image_path) }}" alt="{{ $recAlbum->title }}" class="album-cover">
                            </a>
                            <p style="margin: 5px 0 0 0; font-size: 0.9em;"><a href="{{ route('album.show', $recAlbum->slug) }}">{{ $recAlbum->title }}</a></p>
                        </div>
                    @endforeach
                </div>
            @endif

        </section>
    </div>

@endsection

@section('scripts')
    <script>
        // URL для API, используется PlayerController::getAlbumTracks
        const API_BASE_URL = '{{ url('/api/player/album') }}';

        /**
         * Запускает воспроизведение всего альбома
         */
        function playAlbum(albumSlug) {
            // Проверяем, существует ли наш глобальный объект плеера (AppPlayer из player.js)
            if (!window.AppPlayer) {
                console.error('Плеер не инициализирован. Убедитесь, что player.js подключен.');
                return;
            }

            // 1. Получаем плейлист с бэкенда через API
            fetch(`${API_BASE_URL}/${albumSlug}`)
                .then(response => response.json())
                .then(data => {
                    if (data.tracks && data.tracks.length > 0) {
                        // 2. Устанавливаем плейлист и запускаем первый трек
                        window.AppPlayer.setPlaylistAndPlay(data.tracks, 0);
                    } else {
                        alert('Треки для этого альбома не найдены.');
                    }
                })
                .catch(error => {
                    console.error('Ошибка при загрузке плейлиста:', error);
                    alert('Ошибка загрузки альбома.');
                });
        }

        /**
         * Запускает воспроизведение с конкретного трека
         */
        function playTrack(trackId, event, trackIndex) {
            event.preventDefault(); // Останавливаем переход по ссылке #

            // 1. Получаем slug альбома (нужен, чтобы получить ВЕСЬ плейлист)
            const albumSlug = '{{ $album->slug }}';

            // 2. Получаем плейлист и запускаем его с нужного индекса
            // Здесь мы повторно загружаем весь плейлист, чтобы обеспечить актуальность
            // и возможность сквозного перехода на других страницах.
            fetch(`${API_BASE_URL}/${albumSlug}`)
                .then(response => response.json())
                .then(data => {
                    if (data.tracks && data.tracks.length > 0) {
                        window.AppPlayer.setPlaylistAndPlay(data.tracks, trackIndex);
                    }
                })
                .catch(error => console.error('Ошибка при загрузке трека:', error));
        }

        /**
         * JS для переключения блока лирики
         */
        function toggleLyrics(elementId) {
            const element = document.getElementById(elementId);
            if (element) {
                element.classList.toggle('lyrics-hidden');
            }
        }
    </script>
@endsection


<style>
    /* Стили для album/show.blade.php */
    .album-view-grid {
        display: grid;
        grid-template-columns: 300px 1fr; /* Сайдбар и основной контент */
        gap: 40px;
    }
    .album-sidebar .full-cover {
        width: 300px;
        height: 300px;
        object-fit: cover;
        margin-bottom: 20px;
        border: 3px solid var(--color-border);
    }

    .btn-block {
        display: block;
        width: 100%;
    }
    .metadata-tags .tag.theme {
        background: #404040; /* Другой цвет для концептуальных тегов */
    }
    .track-list {
        list-style: none;
        padding: 0;
    }
    .track-item {
        border-bottom: 1px dashed #222;
        padding: 8px 0;
    }
    .track-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .track-play-icon {
        opacity: 0.6;
        transition: opacity 0.2s;
    }
    .track-item:hover .track-play-icon {
        opacity: 1; /* Подсвечиваем иконку при наведении */
        color: var(--color-accent-blood) !important;
    }

    .track-duration {
        color: var(--color-text-secondary);
        font-size: 0.85em;
        margin-left: auto; /* Сдвигает продолжительность вправо */
        margin-right: 20px; /* Отступ от кнопки "Лирика" */
    }

    /* Перенастройка расположения элементов в треклисте */
    .track-header > .d-flex {
        flex-grow: 1; /* Разрешает блоку с названием занимать место */
    }


    .lyrics-toggle {
        background: none;
        border: 1px solid var(--color-text-secondary);
        color: var(--color-text-secondary);
        padding: 2px 5px;
        cursor: pointer;
        font-size: 0.8em;
        text-transform: uppercase;
    }
    .lyrics-block {
        margin-top: 10px;
        padding: 10px;
        background: #111;
        border-left: 3px solid var(--color-accent-blood);
    }
    .lyrics-hidden {
        display: none;
    }
    pre {
        white-space: pre-wrap;
        font-family: var(--font-primary);
        font-size: 0.9em;
        color: var(--color-text-primary);
    }
    .small-note {
        font-size: 0.8em;
        margin-top: 5px;
        color: var(--color-text-secondary);
    }
</style>
