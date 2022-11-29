<?php

namespace App\Services;

use App\Models\Post;

class PostService 
{
    public function getWithIncrement($slug)
    {
        $post = Post::getBySlug($slug);
        $post->views += 1;
        $post->update();

        return $post;
    }

    public static function getSimilar($post)
    {
        $tags = $post
            ->tags
            ->random(2);

        $first = $tags[0]
            ->posts
            ->random(1)[0];

        $key = $first->id;

        $second = $tags[1]
            ->posts
            ->except($key)
            ->random(1)[0];

        return [$first, $second];
    }
}