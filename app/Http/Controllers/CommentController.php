<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
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

            Comment::create([
                'user_id' => auth()->user()->id,
                'post_id' => $id,
                'content' => $request->content
            ]);

            return back();
        } catch (Throwable) {
            return redirect()->route('home');
        }
    }

    public function loadMore($id)
    {
        try {
            return view('posts.comments', [
                'comments' => Comment::getByPostId($id)
            ]);
        } catch (ModelNotFoundException) {
            return false;
        }
    }
}
