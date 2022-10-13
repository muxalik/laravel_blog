<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            's' => 'required'
        ]);

        $s = $request->s;

        $posts = Cache::remember("searched_posts_$s", env('CACHE_TIME_FOR_ADMIN_DATA'), function () use ($s) {
            return Post::like($s)->with('category')->paginate(3);
        });

        return view('posts.search', compact('posts', 's'));
    }
}
