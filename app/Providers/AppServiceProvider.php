<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->composer('layouts.header', function ($view) {
            $view->with([
                'categories' => Category::getAllCached()
            ]);
        });

        view()->composer('layouts.sidebar', function ($view) {
            $view->with([
                'popular_posts' => Post::getPopular(),
                'cats' => Category::getList()
            ]);
        });

        view()->composer('layouts.footer', function ($view) {
            $view->with([
                'recent_posts' => Post::getRecent(),
                'popular_posts' => Post::getPopular(),
                'cats' => Category::getList()
            ]);
        });

        view()->composer('admin.index', function ($view) {
            $this->passWidgets($view);
            $this->passAdminList($view);
            $this->passPopularTags($view);
            $this->passPopularCategories($view);
            $this->passRecentPosts($view);
            $this->passPopularPosts($view);
        });
    }

    public function passWidgets($view)
    {
        $view->with([
            'users_count' => User::getAmount(),
            'avg_views' => Post::getAvgViews(),
            'posts_count' => Post::getAmount(),
            'avg_rating' => $this->getAvgRating(),
        ]);
    }

    public function getAvgRating()
    {
        $posts_count = Post::getAmount();
        $rating = Post::getRating();

        $likes = $rating->values()->sum();
        $dislikes = $rating->keys()->sum();

        $avg_rating = ceil(($likes - $dislikes) / $posts_count
            ? ($likes - $dislikes) / $posts_count
            : 1);

        return $avg_rating;
    }

    public function passAdminList($view)
    {
        $view->with('admins', User::getAdmins());
    }

    public function passPopularTags($view)
    {
        $tags = Tag::getPopular();
        $labels = collect();
        $posts = collect();

        $tags->each(function ($tag) use ($labels, $posts) {
            $labels[] = $tag->title;
            $posts[] = $tag->posts_count;
        });

        $view->with([
            'tags_labels' => $labels->toJson(),
            'tags_posts' => $posts->toJson(),
        ]);
    }

    public function passPopularCategories($view)
    {
        $categories = Category::getPopular();
        $labels = collect();
        $posts = collect();

        $categories->each(function ($category) use ($labels, $posts) {
            $labels->push($category->title);
            $posts->push($category->posts_count);
        });

        $view->with([
            'categories_labels' => $labels->toJson(),
            'categories_posts' => $posts->toJson(),
        ]);
    }

    public function passRecentPosts($view)
    {
        $posts = Post::getRecentStats();
        $labels = collect();
        $likes = collect();
        $dislikes = collect();
        $views = collect();

        $posts->each(function ($post) use ($labels, $likes, $dislikes, $views) {
            $labels->push($post->changePostDate());
            $likes->push($post->likes);
            $dislikes->push($post->dislikes);
            $views->push($post->views);
        });

        $view->with([
            'latest_labels' => $labels->toJson(),
            'latest_likes' => $likes->toJson(),
            'latest_dislikes' => $dislikes->toJson(),
            'latest_views' => $views->toJson(),
        ]);
    }

    public function passPopularPosts($view)
    {
        $posts = Post::getPopularStats();
        $labels = collect(); 
        $likes = collect(); 
        $dislikes = collect();

        $posts->each(function ($post) use ($labels, $likes, $dislikes) {
            $labels->push($post->changePostDate());
            $likes->push($post->likes);
            $dislikes->push($post->dislikes);
        });

        $view->with([
            'popular_labels' => $labels->toJson(),
            'popular_likes' => $likes->toJson(),
            'popular_dislikes' => $dislikes->toJson(),
        ]);
    }
}
