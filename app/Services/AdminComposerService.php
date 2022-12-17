<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

class AdminComposerService
{
    protected int $posts_count;

    protected function getPostsCount(): int
    {
        return isset($this->posts_count)
            ? $this->posts_count
            : Post::count('id');
    }

    public function getWidgets(): array
    {
        return [
            'users_count' => User::count('id'),
            'avg_views' => ceil(Post::avg('views')),
            'posts_count' => $this->getPostsCount(),
            'avg_rating' => AdminComposerService::getAvgRating(),
        ];
    }

    public function getAvgRating(): int
    {
        $posts_count = $this->getPostsCount();
        $rating = Post::getRating();

        $likes = $rating->values()->sum();
        $dislikes = $rating->keys()->sum();

        return ceil(($likes - $dislikes) / $posts_count
            ? ($likes - $dislikes) / $posts_count
            : 1);
    }

    public function getPopularTags(): array
    {
        $tags = Tag::getPopular();
        $labels = $tags->pluck('title');
        $posts = $tags->pluck('posts_count');

        return [
            'tags_labels' => $labels->toJson(),
            'tags_posts' => $posts->toJson(),
        ];
    }

    public function getPopularCategories(): array
    {
        $categories = Category::getPopular();
        $labels = $categories->pluck('title');
        $posts = $categories->pluck('posts_count');

        return [
            'categories_labels' => $labels->toJson(),
            'categories_posts' => $posts->toJson(),
        ];
    }

    public function getRecentPosts(): array
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

    public function getPopularPosts(): array
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
