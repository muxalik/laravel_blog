<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    public function show(Category $category)
    {
        return view('categories.show', [
            'category' => $category,
            'posts' => Post::getByCategory($category)
        ]);
    }
}
