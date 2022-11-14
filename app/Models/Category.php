<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function getById($id)
    {
        return Category::find($id);
    }

    public static function getBySlug($slug)
    {
        return Category::where('slug', $slug)
            ->first();
    }

    public function getPostsAmount()
    {
        return $this->posts->count();
    }

    public static function getAllCached()
    {
        return Cache::remember('categories_all', env('CACHE_TIME'), function () {
            return Category::all();
        });
    }

    public static function getAllTitleIdCached()
    {
        return Cache::remember('categories_pluck', env('CACHE_TIME'), function () {
            return Category::pluck('title', 'id')
                ->all();
        });
    }

    public static function clearCache()
    {
        Cache::forget('categories_all');
    }

    public static function getList()
    {
        return Cache::remember('categories_list', env('CACHE_TIME'), function () {
            return Category::withCount('posts')
                ->orderBy('posts_count', 'desc')
                ->get();
        });
    }

    public static function getPopular()
    {
        return Cache::remember('popular_categories', env('CACHE_TIME'), function () {
            return collect(Category::withCount('posts')
                ->orderBy('posts_count', 'desc')
                ->limit(6)
                ->get());
        });
    }
}
