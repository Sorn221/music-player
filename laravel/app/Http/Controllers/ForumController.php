<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    /**
     * Отображает список всех тем обсуждений. (GET /community)
     */
    public function index()
    {
        $topics = Topic::with(['user', 'lastPost.user'])
            ->orderBy('updated_at', 'desc') // Сортируем по последней активности
            ->paginate(15);

        return view('forum.index', compact('topics'));
    }

    /**
     * Отображает форму создания новой темы. (GET /community/create)
     */
    public function create()
    {
        return view('forum.create');
    }

    /**
     * Сохраняет новую тему и первое сообщение. (POST /community)
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
        ]);

        // Транзакция гарантирует, что либо создадутся и тема, и пост, либо не создастся ничего
        return DB::transaction(function () use ($request) {
            $topic = Topic::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'slug' => Str::slug($request->title) . '-' . time(), // Уникальный slug
            ]);

            $post = Post::create([
                'topic_id' => $topic->id,
                'user_id' => auth()->id(),
                'content' => $request->content,
            ]);

            // Обновляем счетчик сообщений и ссылку на последнее сообщение
            $topic->posts_count = 1;
            $topic->last_post_id = $post->id;
            $topic->save();

            return redirect()->route('forum.show', $topic->slug)
                ->with('success', 'Тема успешно создана!');
        });
    }

    /**
     * Отображает конкретную тему и все сообщения в ней. (GET /community/{slug})
     */
    public function show(Topic $topic)
    {
        // Загружаем посты с авторами (пагинация, 10 сообщений на страницу)
        $posts = $topic->posts()
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('forum.show', compact('topic', 'posts'));
    }

    /**
     * Сохраняет новое сообщение в существующую тему. (POST /community/{slug}/reply)
     */
    public function storePost(Request $request, Topic $topic)
    {
        $request->validate(['content' => 'required|string|min:10']);

        $post = Post::create([
            'topic_id' => $topic->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        // Обновляем статистику темы
        $topic->increment('posts_count');
        $topic->last_post_id = $post->id;
        $topic->save(); // Обновляет updated_at, сортировка на главной обновится

        // Перенаправляем на последнюю страницу темы
        return redirect()->route('forum.show', $topic->slug)
            ->with('success', 'Сообщение добавлено.')
            ->withFragment('post-' . $post->id); // Якорь к новому сообщению
    }
}
