<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Throwable;

class RatingController extends Controller
{
    const LIKED = 1;
    const DISLIKED = -1;

    public function __invoke(Request $request)
    {
        try {
            if ($request->ajax()) {
                $input = $request->all();

                Post::find($input['post'])
                    ->when($input['rating'] == self::LIKED, function ($query) {
                        $query->increment('likes');
                        $query->decrement('dislikes');
                    })->when($input['rating'] == self::DISLIKED, function ($query) {
                        $query->increment('dislikes');
                        $query->decrement('likes');
                    });
            }
        } catch (Throwable){
            return false;
        }
        
    }
}
