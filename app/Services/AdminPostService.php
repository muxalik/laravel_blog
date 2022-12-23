<?php

namespace App\Services;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminPostService
{
    /**
     * store
     *
     * @param  PostRequest $request
     * @return void
     */
    public function store(PostRequest $request): void
    {
        $thumbnail = Post::uploadImage($request->file('thumbnail'));
        $post = Post::create(array_merge(
            $request->all(),
            ['thumbnail' => $thumbnail]
        ));
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
        $thumbnail = $request->file('thumbnail') 
            ? Post::uploadImage($request->file('thumbnail'), $post->thumbnail)
            : $post->thumbnail;

        $post->update(array_merge(
            $request->validated(),
            ['thumbnail' => $thumbnail],
        ));

        $post->tags()->sync($request->tags);
    }
    
    /**
     * delete
     *
     * @param  int|string $id
     * @return RedirectResponse
     */
    public function delete(int|string $id): RedirectResponse
    {
        if ($id === 'all')
            return static::deleteAll();

        return static::deleteOne($id);
    }
    
    /**
     * deleteAll
     *
     * @return void
     */
    protected static function deleteAll()
    {
        Post::truncate();
        DB::table('post_tag')->truncate();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Все статьи успешно удалены');
    }
    
    /**
     * deleteOne
     *
     * @param  int $id
     * @return RedirectResponse
     */
    protected static function deleteOne(int $id): RedirectResponse
    {
        $post = Post::find($id);
        $post->tags()->sync([]);

        if ($post->thumbnail)
            Storage::delete($post->thumbnail);

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Статья успешно удалена');
    }
}
