<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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

    public function show($slug)
    {
        $post = PostService::getWithIncrement($slug);
        $similar = PostService::getSimilar($post);
        $comments = Comment::getByPostId($post->id);
        $amount = $post->comments()->count();

        return view('posts.show', compact('post', 'similar', 'comments', 'amount'));
    }
}
