<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    // Получить все альбомы, связанные с этим тегом.
    public function albums(): BelongsToMany
    {
        return $this->belongsToMany(Album::class);
    }
}