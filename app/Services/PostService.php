<?php

namespace App\Services;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostService
{
    /**
     * store
     *
     * @param  PostRequest $request
     * @return void
     */
    public function store(PostRequest $request): void
    {
        $data = $request->all();
        $data['thumbnail'] = Post::uploadImage($request);

        $post = Post::create($data);
        $post->tags()->sync($request->tags);
    }

    /**
     * update
     *
     * @param  PostRequest $request
     * @param  Post $post
     * @return void
     */
    public function update(PostRequest $request, Post $post): void
    {
        $data = $request->all();
        $file = Post::uploadImage($request, $post->thumbnail);

        if ($file)
            $data['thumbnail'] = $file;

        $post->update($data);
        $post->tags()->sync($request->tags);
    }

    public function delete(int|string $id): RedirectResponse
    {
        if ($id === 'all')
            return static::deleteAll();

        return static::deleteOne($id);
    }

    protected static function deleteAll()
    {
        Post::truncate();
        DB::table('post_tag')->truncate();

        return redirect()
            ->route('posts.index')
            ->with([
                'success' => 'Все статьи успешно удалены',
                'clearCache' => true
            ]);
    }

    protected static function deleteOne(int $id)
    {
        $post = Post::find($id);
        $post->tags()->sync([]);

        if ($post->thumbnail)
            Storage::delete($post->thumbnail);

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with([
                'success' => 'Статья успешно удалена',
                'clearCache' => true
            ]);
    }
}
