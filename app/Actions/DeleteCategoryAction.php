<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;

class DeleteCategoryAction
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
        if (Post::first()->doesntExist()) {
            Category::truncate();

            return redirect()
                ->route('categories.index')
                ->with('success', 'Все теги успешно удалены');
        }

        return redirect()
            ->route('categories.index')
            ->with('error', 'У категорий есть записи');
    }

    /**
     * deleteOne
     *
     * @param  int|string $id
     * @return RedirectResponse
     */
    protected static function deleteOne(int|string $id): RedirectResponse
    {
        $category = Category::findOrFail($id);

        if ($category->posts()->first()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'У категории есть записи');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Категория успешно удалена');
    }
}
