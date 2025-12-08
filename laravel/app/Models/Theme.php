<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Theme extends Model
{
    protected $fillable = ['name', 'slug'];

    // Получить все альбомы, связанные с этой темой.
    public function albums(): BelongsToMany
    {
        return $this->belongsToMany(Album::class);
    }
}