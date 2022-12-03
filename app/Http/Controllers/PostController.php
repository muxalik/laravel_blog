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
        $service = new PostService;
        $post = $service->getWithIncrement($slug);
        $similar = $service->getSimilar($post);
        $comments = Comment::getByPostId($post->id);
        $amount = Comment::getAmount($post->id);

        return view('posts.show', compact('post', 'similar', 'comments', 'amount'));
    }
}
