<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Artist extends Model
{
    protected $fillable = ['name', 'slug', 'country_id', 'bio', 'formed_year', 'is_underground'];

    // Получить все альбомы артиста.
    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    // Получить страну происхождения артиста.
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    // --- Древо Эволюции (Самостоятельные связи многие-ко-многим) ---

    // Артисты, которые повлияли на текущего (INFLUENCERS)
    public function influencers(): BelongsToMany
    {
        return $this->belongsToMany(
            Artist::class,
            'artist_influence', // Имя связующей таблицы
            'influenced_id',    // Столбец в pivot-таблице, ссылающийся на ТЕКУЩУЮ модель
            'influencer_id'     // Столбец в pivot-таблице, ссылающийся на СВЯЗАННУЮ модель
        );
    }

    // Артисты, на которых повлиял текущий (INFLUENCED)
    public function influenced(): BelongsToMany
    {
        return $this->belongsToMany(
            Artist::class,
            'artist_influence',
            'influencer_id',    // Столбец в pivot-таблице, ссылающийся на ТЕКУЩУЮ модель
            'influenced_id'     // Столбец в pivot-таблице, ссылающийся на СВЯЗАННУЮ модель
        );
    }
}