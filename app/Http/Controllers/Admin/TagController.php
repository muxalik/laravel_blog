<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Cache::has('tags_all')) {
            $tags = Cache::get('tags_all');
        } else {
            $tags = Tag::all();
            Cache::put('tags_all', $tags, env('CACHE_TIME_FOR_ADMIN'));
        }

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tags.create');
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

        Tag::create($request->all());

        return redirect()->route('tags.index')->with('success', 'Тег успешно добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::find($id);

        return view('admin.tags.edit', compact('tag'));
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
        $tag = Tag::find($id);
        $tag->update($request->all());

        return redirect()->route('tags.index')->with('success', 'Изменения успешно сохранены');
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
            $data = DB::select('SELECT * FROM post_tag LIMIT 1');
            if (!count($data)) {
                Tag::truncate();
                return redirect()->route('tags.index')->with('success', 'Все теги успешно удалены');
            }
            return redirect()->route('tags.index')->with('error', 'У тегов есть записи');
        }

        $tag = Tag::find($id);
        if ($tag->posts->count())
            return redirect()->route('tags.index')->with('error', 'У тегов есть записи');

        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'Тег успешно удален');
    }
}
