<?php

namespace App\Actions;

use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class DeleteTagAction
{
    /**
     * handle
     *
     * @param  int|string $id
     * @return RedirectResponse
     */
    public function handle(int|string $id): RedirectResponse
    {
        if ($id === 'all')
            return static::deleteAll();

        return static::deleteOne($id);
    }

    /**
     * deleteAll
     *
     * @return RedirectResponse
     */
    protected static function deleteAll(): RedirectResponse
    {
        $data = DB::select('SELECT * FROM post_tag LIMIT 1');

        if (Tag::count() && !count($data)) {
            Tag::truncate();

            return redirect()
                ->route('tags.index')
                ->with('success', 'Все теги успешно удалены');
        }

        return redirect()
            ->route('tags.index')
            ->with('error', 'У тегов есть записи');
    }

    /**
     * deleteOne
     *
     * @param  int|string $id
     * @return RedirectResponse
     */
    protected static function deleteOne(int|string $id): RedirectResponse
    {
        $tag = Tag::findOrFail($id);

        if ($tag->posts()->exists())
            return redirect()
                ->route('tags.index')
                ->with('error', 'У тегов есть записи');

        $tag->delete();

        return redirect()
            ->route('tags.index')
            ->with('success', 'Тег успешно удален');
    }
}
