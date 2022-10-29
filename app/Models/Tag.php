<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Tag extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
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
        return Tag::find($id);
    }

    public static function getBySlug($slug)
    {
        return Tag::where('slug', $slug)
            ->firstOrFail();
    }

    public function getPostsAmount()
    {
        return $this->posts->count();
    }

    public static function getAllCached()
    {
        return Cache::remember('tags_all', env('CACHE_TIME'), function () {
            return Tag::all();
        });
    }

    public static function getAllTitleIdCached()
    {
        return Cache::remember('tags_pluck', env('CACHE_TIME'), function () {
            return Tag::pluck('title', 'id')->all();
        });
    }

    public static function clearCache(): bool
    {
        return Cache::forget('tags_all');
    }

    public static function updateById(Request $request, $id)
    {
        Tag::getById($id)
            ->update($request->all());
    }

    public static function getPopular()
    {
        return Cache::remember('popular_tags', env('CACHE_TIME'), function () {
            return collect(Tag::withCount('posts')
                ->orderBy('posts_count', 'desc')
                ->limit(6)
                ->get());
        });
    }
}
