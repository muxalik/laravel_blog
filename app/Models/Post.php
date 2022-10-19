<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'description',
        'content',
        'category_id',
        'thumbnail',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function uploadImage(Request $request, $image = null)
    {
        if ($request->hasFile('thumbnail')) {
            if ($image)
                Storage::delete($image);

            $folder = date('Y-m-d');
            return $request->file('thumbnail')->store("images/{$folder}");
        }
    }

    public function getImage()
    {
        return $this->thumbnail ? asset("uploads/" . $this->thumbnail) : asset("images/icons/no-image_1.png");
    }

    public function getPostDate()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('d F, Y');
    }

    public function changePostDate()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('Y.m.d');
    }

    public static function getById($id)
    {
        return Post::find($id)
            ->firstOrFail();
    }

    public static function getAllCached()
    {
        return Cache::remember('posts_all', env('CACHE_TIME'), function () {
            return Post::with('category', 'tags')->get();
        });
    }

    public static function clearCache(): bool
    {
        return Cache::forget('posts_all');
    }
}
