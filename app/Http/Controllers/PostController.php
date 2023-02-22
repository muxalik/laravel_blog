<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::getSorted()
        ]);
    }

    public function show(Post $post)
    {
        $similar = PostService::getSimilar($post);
        $comments = $post->comments()->oldest()->limit(4)->get();
        $amount = $post->comments->count();

        return view('posts.show', compact('post', 'similar', 'comments', 'amount'));
    }
}
