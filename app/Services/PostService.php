<?php

namespace App\Services;

use App\Models\Post;

class PostService 
{
    public static function getWithIncrement($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->views += 1;
        $post->update();

        return $post;
    }

    public static function getSimilar($post)
    {
        $tags = $post
            ->tags()
            ->inRandomOrder()
            ->limit(2)
            ->get()
            ->pluck('id');

        $posts = Post::whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('post_id', $tags);
        })->get();
        
        return $posts;
    }
}