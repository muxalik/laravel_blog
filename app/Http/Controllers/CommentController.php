<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (!Auth::check())
            return redirect()->route('login.create');

        Comment::create([
            'user_id' => Auth::user()->id,
            'post_id' => $id,
            'content' => $request->content
        ]);

        return redirect()->back();
    }

    public function loadMore(Request $request, $id)
    {
        if ($request->ajax()) {
            return view('posts.comments', [
                'comments' => Comment::getByPostId($id)
            ]);
        }
    }
}
