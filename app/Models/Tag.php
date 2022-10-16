<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
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

    public static function getById(int $id): Tag
    {
        return static::find($id);
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
}
