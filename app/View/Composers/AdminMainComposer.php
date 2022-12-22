<?php 

namespace App\View\Composers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\View\View;

class AdminMainComposer
{
    protected int $posts_count;

    public function compose(View $view)
    {
        $view->with([
            'admins' => User::where('is_admin', 1)->get(),
        ] + array_merge(
            $this->getWidgets(),
            $this->getPopularTags(),
            $this->getPopularCategories(),
            $this->getPopularPosts(),
            $this->getRecentPosts(),
        ));
    }

    protected function getPostsCount(): int
    {
        return isset($this->posts_count)
            ? $this->posts_count
            : Post::count('id');
    }

    protected function getWidgets(): array
    {
        return [
            'users_count' => User::count('id'),
            'avg_views' => ceil(Post::avg('views')),
            'posts_count' => $this->getPostsCount(),
            'avg_rating' => $this->getAvgRating(),
        ];
    }

    protected function getAvgRating(): int
    {
        $posts_count = $this->getPostsCount();
        $rating = Post::getRating();

        $likes = $rating->values()->sum();
        $dislikes = $rating->keys()->sum();

        return ceil(($likes - $dislikes) / $posts_count
            ? ($likes - $dislikes) / $posts_count
            : 1);
    }

    protected function getPopularTags(): array
    {
        $tags = Tag::getPopular();
        $labels = $tags->pluck('title');
        $posts = $tags->pluck('posts_count');

        return [
            'tags_labels' => $labels->toJson(),
            'tags_posts' => $posts->toJson(),
        ];
    }

    protected function getPopularCategories(): array
    {
        $categories = Category::getPopular();
        $labels = $categories->pluck('title');
        $posts = $categories->pluck('posts_count');

        return [
            'categories_labels' => $labels->toJson(),
            'categories_posts' => $posts->toJson(),
        ];
    }

    protected function getRecentPosts(): array
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

    protected function getPopularPosts(): array
    {
        $posts = Post::getPopularStats();
        $labels = $posts->map(fn ($post) => $post->changePostDate())->values();
        $likes = $posts->pluck('likes');
        $dislikes = $posts->pluck('dislikes');

        return [
            'popular_labels' => $labels->toJson(),
            'popular_likes' => $likes->toJson(),
            'popular_dislikes' => $dislikes->toJson(),
        ];
    }

} 