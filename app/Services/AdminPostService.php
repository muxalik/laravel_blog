<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminPostService
{
    /**
     * store
     *
     * @param  object $data
     * @param  mixed $image
     * @return void
     */
    public function store(object $data, $image): void
    {
        $data['thumbnail'] = Post::uploadImage($image);
        $post = Post::create($data);
        $post->tags()->sync($data->tags);
    }
    
    /**
     * update
     *
     * @param  Post $post
     * @param  mixed $data
     * @return void
     */
    public function update(Post $post, $data): void
    {
        $file = Post::uploadImage($data->thumbnail, $post->thumbnail);

        if ($file)
            $data['thumbnail'] = $file;

        $post->update($data);
        $post->tags()->sync($data->tags);
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
            ->with([
                'success' => 'Все статьи успешно удалены',
                'clearCache' => true
            ]);
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
            ->with([
                'success' => 'Статья успешно удалена',
                'clearCache' => true
            ]);
    }
}
