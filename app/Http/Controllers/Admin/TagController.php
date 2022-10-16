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
        return view('admin.tags.index', [
            'tags' => Tag::getAllCached()
        ]);
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
        Tag::clearCache();

        return redirect()
            ->route('tags.index')
            ->with('success', 'Тег успешно добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('admin.tags.edit', [
            'tag' => Tag::getById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        Tag::getById($id)
            ->update($request->all());
        Tag::clearCache();

        return redirect()
            ->route('tags.index')
            ->with('success', 'Изменения успешно сохранены');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int|string $id)
    {
        // Delete all tags
        if ($id === 'all') {
            $data = DB::select('SELECT * FROM post_tag LIMIT 1');

            if (!count($data)) {
                Tag::truncate();
                Tag::clearCache();

                return redirect()
                    ->route('tags.index')
                    ->with('success', 'Все теги успешно удалены');
            }

            return redirect()
                ->route('tags.index')
                ->with('error', 'У тегов есть записи');
        }

        // Delete one tag
        $tag = Tag::getById($id);

        if ($tag->posts->count())
            return redirect()
                ->route('tags.index')
                ->with('error', 'У тегов есть записи');

        $tag->delete();
        Tag::clearCache();

        return redirect()
            ->route('tags.index')
            ->with('success', 'Тег успешно удален');
    }
}
