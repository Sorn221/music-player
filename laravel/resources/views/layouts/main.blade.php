<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Архив') | BLACK SUN ARCHIVES</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="theme-dark-void">

    <header class="app-header">
        <div class="logo">
            <a href="{{ route('home') }}">BLACK SUN ARCHIVES</a>
        </div>
        <nav>
            <a href="{{ route('home') }}">ГЛАВНАЯ</a>
            <a href="{{ route('curated.theme', ['theme' => 'satanism-anti-christianity']) }}">КОНЦЕПЦИИ</a>
            <a href="{{ route('curated.tag', ['tag' => 'lo-fi-rawness']) }}">АТМОСФЕРА</a>
            <a href="{{ route('demos') }}">АНДЕГРАУНД</a>
            </nav>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="app-footer">
        <p>© {{ date('Y') }} Black Sun Archives. Культурный хаб и архив. | Курсовой проект.</p>
        </footer>
    
    <script>
        function toggleLyrics(trackId) {
            const element = document.getElementById(trackId);
            element.classList.toggle('lyrics-hidden');
        }
    </script>
</body>
</html>