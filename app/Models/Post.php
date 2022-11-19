<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    public static function getById($id)
    {
        return Post::find($id);
    }

    public static function getByCategory($category)
    {
        return $category->posts()
            ->latest()
            ->paginate(3);
    }

    public static function getBySlug($slug)
    {
        return Post::where('slug', $slug)
            ->firstOrFail();
    }

    public static function getByTag($tag)
    {
        return $tag->posts()
            ->with('category')
            ->latest()
            ->paginate(2);
    }

    public static function getSearchedPosts($s)
    {
        return Cache::remember("searched_posts_$s", env('CACHE_TIME'), function () use ($s) {
            return Post::where('title', 'like', "%$s%")
                ->orWhere('description', 'like', "%$s%")
                ->with('category')
                ->paginate(3)
                ->fragment('main-section');
        });
    }

    public static function getWithIncrement($slug)
    {
        $post = Post::getBySlug($slug);
        $post->views += 1;
        $post->update();

        return $post;
    }

    public static function getSimilar($post)
    {
        $tags = $post
            ->tags
            ->random(2);

        $first = $tags[0]
            ->posts
            ->random(1)[0];

        $key = $first->id;

        $second = $tags[1]
            ->posts
            ->except($key)
            ->random(1)[0];

        return [$first, $second];
    }

    public static function getAllCached()
    {
        return Cache::remember('posts_all', env('CACHE_TIME'), function () {
            return Post::with('category', 'tags')
                ->get();
        });
    }

    public static function getSortedCached()
    {
        return Cache::remember('sorted_posts', env('CACHE_TIME'), function () {
            return Post::with('category')
                ->latest()
                ->paginate(3)
                ->fragment('main-section');
        });
    }

    public static function clearCache()
    {
        return Cache::forget('posts_all');
    }

    public static function getRating()
    {
        return Cache::remember('posts_rating', env('CACHE_TIME'), function () {
            return collect(Post::pluck('likes', 'dislikes')
                ->all());
        });
    }

    public static function getPopular()
    {
        return Cache::remember('popular_posts', env('CACHE_TIME'), function () {
            return Post::orderBy('views', 'desc')
                ->limit(3)
                ->get();
        });
    }

    public static function getRecent()
    {
        return Cache::remember('recent_posts', env('CACHE_TIME'), function () {
            return Post::orderBy('id', 'desc')
                ->limit(3)
                ->get();
        });
    }

    public static function getPopularStats()
    {
        return Cache::remember('recent_posts_stats', env('CACHE_TIME'), function () {
            return Post::orderBy('views')
                ->limit(7)
                ->get()
                ->sortBy('created_at');
        });
    }

    public static function getRecentStats()
    {
        return Cache::remember('recent_posts_stats', env('CACHE_TIME'), function () {
            return collect(Post::orderBy('created_at')
                ->limit(7)
                ->get());
        });
    }

    public static function getAvgViews()
    {
        return ceil(Post::avg('views'));
    }

    public static function getAmount()
    {
        return Post::count('id');
    }
}
