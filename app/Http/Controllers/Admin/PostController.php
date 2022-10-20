<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session('clearCache'))
            Post::clearCache();

        return view('admin.posts.index', [
            'posts' => Post::getAllCached()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create', [
            'categories' => Category::getAllTitleIdCached(),
            'tags' => Tag::getAllTitleIdCached()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image'
        ]);

        $data = $request->all();
        $data['thumbnail'] = Post::uploadImage($request);

        $post = Post::create($data);
        $post->tags()->sync($request->tags);

        return redirect()
            ->route('posts.index')
            ->with([
                'success' => 'Статья успешно добавлена',
                'clearCache' => true
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.posts.edit', [
            'categories' => Category::getAllTitleIdCached(),
            'tags' => Tag::getAllTitleIdCached(),
            'post' => Post::getById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|integer',
            'thumbnail' => 'nullable|image'
        ]);

        $post = Post::findById($id);
        $data = $request->all();

        if ($file = Post::uploadImage($request, $post->thumbnail)) {
            $data['thumbnail'] = $file;
        }

        $post->update($data);
        $post->tags()->sync($request->tags);

        return redirect()
            ->route('posts.index')
            ->with([
                'success' => 'Изменения успешно сохранены',
                'clearCache' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id === 'all')
            static::deleteAll();

        if (is_numeric($id))
            static::deleteOne($id);

        abort(404);
    }

    protected function deleteAll()
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

    protected function deleteOne(int $id)
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
