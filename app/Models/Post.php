<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        return $this->belongsToMany(Tag::class)
            ->withTimestamps();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn ($path) => $path
                ? asset("uploads/" . $path)
                : asset("images/icons/no-image_1.png")
        );
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function uploadImage(object $image, $thumbnail = null)
    {
        if ($thumbnail)
            Storage::delete($thumbnail);

        $folder = date('Y-m-d');
        return Storage::putFile("images/{$folder}/", $image);
    }

    public function getPostDate()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)
            ->format('d F, Y');
    }

    public function changePostDate()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)
            ->format('Y.m.d');
    }

    public static function getByCategory($category)
    {
        return $category->posts()
            ->latest()
            ->paginate(3);
    }

    public static function getByTag($tag)
    {
        return $tag->posts()
            ->latest()
            ->paginate(2);
    }

    public static function getSearchedPosts($s)
    {
        return Post::where('title', 'like', "%$s%")
            ->orWhere('description', 'like', "%$s%")
            ->with('category')
            ->paginate(3)
            ->fragment('main-section');
    }

    public static function getSorted()
    {
        return Post::with('category')
            ->latest()
            ->paginate(3)
            ->fragment('main-section');
    }

    public static function getRating()
    {
        return Post::pluck('likes', 'dislikes');
    }

    public static function getPopular()
    {
        return Post::orderByDesc('views')
            ->limit(3)
            ->get();
    }

    public static function getRecent()
    {
        return Post::orderByDesc('id')
            ->limit(3)
            ->get();
    }

    public static function getPopularStats()
    {
        return Post::select(['likes', 'dislikes', 'created_at'])
            ->orderBy('views')
            ->limit(7)
            ->get()
            ->sortBy('created_at');
    }

    public static function getRecentStats()
    {
        return Post::select(['likes', 'dislikes', 'views', 'created_at'])
            ->orderBy('created_at')
            ->limit(7)
            ->get();
    }
}
