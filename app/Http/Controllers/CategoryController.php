<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::getBySlug($slug);
        $posts = Post::getByCategory($category);
            
        return view('categories.show', compact('category', 'posts'));
    }
}
