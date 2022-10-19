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
        
        return view('posts.search', [
            'posts' => Post::getSearchedPosts($request->s),
            's' => $request->s
        ]);
    }
}
