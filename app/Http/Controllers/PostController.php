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
        $post = static::get($slug);
        $similar = static::getSimilar($post);

        $comments = Comment::getByPostId($post->id);
        $amount = Comment::getAmount($post->id);

        return view('posts.show', compact('post', 'similar', 'comments', 'amount'));
    }

    protected static function get($slug)
    {
        $post = Post::getBySlug($slug);
        $post->views += 1;
        $post->update();

        return $post;
    }

    protected static function getSimilar($post)
    {
        $array = $post
            ->tags
            ->random(2);

        $first = $array[0]
            ->posts
            ->random(1)[0];

        $key = $first->id;

        $second = $array[1]
            ->posts
            ->except($key)
            ->random(1)[0];

        return [$first, $second];
    }
}
