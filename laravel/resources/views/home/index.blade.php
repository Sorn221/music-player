@extends('layouts.main')

@section('title', 'Свежие ритуалы и кураторство')

@section('content')

    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('img/hero/slide1.jpg') }}" alt="slide1" width="1200px" height="600px">
                <div class="carousel-caption">
                    <h2>Архив ритуалов</h2>
                    <p class="lead">Кураторские подборки, редкие кассеты и демо — соберите свою тёмную библиотеку.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/hero/slide2.jpg') }}" alt="slide2" width="1200px" height="600px">
                <div class="carousel-caption">
                    <h2>Атмосферный поиск</h2>
                    <p class="lead">Ищи по настроению, концепции или редким тегам — мы храним то, что другие забыли.</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="{{ asset('img/hero/slide3.jpg') }}" alt="slide3" width="1200px" height="600px">
                <div class="carousel-caption">
                    <h2>Сообщество коллекционеров</h2>
                    <p class="lead">Обменивайся находками, обсуждай релизы и открывай скрытые реликвии сцены.</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Назад</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Вперёд</span>
        </button>
    </div>

    <section class="hero">
        <div class="hero-left">
            <h1>Black Sun Archives — стриминг для ценителей метала</h1>
            <p class="lead">Кураторские плейлисты, редкие демо и живой архив — всё о блэк, дум, дет и авант-гард метале. Слушайте альбомы, собирайте полки и исследуйте атмосферу.</p>
            <div class="cta-row">
                <a class="btn primary" href="{{ route('register') }}">Присоединиться</a>
                <a class="btn" href="#featured">Открыть подборки</a>
            </div>

            <div style="margin-top:18px;">
                <h4 style="margin-bottom:6px;">Новое на этой неделе</h4>
                <div class="playlist-grid" style="grid-template-columns: repeat(3, 1fr);">
                    @foreach($latestAlbums->take(3) as $album)
                        <div class="playlist-card" style="padding:8px;">
                            <img class="playlist-cover" src="{{ asset($album->cover_image_path) }}" alt="{{ $album->title }}">
                            <div style="display:flex; justify-content:space-between; align-items:center;">
                                <div>
                                    <strong style="display:block;">{{ $album->title }}</strong>
                                    <span class="text-secondary">{{ $album->artist->name }}</span>
                                </div>
                                <a href="{{ route('album.show', $album->slug) }}" class="btn" style="height:32px; align-self:center;">Слушать</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <aside>
            <div class="featured-card" id="featured">
                <img src="{{ asset('img/hero/slide4.jpg') }}" alt="Featured">
                <div>
                    <h3 style="margin:0;">Рекомендация: Ритуалы Ночи</h3>
                    <p class="text-secondary" style="margin:6px 0;">Кураторская подборка — атмосферный и сырой блэк-метал</p>
                    <div style="display:flex; gap:8px;">
                        <a class="btn primary" href="#">Включить</a>
                        <a href="{{ route('curated.theme', ['theme' => 'ritualism']) }}" class="btn">Изучить</a>
                    </div>
                </div>
            </div>

            <div style="margin-top:20px; background:#0b0b0b; padding:12px; border:1px solid #222;">
                <h4 style="margin:0 0 10px 0;">Слушайте везде</h4>
                <p class="text-secondary" style="margin:0 0 10px 0;">Синхронизация коллекций на мобильных устройствах — скоро.</p>
                <a class="btn" href="{{ route('demos') }}">Архив демо</a>
            </div>
        </aside>
    </section>

    <hr style="border-color: var(--color-border); margin: 30px 0;">

    <h2 class="section-title">Свежие релизы</h2>
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

    <p style="text-align:center; margin-top:28px;">
        <a href="{{ route('curated.index') }}" class="btn">Все подборки →</a>
    </p>
@endsection

<style>
/* Local tweaks for this page */
.section-title { font-family: var(--font-display); color: var(--color-accent-blood); margin-top:10px; }
</style>
