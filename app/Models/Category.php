<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
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
        return Category::find($id)
            ->firstOrFail();
    }

    public static function getBySlug($slug): Category
    {
        return Category::where('slug', $slug)
            ->firstOrFail();
    }

    public static function getPostsByCategory(Category $category)
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
        return Cache::remember('categories_all', env('CACHE_TIME'), function () {
            return Category::all();
        });
    }

    public static function updateById(Request $request, $id)
    {
        Category::findById($id)
            ->update($request->all());
    }

    public static function getAllTitleIdCached()
    {
        return Cache::remember('categories_pluck', env('CACHE_TIME'), function () {
            return Category::pluck('title', 'id')->all();
        });
    }
}
