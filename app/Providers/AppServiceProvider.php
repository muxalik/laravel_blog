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

        view()->composer('admin.index', function ($view) {

            // Widgets
            $avg_views = ceil(Post::avg('views'));
            $posts = Post::count('id');

            $view->with('users_count', User::count('id'));
            $view->with('avg_views', $avg_views);
            $view->with('posts_count', $posts);

            // Rating
            $rate = Post::pluck('likes', 'dislikes')->all();
            $likes = array_sum(array_values($rate));
            $dislikes = array_sum(array_keys($rate));
            $view->with('avg_rating', ceil(($likes - $dislikes) / $posts
                ? ($likes - $dislikes) / $posts
                : 1));
            // Admin list
            $admins = User::where('is_admin', '=', 1)->get();
            $view->with('admins', $admins);

            // Statistics
            // Popular tags 
            // $tags = DB::select("SELECT COUNT(*) as amount, tags.title FROM post_tag INNER JOIN tags ON tag_id = tags.id GROUP BY tag_id LIMIT 6");
            $tags = Tag::withCount('posts')->orderBy('posts_count', 'desc')->limit(6)->get();
            $tags_labels = $tags_posts = [];

            foreach ($tags as $tag) {
                $tags_labels[] = $tag->title;
                $tags_posts[] = $tag->posts_count;
            }

            $view->with('tags_labels', json_encode($tags_labels));
            $view->with('tags_posts', json_encode($tags_posts));

            // Popular categories
            // $categories = DB::select("SELECT COUNT(*) AS amount, categories.title FROM posts INNER JOIN categories ON category_id = categories.id GROUP BY category_id LIMIT 6");
            $categories = Category::withCount('posts')->orderBy('posts_count', 'desc')->limit(6)->get();
            $categories_labels = $categories_posts = [];

            foreach ($categories as $category) {
                $categories_labels[] = $category->title;
                $categories_posts[] = $category->posts_count;
            }

            $view->with('categories_labels', json_encode($categories_labels));
            $view->with('categories_posts', json_encode($categories_posts));

            // Rating of latest posts
            $posts = $latest_posts = Post::orderBy('created_at')->limit(7)->get();
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
            $posts = Post::orderBy('views')->limit(7)->get()->sortBy('created_at');
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
