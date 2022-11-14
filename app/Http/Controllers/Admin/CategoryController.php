<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session('clearCache'))
            Category::clearCache();

        return view('admin.categories.index', [
            'categories' => Category::getAllCached()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->all());

        return redirect()
            ->route('categories.index')
            ->with([
                'success' => 'Категория успешно добавлена',
                'clearCache' => true
            ]);
    }
        
    /**
     * edit
     *
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        return redirect()
            ->route('categories.index')
            ->with([
                'success' => 'Изменения успешно сохранены',
                'clearCache' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id === 'all')
            return static::deleteAll();

        return static::deleteOne($id);
    }

    protected static function deleteAll()
    {
        if (!count(Post::first())) {
            Category::truncate();

            return redirect()
                ->route('categories.index')
                ->with([
                    'success' => 'Все теги успешно удалены',
                    'clearCache' => true
                ]);
        }

        return redirect()
            ->route('categories.index')
            ->with('error', 'У категорий есть записи');
    }

    protected static function deleteOne($id)
    {
        $category = Category::getById($id);

        if ($category->getPostsAmount()) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'У категории есть записи');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with([
                'success' => 'Категория успешно удалена',
                'clearCache' => true
            ]);
    }

    public function refresh()
    {
        return view('admin.categories.table', [
            'categories' => Category::all()
        ]);
    }
}
