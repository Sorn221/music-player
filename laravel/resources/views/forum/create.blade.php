@extends('layouts.main')

@section('title', 'Новая Тема')

@section('content')

    <h1 class="page-title">🕯️ Создать Новую Тему</h1>
    <p class="text-secondary">Начните обсуждение. Не забывайте о мрачных манерах.</p>

    <form method="POST" action="{{ route('forum.store') }}" class="forum-form">
        @csrf

        <div class="form-group">
            <label for="title">Название Темы (Subject):</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required class="@error('title') is-invalid @enderror">
            @error('title')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Текст Первого Сообщения:</label>
            <textarea id="content" name="content" rows="10" required class="@error('content') is-invalid @enderror">{{ old('content') }}</textarea>
            @error('content')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="button-submit">
            Опубликовать Ритуал
        </button>
    </form>

@endsection

<style>
    /* Стили для форм */
    .forum-form {
        max-width: 800px;
        margin-top: 30px;
        background: var(--color-card-bg);
        padding: 30px;
        border: 1px solid #222;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .forum-form label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: var(--color-text-primary);
    }
    .forum-form input[type="text"],
    .forum-form textarea {
        width: 100%;
        padding: 10px;
        background: #111;
        border: 1px solid #444;
        color: var(--color-text-primary);
        font-size: 1em;
        box-sizing: border-box;
    }
    .forum-form input:focus, .forum-form textarea:focus {
        border-color: var(--color-accent-blood);
        outline: none;
    }
    .error-message {
        color: var(--color-accent-blood);
        font-size: 0.9em;
        margin-top: 5px;
    }
    .is-invalid {
        border-color: var(--color-accent-blood) !important;
    }
    .button-submit {
        background: var(--color-accent-blood);
        color: white;
        padding: 12px 20px;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        font-weight: bold;
        transition: background 0.2s;
    }
    .button-submit:hover {
        background: #c00000;
    }
</style>
