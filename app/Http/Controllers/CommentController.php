<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, $id)
    {
        try {
            if (auth()->guest())
                return redirect()->route('login.create');

            auth()->user()->comments()->create([
                'post_id' => $id,
                'content' => $request->content
            ]);

            return back();
        } catch (Throwable) {
            return redirect()->route('home');
        }
    }

    public function loadMore(Post $post)
    {
        try {
            return view('posts.comments', [
                'comments' => $post->comments()->oldest()->paginate(4)
            ]);
        } catch (ModelNotFoundException) {
            return false;
        }
    }
}
