<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::getBySlug($slug);
        $posts = Category::getPostsByCategory($category);
            
        return view('categories.show', compact('category', 'posts'));
    }
}
