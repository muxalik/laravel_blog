<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
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

        view()->composer('layouts.sidebar', function ($view) {
            if (Cache::has('cats')) {
                $cats = Cache::get('cats');
            } else {
                $cats = Category::withCount('posts')->orderBy('posts_count', 'desc')->get();
                Cache::put('cats', $cats, 30);
            }

            $view->with('popular_posts', Post::orderBy('views', 'desc')->limit(3)->get());
            $view->with('cats', $cats);
        });

        view()->composer('layouts.footer', function ($view) {
            if (Cache::has('cats')) {
                $cats = Cache::get('cats');
            } else {
                $cats = Category::withCount('posts')->orderBy('posts_count', 'desc')->get();
                Cache::put('cats', $cats, 30);
            }
            
            $view->with('recent_posts', Post::orderBy('id', 'desc')->limit(3)->get());
            $view->with('popular_posts', Post::orderBy('views', 'desc')->limit(3)->get());
            $view->with('cats', $cats);
        });

        view()->composer('admin.index', function($view) {
            $view->with('users_count', User::count('id'));
            $view->with('avg_views', ceil(collect(Post::pluck('views')->all())->avg()));
            
            $posts = Post::count('id');
            $view->with('posts_count', $posts);

            $rate = Post::pluck('likes', 'dislikes')->all();
            $likes = array_sum(array_values($rate));
            $dislikes = array_sum(array_keys($rate));
            $view->with('avg_rating', ceil(($likes - $dislikes) / $posts 
                ? ($likes - $dislikes) / $posts 
                : 1));
        });
    }
}
