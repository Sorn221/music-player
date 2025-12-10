@extends('layouts.main')

@section('title', $topic->title)

@section('content')

    <h1 class="page-title">{{ $topic->title }}</h1>
    <p class="text-secondary">
        Начато {{ $topic->user->name }} | {{ $topic->created_at->format('d.m.Y H:i') }}
    </p>

    <div class="posts-container">
        @foreach ($posts as $post)
            <div id="post-{{ $post->id }}" class="post-card">
                <aside class="post-author-sidebar">
                    <p class="author-name">
                        <a href="{{ route('profile.show', $post->user->name ?? 'Guest') }}">
                            {{ $post->user->name ?? 'Гость' }}
                        </a>
                    </p>
                    <p class="post-date">{{ $post->created_at->diffForHumans() }}</p>
                </aside>
                <div class="post-content">
                    <p>{{ $post->content }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination-links" style="margin-top: 20px;">
        {{ $posts->links() }}
    </div>

    <h3 style="margin-top: 40px; border-bottom: none;">Ответить на тему</h3>
    <form method="POST" action="{{ route('forum.reply', $topic->slug) }}" class="forum-form">
        @csrf
        <div class="form-group">
            <textarea id="content" name="content" rows="6" placeholder="Ваше сообщение..." required class="@error('content') is-invalid @enderror">{{ old('content') }}</textarea>
            @error('content')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="button-submit">Отправить Сообщение</button>
    </form>

@endsection

<style>
    /* Дополнительные стили для forum/show.blade.php */
    .posts-container {
        margin-top: 30px;
    }
    .post-card {
        display: flex;
        margin-bottom: 20px;
        background: var(--color-card-bg);
        border: 1px solid #222;
    }
    .post-author-sidebar {
        flex-shrink: 0;
        width: 180px;
        padding: 15px;
        border-right: 1px solid #222;
        background: #111;
        text-align: center;
    }
    .author-name {
        font-weight: bold;
        color: var(--color-accent-blood);
        font-size: 1.1em;
        margin-bottom: 5px;
    }
    .post-date {
        font-size: 0.8em;
        color: var(--color-text-secondary);
    }
    .post-content {
        padding: 15px 20px;
        flex-grow: 1;
    }
    .post-content p {
        margin-top: 0;
    }

    /* Форма ответа */
    .forum-form {
        max-width: 100%; /* Форма ответа может быть шире */
    }
</style>
