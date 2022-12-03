<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

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

    public static function getBySlug($slug)
    {
        return Category::where('slug', $slug)
            ->firstOrFail();
    }

    public function getPostsAmount()
    {
        return $this->posts()->count();
    }

    public static function getList()
    {
        return Category::withCount('posts')
            ->orderByDesc('posts_count')
            ->get();
    }

    public static function getPopular()
    {
        return Category::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(6)
            ->get();
    }
}
