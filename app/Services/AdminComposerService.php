<?php 

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class AdminComposerService 
{   
    public static function getWidgets()
    {
        return [
            'users_count' => User::count('id'),
            'avg_views' => ceil(Post::avg('views')),
            'posts_count' => Post::count('id'),
            'avg_rating' => AdminComposerService::getAvgRating(),
        ];
    }

    public static function getAvgRating()
    {
        $posts_count = Post::count('id');
        $rating = Post::getRating();

        $likes = $rating->values()->sum();
        $dislikes = $rating->keys()->sum();

        return ceil(($likes - $dislikes) / $posts_count
            ? ($likes - $dislikes) / $posts_count
            : 1);
    }

    public static function getPopularTags()
    {
        $tags = Tag::getPopular();
        $labels = $tags->pluck('title');
        $posts = $tags->pluck('posts_count');

        return [
            'tags_labels' => $labels->toJson(),
            'tags_posts' => $posts->toJson(),
        ];
    }

    public static function getPopularCategories()
    {
        $categories = Category::getPopular();
        $labels = $categories->pluck('title');
        $posts = $categories->pluck('posts_count');
        
        return [
            'categories_labels' => $labels->toJson(),
            'categories_posts' => $posts->toJson(),
        ];
    }

    public static function getRecentPosts()
    {
        $posts = Post::getRecentStats();
        $labels = $posts->map(fn ($post) => $post->changePostDate());
        $likes = $posts->pluck('likes');
        $dislikes = $posts->pluck('dislikes');
        $views = $posts->pluck('views');

        return [
            'latest_labels' => $labels->toJson(),
            'latest_likes' => $likes->toJson(),
            'latest_dislikes' => $dislikes->toJson(),
            'latest_views' => $views->toJson(),
        ];
    }

    public static function getPopularPosts()
    {
        $posts = Post::getPopularStats();
        $labels = $posts->map(fn ($post) => $post->changePostDate());
        $likes = $posts->pluck('likes');
        $dislikes = $posts->pluck('dislikes');

        return [
            'popular_labels' => $labels->toJson(),
            'popular_likes' => $likes->toJson(),
            'popular_dislikes' => $dislikes->toJson(),
        ];
    }
}