<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SearchController extends Controller
{
    public function __invoke(SearchRequest $request)
    {
        try {
            return view('posts.search', [
                'posts' => Post::getSearchedPosts($request->s),
                's' => $request->s
            ]);
        } catch (ModelNotFoundException) {
            return redirect()->route('home');
        }
    }
}
