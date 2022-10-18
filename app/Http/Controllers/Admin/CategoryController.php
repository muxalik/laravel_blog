<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        Category::create($request->all());

        return redirect()
            ->route('categories.index')
            ->with([
                'success' => 'Категория успешно добавлена',
                'clearCache' => true
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.categories.edit', [
            'category' => Category::getById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required'
        ]);

        Category::updateById($request, $id);

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
    public function destroy(string|int $id)
    {
        if ($id === 'all')
            static::deleteAll();

        if (is_numeric($id))
            static::deleteOne((int) $id);

        abort(404);
    }

    public function refresh()
    {
        return view('admin.categories.card_body', [
            'categories' => Category::all()
        ]);
    }

    protected function deleteAll()
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

    protected function deleteOne(int $id)
    {
        $category = Category::getById($id);

        if ($category->getPostsCount()) {
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
}
