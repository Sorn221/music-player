@extends('layouts.main')

@section('title', 'Все кураторские подборки')

@section('content')
    <div class="container py-5">
        <h1 class="text-white mb-4">🎵 Все Кураторские Подборки</h1>

        <div class="row">

            <div class="col-md-6 mb-5">
                <h2 class="text-secondary mb-3">Темы (Концепции и Лирика)</h2>
                <div class="list-group">
                    @forelse ($themes as $theme)
                        {{-- Ссылка на curated.theme --}}
                        <a href="{{ route('curated.theme', $theme->slug) }}" class="list-group-item list-group-item-action bg-dark text-white border-secondary mb-1 rounded">
                            {{ $theme->name }}
                        </a>
                    @empty
                        <p class="text-secondary">Темы пока не определены.</p>
                    @endforelse
                </div>
            </div>

            {{-- Секция Теги (Звук/Атмосфера) --}}
            <div class="col-md-6 mb-5">
                <h2 class="text-secondary mb-3">Теги (Звук и Атмосфера)</h2>
                <div class="list-group">
                    @forelse ($tags as $tag)
                        {{-- Ссылка на curated.tag --}}
                        <a href="{{ route('curated.tag', $tag->slug) }}" class="list-group-item list-group-item-action bg-dark text-white border-secondary mb-1 rounded">
                            {{ $tag->name }}
                        </a>
                    @empty
                        <p class="text-secondary">Теги пока не определены.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection
