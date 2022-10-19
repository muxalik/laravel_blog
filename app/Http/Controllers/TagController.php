<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;

class TagController extends Controller
{
    public function show($slug)
    {
        $tag = Tag::getBySlug($slug);
        $posts = Post::getByTag($tag);

        return view('tags.show', compact('tag', 'posts'));
    }
}
