<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Архив') | BLACK SUN ARCHIVES</title>

    <!-- Bootstrap CSS + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" integrity="" crossorigin="anonymous">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="theme-dark-void">

    <header class="app-header d-flex align-items-center px-3">
        <div class="logo me-3">
            <a href="{{ route('home') }}">BLACK SUN ARCHIVES</a>
        </div>

        <!-- Bootstrap-friendly wider search -->
        <div class="header-search me-3">
            <span class="search-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            <input type="text" class="form-control border-0 bg-transparent" placeholder="Поиск групп, альбомов, тегов..." aria-label="Поиск">
        </div>

        <nav class="me-auto d-none d-md-flex">
            <a class="nav-link text-secondary" href="{{ route('forum.index') }}">Сообщество</a>
            <a class="nav-link text-secondary" href="{{ route('demos') }}">Андеграунд</a>
        </nav>

        <div class="header-actions d-flex align-items-center">
            <div class="header-auth-target">
                <!-- JS рендерит: ссылки Войти/Регистрация или аватар профиля -->
            </div>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="app-footer">
        <p>© {{ date('Y') }} Black Sun Archives — архив и сервис стриминга, ориентированный на метал. Все тексты на сайте — для демонстрации.</p>
    </footer>

    <!-- Auth modal (dev) -->
    <div class="auth-modal" aria-hidden="true" style="display:none;">
        <div class="modal" role="dialog" aria-modal="true">
            <button data-close-auth style="float:right; background:none; border:none; color:var(--color-text-secondary);">✕</button>
            <h3 class="modal-title">Вход</h3>

            <form id="auth-form">
                <input type="hidden" name="mode" value="login">
                <div class="row-name" style="display:none;">
                    <label>Имя</label>
                    <input type="text" name="name" placeholder="Псевдоним">
                </div>
                <label>Email</label>
                <input type="email" name="email" placeholder="you@example.com" required>
                <label>Пароль</label>
                <input type="password" name="password" placeholder="••••••" required>

                <div class="modal-actions">
                    <button type="button" class="btn" data-close-auth>Отмена</button>
                    <button type="submit" class="btn primary">Продолжить</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="" crossorigin="anonymous"></script>

    <script src="{{ asset('js/scripts.js') }}"></script>

    <script>
        function toggleLyrics(trackId) {
            const element = document.getElementById(trackId);
            if (element) element.classList.toggle('lyrics-hidden');
        }
    </script>
    {{-- СКВОЗНОЙ МИНИ-ПЛЕЕР --}}
    <div id="mini-player" class="mini-player fixed-bottom" style="display:none;">
        <div class="container d-flex align-items-center justify-content-between">

            {{-- 1. Информация о треке --}}
            <div class="d-flex align-items-center flex-grow-1 me-3" style="max-width: 300px;">
                <img id="player-cover" src="" alt="Обложка" class="player-cover me-3">
                <div>
                    <div id="player-title" class="fw-bold text-truncate" title=""></div>
                    <div id="player-artist" class="text-secondary small text-truncate" title=""></div>
                </div>
            </div>

            {{-- 2. Элементы управления и Прогресс --}}
            <div class="d-flex flex-column align-items-center mx-3 flex-grow-1" style="max-width: 50%;">

                {{-- Управление --}}
                <div class="controls mb-1">
                    <button id="btn-prev" class="btn btn-sm" title="Предыдущий"><i class="fas fa-step-backward"></i></button>
                    <button id="btn-play-pause" class="btn btn-primary btn-sm rounded-circle mx-3" style="width: 40px; height: 40px;"><i class="fas fa-play"></i></button>
                    <button id="btn-next" class="btn btn-sm" title="Следующий"><i class="fas fa-step-forward"></i></button>
                </div>

                {{-- Прогресс-бар --}}
                <div class="w-100 d-flex align-items-center mt-1">
                    <span id="player-time-current" class="small text-secondary me-2">0:00</span>
                    <input type="range" id="player-progress" class="form-range flex-grow-1" value="0" min="0" max="100">
                    <span id="player-time-total" class="small text-secondary ms-2">0:00</span>
                </div>
            </div>

            {{-- 3. Дополнительные элементы (Громкость) --}}
            <div class="d-flex align-items-center justify-content-end" style="width: 200px;">
                <i class="fas fa-volume-up text-secondary me-2"></i>
                <input type="range" id="player-volume" class="form-range" value="50" min="0" max="100" style="width: 100px;">
            </div>

        </div>
    </div>

    <audio id="audio-element"></audio>

{{--    <script src="https://kit.fontawesome.com/ВАШ_KEY_FA.js"></script>--}}
    <script src="{{ asset('js/player.js') }}"></script>
    @yield('scripts')
</body>
</html>
