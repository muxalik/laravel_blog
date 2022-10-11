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
        if (Cache::has('posts_all')) {
            $posts = Cache::get('posts_all');
        } else {
            $posts = Post::with('category', 'tags')->get();
            Cache::put('posts_all', $posts, env('CACHE_TIME_FOR_ADMIN'));
        }

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Cache::has('categories_pluck')) {
            $categories = Cache::get('categories_pluck');
        } else {
            $categories = Category::pluck('title', 'id')->all();
            Cache::put('categories_pluck', $categories, env('CACHE_TIME_FOR_ADMIN'));
        }

        if (Cache::has('tags_pluck')) {
            $tags = Cache::get('tags_pluck');
        } else {
            $tags = Tag::pluck('title', 'id')->all();
            Cache::put('tags_pluck', $tags, env('CACHE_TIME_FOR_ADMIN'));
        }

        return view('admin.posts.create', compact('categories', 'tags'));
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

        return redirect()->route('posts.index')->with('success', 'Статья успешно добавлена');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        if (Cache::has('categories_pluck')) {
            $categories = Cache::get('categories_pluck');
        } else {
            $categories = Category::pluck('title', 'id')->all();
            Cache::put('categories_pluck', $categories, env('CACHE_TIME_FOR_ADMIN'));
        }

        if (Cache::has('tags_pluck')) {
            $tags = Tag::pluck('title', 'id')->all();
            Cache::put('tags_pluck', $tags, env('CACHE_TIME_FOR_ADMIN'));
        }

        return view('admin.posts.edit', compact('categories', 'tags', 'post'));
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

        $post = Post::find($id);
        $data = $request->all();
        if ($file = Post::uploadImage($request, $post->thumbnail)) {
            $data['thumbnail'] = $file;
        }
        $post->update($data);
        $post->tags()->sync($request->tags);

        return redirect()->route('posts.index')->with('success', 'Изменения успешно сохранены');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id === 'all') {
            Post::truncate();
            DB::table('post_tag')->truncate();
            return redirect()->route('posts.index')->with('success', 'Все статьи успешно удалены');
        }

        $post = Post::find($id);
        $post->tags()->sync([]);

        if ($post->thumbnail)
            Storage::delete($post->thumbnail);

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Статья успешно удалена');
    }
}
