@extends('layouts.main')

@section('title', 'Сообщество: Темы Обсуждений')

@section('content')

    <div class="forum-header">
        <h1 class="page-title">⚔️ Темы Обсуждений (Сообщество)</h1>
        <a href="{{ route('forum.create') }}" class="button-create">
            + Создать новую тему
        </a>
    </div>

    @if ($topics->isEmpty())
        <p class="text-secondary">Здесь пока тихо... Будьте первым, кто начнет обсуждение!</p>
    @else
        <table class="topic-table">
            <thead>
            <tr>
                <th style="width: 50%;">Тема</th>
                <th style="width: 15%; text-align: center;">Ответов</th>
                <th style="width: 25%;">Последняя активность</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($topics as $topic)
                <tr>
                    <td class="topic-title-cell">
                        <a href="{{ route('forum.show', $topic->slug) }}" class="topic-link">
                            {{ $topic->title }}
                        </a>
                        <div class="topic-meta">
                            Создано: {{ $topic->user->name ?? 'Гость' }} |
                            {{ $topic->created_at->diffForHumans() }}
                        </div>
                    </td>
                    <td class="topic-stats">{{ $topic->posts_count }}</td>
                    <td class="topic-last-post">
                        @if ($topic->lastPost)
                            <a href="{{ route('forum.show', $topic->slug) }}#post-{{ $topic->lastPost->id }}">
                                {{ $topic->lastPost->created_at->diffForHumans() }}
                            </a>
                            <div class="topic-meta">
                                {{ $topic->lastPost->user->name ?? 'Гость' }}
                            </div>
                        @else
                            <span class="topic-meta">Нет ответов</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="pagination-links" style="margin-top: 20px;">
            {{ $topics->links() }}
        </div>
    @endif
@endsection

<style>
    /* Дополнительные стили для forum/index.blade.php */
    .forum-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .button-create {
        background: var(--color-accent-blood);
        color: white;
        padding: 10px 15px;
        text-transform: uppercase;
        font-size: 0.9em;
        border-radius: 2px;
    }
    .button-create:hover {
        background: #c00000;
    }
    .topic-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .topic-table th, .topic-table td {
        padding: 12px;
        border-bottom: 1px solid #222;
        text-align: left;
    }
    .topic-table th {
        background: #111;
        text-transform: uppercase;
        font-size: 0.8em;
        color: var(--color-text-secondary);
    }
    .topic-stats {
        text-align: center;
        font-weight: bold;
        color: var(--color-accent-blood);
    }
    .topic-title-cell {
        font-size: 1.1em;
    }
    .topic-link {
        font-weight: bold;
    }
    .topic-meta {
        font-size: 0.8em;
        color: var(--color-text-secondary);
        margin-top: 4px;
    }
    .topic-last-post {
        font-size: 0.9em;
    }
</style>
