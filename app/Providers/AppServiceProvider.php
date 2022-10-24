<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

use function GuzzleHttp\json_encode;

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
        $rate = Post::getRating();

        $likes = array_sum(array_values($rate));
        $dislikes = array_sum(array_keys($rate));
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
        $labels = $posts = [];

        foreach ($tags as $tag) {
            $labels[] = $tag->title;
            $posts[] = $tag->posts_count;
        }

        $view->with([
            'tags_labels' => json_encode($labels),
            'tags_posts' => json_encode($posts),
        ]);
    }

    public function passPopularCategories($view)
    {
        $categories = Category::getPopular();
        $labels = $posts = [];

        foreach ($categories as $category) {
            $labels[] = $category->title;
            $posts[] = $category->posts_count;
        }

        $view->with([
            'categories_labels' => json_encode($labels),
            'categories_posts' => json_encode($posts),
        ]);
    }

    public function passRecentPosts($view)
    {
        $posts = Post::getRecentStats();
        $labels = $likes = $dislikes = $views = [];

        foreach ($posts as $post) {
            $labels[] = $post->changePostDate();
            $likes[] = $post->likes;
            $dislikes[] = $post->dislikes;
            $views[] = $post->views;
        }

        $view->with([
            'latest_labels' => json_encode($labels),
            'latest_likes' => json_encode($likes),
            'latest_dislikes' => json_encode($dislikes),
            'latest_views' => json_encode($views),
        ]);
    }

    public function passPopularPosts($view)
    {
        $posts = Post::getPopularStats();
        $labels = $likes = $dislikes = [];

        foreach ($posts as $post) {
            $labels[] = $post->changePostDate();
            $likes[] = $post->likes;
            $dislikes[] = $post->dislikes;
        }

        $view->with([
            'popular_labels' => json_encode($labels),
            'popular_likes' => json_encode($likes),
            'popular_dislikes' => json_encode($dislikes),
        ]);
    }
}
