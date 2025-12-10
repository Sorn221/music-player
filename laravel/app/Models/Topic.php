<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'posts_count',
        'last_post_id'
    ];
    // Получить пользователя, создавшего тему
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Получить все сообщения в этой теме
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // Получить последнее сообщение (для удобной сортировки)
    public function lastPost(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'last_post_id');
    }
}
