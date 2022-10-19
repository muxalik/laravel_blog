<?php

namespace App\Http\Controllers;

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
        $post = self::get($slug);
        $similar = self::getSimilar($post);
        $comments = $post->comments;

        return view('posts.show', compact('post', 'similar', 'comments'));
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
