<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        return view('tags.show', [
            'tag' => $tag,
            'posts' => Post::getByTag($tag)
        ]);
    }
}
