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
        return static::find($id)
            ->firstOrFail();
    }

    public function getPostsAmount()
    {
        return $this->posts->count();
    }

    public static function getAllCached()
    {
        return Cache::remember('tags_all', env('CACHE_TIME_FOR_ADMIN_DATA'), function () {
            return static::all();
        });
    }

    public static function clearCache(): bool
    {
        return Cache::forget('tags_all');
    }

    public static function updateOne(Request $request, $id)
    {
        static::findById($id)
            ->update($request->all());
    }
}
