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
            <a class="nav-link text-secondary" href="{{ route('forum') }}">Сообщество</a>
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
</body>
</html>
