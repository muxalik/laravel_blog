<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Collection;
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

    public static function getBySlug($slug): Category
    {
        return static::where('slug', $slug)
            ->firstOrFail();
    }

    public static function getPosts(Category $category)
    {
        return $category
            ->posts()
            ->orderBy('id', 'desc')
            ->paginate(3);
    }

    public function getPostsAmount()
    {
        return $this->posts->count();
    }

    public static function getAllCached()
    {
        return Cache::remember('categories_all', env('CACHE_TIME_FOR_ADMIN_DATA'), function () {
            return static::all();
        });
    }

    public static function clearCache(): bool
    {
        return Cache::forget('categories_all');
    }
}
