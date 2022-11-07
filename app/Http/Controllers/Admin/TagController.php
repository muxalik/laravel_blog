<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
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
        if (session('clearCache'))
            Tag::clearCache();

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
    public function store(TagRequest $request)
    {
        Tag::create($request->all());

        return redirect()
            ->route('tags.index')
            ->with([
                'success' => 'Тег успешно добавлен',
                'clearCache' => true
            ]);
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
    public function update(TagRequest $request, int $id)
    {
        Tag::updateById($request, $id);

        return redirect()
            ->route('tags.index')
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
    public function destroy(int|string $id)
    {
        if ($id === 'all')
            return static::deleteAll();

        return static::deleteOne($id);
    }

    protected static function deleteAll()
    {
        $data = DB::select('SELECT * FROM post_tag LIMIT 1');

        if (!count($data)) {
            Tag::truncate();

            return redirect()
                ->route('tags.index')
                ->with([
                    'success' => 'Все теги успешно удалены',
                    'clearCache' => true
                ]);
        }

        return redirect()
            ->route('tags.index')
            ->with('error', 'У тегов есть записи');
    }

    protected static function deleteOne(int $id)
    {
        $tag = Tag::getById($id);

        if ($tag->getPostsAmount())
            return redirect()
                ->route('tags.index')
                ->with('error', 'У тегов есть записи');

        $tag->delete();

        return redirect()
            ->route('tags.index')
            ->with([
                'success' => 'Тег успешно удален',
                'clearCache' => true
            ]);
    }

    public function refresh()
    {
        return view('admin.tags.table', [
            'tags' => Tag::all()
        ]);
    }
}
