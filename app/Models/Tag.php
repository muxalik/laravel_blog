<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

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

    public static function getBySlug($slug)
    {
        return Tag::where('slug', $slug)
            ->firstOrFail();
    }

    public static function getPopular()
    {
        return Tag::select('title')
            ->withCount('posts')
            ->orderByDesc('posts_count')
            ->limit(6)
            ->get();
    }
}
