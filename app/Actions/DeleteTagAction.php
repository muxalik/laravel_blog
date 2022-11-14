<?php 

namespace App\Actions;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class DeleteTagAction 
{
    public function handle(int|string $id)
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

    protected static function deleteOne($id)
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
}