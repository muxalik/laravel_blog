<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;

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
        if (auth()->guest())
            return redirect()->route('login.create');

        Comment::create([
            'user_id' => auth()->user()->id,
            'post_id' => $id,
            'content' => $request->content
        ]);

        return back();
    }
    
    public function loadMore($id)
    {
        return view('posts.comments', [
            'comments' => Comment::getByPostId($id)
        ]);
    }
}
