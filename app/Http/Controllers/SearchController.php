<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Post;

class SearchController extends Controller
{
    public function __invoke(SearchRequest $request)
    {
        return view('posts.search', [
            'posts' => Post::getSearchedPosts($request->s),
            's' => $request->s
        ]);
    }
}
