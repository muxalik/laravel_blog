<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
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
            $view->with('categories', Category::getAllCached());
        });

        view()->composer('layouts.sidebar', function ($view) {
            $view->with('popular_posts', Post::getPopular());
            $view->with('cats', Category::getList());
        });

        view()->composer('layouts.footer', function ($view) {
            $view->with('recent_posts', Post::getRecent());
            $view->with('popular_posts', Post::getPopular());
            $view->with('cats', Category::getList());
        });

        view()->composer('admin.index', function ($view) {

            // Widgets
            $posts = Post::count('id');

            $view->with('users_count', User::count('id'));
            $view->with('avg_views', ceil(Post::avg('views')));
            $view->with('posts_count', $posts);

            // Rating
            $rate = Post::getRating();
            $likes = array_sum(array_values($rate));
            $dislikes = array_sum(array_keys($rate));
            $avg_rating = ceil(($likes - $dislikes) / $posts
            ? ($likes - $dislikes) / $posts
            : 1);

            $view->with('avg_rating', $avg_rating);

            $view->with('admins', User::getAdmins());

            // Statistics
            // Popular tags
            $tags = Tag::getPopular();
            $tags_labels = $tags_posts = [];

            foreach ($tags as $tag) {
                $tags_labels[] = $tag->title;
                $tags_posts[] = $tag->posts_count;
            }

            $view->with('tags_labels', json_encode($tags_labels));
            $view->with('tags_posts', json_encode($tags_posts));

            // Popular categories
            $categories = Category::getPopular();
            $categories_labels = $categories_posts = [];

            foreach ($categories as $category) {
                $categories_labels[] = $category->title;
                $categories_posts[] = $category->posts_count;
            }

            $view->with('categories_labels', json_encode($categories_labels));
            $view->with('categories_posts', json_encode($categories_posts));

            // Rating of latest posts
            $posts = $latest_posts = Post::getRecentStats();
            $latest_labels = $latest_likes = $latest_dislikes = $latest_views = [];

            foreach ($latest_posts as $post) {
                $latest_labels[] = $post->changePostDate();
                $latest_likes[] = $post->likes;
                $latest_dislikes[] = $post->dislikes;
                $latest_views[] = $post->views;
            }

            $view->with('latest_labels', json_encode($latest_labels));
            $view->with('latest_likes', json_encode($latest_likes));
            $view->with('latest_dislikes', json_encode($latest_dislikes));
            $view->with('latest_views', json_encode($latest_views));

            // Rating of popular posts
            $posts = Post::getPopularStats();
            $popular_labels = $popular_likes = $popular_dislikes = [];

            foreach ($posts as $post) {
                $popular_labels[] = $post->changePostDate();
                $popular_likes[] = $post->likes;
                $popular_dislikes[] = $post->dislikes;
            }

            $view->with('popular_labels', json_encode($popular_labels));
            $view->with('popular_likes', json_encode($popular_likes));
            $view->with('popular_dislikes', json_encode($popular_dislikes));
        });
    }
}
