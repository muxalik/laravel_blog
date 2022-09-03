<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
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
        return redirect()->route('categories.index')->with('success', 'Категория успешно добавлена');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
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
        
        $category = Category::find($id);
        $category->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Изменения успешно сохранены');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id === 'all') {
           $data = DB::select('SELECT * FROM posts LIMIT 1');
            if (!count($data)) {
                Category::truncate();
                return redirect()->route('categories.index')->with('success', 'Все теги успешно удалены');
            }
            return redirect()->route('categories.index')->with('error', 'У категорий есть записи');
        }

        $category = Category::find($id);
        if ($category->posts->count()) {
            return redirect()->route('categories.index')->with('error', 'У категории есть записи');
        }
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Категория успешно удалена');
    }

    public function refresh()
    {
        $categories = Category::all();
        return view('admin.categories.card_body', compact('categories'));
    }
}
