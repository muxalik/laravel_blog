<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::getSortedCached()
        ]);
    }

    public function show($slug)
    {
        $post = Post::getWithIncrement($slug);
        $similar = Post::getSimilar($post);
        $comments = Comment::getByPostId($post->id);
        $amount = Comment::getAmount($post->id);

        return view('posts.show', compact('post', 'similar', 'comments', 'amount'));
    }
}
