<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\View\Composers\AdminMainComposer;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.header', function ($view) {
            $view->with([
                'categories' => Category::all()
            ]);
        });

        view()->composer(['layouts.layout', 'layouts.category_layout', 'user.contact'], function ($view) {
            $view->with([
                'popular_posts' => Post::getPopular(),
                'categories' => Category::getList()
            ]);
        });

        view()->composer('layouts.footer', function ($view) {
            $view->with([
                'recent_posts' => Post::getRecent(),
            ]);
        });

        view()->composer('admin.index', AdminMainComposer::class);
    }
}
