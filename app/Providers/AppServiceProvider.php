<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
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
    }
}
