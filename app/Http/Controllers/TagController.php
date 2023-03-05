<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TagController extends Controller
{
    public function show(Tag $tag)
    {
        try {

            return view('tags.show', [
                'tag' => $tag,
                'posts' => Post::getByTag($tag)
            ]);
        } catch (ModelNotFoundException) {
            return redirect()->route('home');
        }
    }
}
