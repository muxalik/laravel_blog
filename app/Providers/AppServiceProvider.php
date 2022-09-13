<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
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
            
            // Widgets
            $view->with('users_count', User::count('id'));

            $avg_views = ceil(collect(Post::pluck('views')->all())->avg());
            $view->with('avg_views', $avg_views);
            
            $posts = Post::count('id');
            $view->with('posts_count', $posts);

            // Rating
            $rate = Post::pluck('likes', 'dislikes')->all();
            $likes = array_sum(array_values($rate));
            $dislikes = array_sum(array_keys($rate));
            $view->with('avg_rating', ceil(($likes - $dislikes) / $posts 
                ? ($likes - $dislikes) / $posts 
                : 1));

            // Statistics
            // Categories of posts
            $categories = Category::pluck('title')->toArray();
            $posts_to_cats = DB::table('posts')
                ->select('category_id', DB::raw('count(*) as total'))
                ->groupBy('category_id')
                ->get()
                ->toArray();

            $posts_to_cats = array_map(function($value) {
                return $value->total;
            }, $posts_to_cats);

            $view->with('categories', json_encode($categories));
            $view->with('posts_to_cats', json_encode($posts_to_cats));

            // Rating of latest posts
            $posts = $latest_posts = Post::orderBy('created_at')->get();
            $latest_labels = $latest_likes = $latest_dislikes = $latest_views = [];

            if ($posts->count() > 7) 
                $latest_posts = $posts->slice(0, 7);
            
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
            if ($posts->count() > 7)
                $posts = Post::orderBy('views')->limit(7)->get();
            else 
                $posts = Post::orderBy('views')->get();

            $popular_labels = $popular_likes = $popular_dislikes = $popular_views = [];

            foreach ($posts as $post) {
                $popular_labels[] = $post->changePostDate();
                $popular_likes[] = $post->likes;
                $popular_dislikes[] = $post->dislikes;
                $popular_views[] = $post->views;
            }

            $view->with('popular_labels', json_encode($popular_labels));
            $view->with('popular_likes', json_encode($popular_likes));
            $view->with('popular_dislikes', json_encode($popular_dislikes));
            $view->with('popular_views', json_encode($popular_views));
        });
    }
}
