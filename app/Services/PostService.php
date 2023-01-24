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
        $tagIds = $post
            ->tags()
            ->inRandomOrder()
            ->get()
            ->pluck('id');

        $posts = Post::whereHas('tags', function ($query) use ($tagIds, $post) {
            $query->whereIn('post_tag.tag_id', $tagIds)
                ->where('post_id', '!=', $post->id);
        })->limit(2)->get();

        return $posts;
    }
}
