<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Album extends Model
{
    protected $fillable = ['title', 'slug', 'artist_id', 'label_id', 'release_year', 'cover_image_path', 'description', 'is_demo'];

    // Получить артиста, которому принадлежит альбом.
    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    // Получить лейбл.
    public function label(): BelongsTo
    {
        return $this->belongsTo(Label::class);
    }

    // Получить треки альбома.
    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    // --- Связи для Кураторства и Тегирования ---

    // Получить концепции/темы (Лирика: Сатанизм, Космос).
    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(Theme::class);
    }

    // Получить теги атмосферы (Звук: Lo-Fi, Chaotic).
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    // --- Уникальный Query Scope для Рекомендаций "Схожая Атмосфера" ---

    /**
     * Поиск альбомов с похожей атмосферой (на основе совпадающих тегов).
     * @param Builder $query
     * @param array $tagIds ID тегов, по которым ведется поиск.
     * @param int $minMatches Минимальное количество совпадающих тегов.
     * @return Builder
     */
    public function scopeWithSimilarAtmosphere(Builder $query, array $tagIds, int $minMatches = 3): Builder
    {
        // Используем $this->id для исключения текущего альбома при использовании scope в контроллере
        $currentAlbumId = $this->id ?? null;

        return $query->when($currentAlbumId, function ($q) use ($currentAlbumId) {
                return $q->where('albums.id', '!=', $currentAlbumId);
            })
            // Присоединяем таблицу album_tag
            ->join('album_tag as at', 'albums.id', '=', 'at.album_id')
            // Фильтруем по ID тегов, которые нам нравятся
            ->whereIn('at.tag_id', $tagIds)
            // Группируем по альбому
            ->groupBy('albums.id', 'albums.title')
            // Считаем, сколько тегов совпало
            ->havingRaw('COUNT(at.tag_id) >= ?', [$minMatches])
            // Сортируем по количеству совпавших тегов
            ->orderByRaw('COUNT(at.tag_id) DESC')
            ->select('albums.*'); // Выбираем только столбцы альбома
    }
}