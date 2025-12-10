<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = ['topic_id', 'user_id', 'content'];

    // Получить тему, к которой относится сообщение
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    // Получить автора сообщения
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
