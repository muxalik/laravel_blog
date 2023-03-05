<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        try {
            return view('categories.show', [
                'category' => $category,
                'posts' => Post::getByCategory($category)
            ]);
        } catch (ModelNotFoundException) {
            return redirect()->route('home');
        }
    }
}
