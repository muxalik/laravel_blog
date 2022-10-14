<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Cache::remember('sorted_posts', env('CACHE_TIME_FOR_USER_DATA'), function () {
            return Post::with('category')
                ->orderBy('id', 'desc')
                ->paginate(3)
                ->fragment('main-section');
        });

        return view('posts.index', compact('posts'));
    }

    public function show($slug)
    {
        // Get necessary post
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->views += 1;
        $post->update();

        // Get similar posts
        $array = $post->tags->random(2);
        $first = $array[0]->posts->random(1)[0];
        $key = $first->id;
        $second = $array[1]->posts->except($key)->random(1)[0];
        $similar = [$first, $second];

        // Get comments
        $comments = $post->comments;

        return view('posts.show', compact('post', 'similar', 'comments'));
    }
}
