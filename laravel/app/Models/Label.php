<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Label extends Model
{
    protected $fillable = ['name', 'slug'];

    // Получить все альбомы, выпущенные этим лейблом.
    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }
}