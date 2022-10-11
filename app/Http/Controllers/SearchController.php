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
        
        if (Cache::has("searched_posts_$s")) {
            $posts = Cache::get("searched_posts_$s");
        } else {
            $posts = Post::like($s)->with('category')->paginate(3);
            Cache::put("sorted_posts_$s", $posts, env('CACHE_TIME_FOR_USER_DATA'));
        }

        return view('posts.search', compact('posts', 's'));
    }
}
