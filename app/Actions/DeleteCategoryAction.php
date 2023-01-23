<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Post;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

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
        if (Category::count() && Post::has('category')->doesntExist()) {
            Category::query()->delete();

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

        if ($category->posts()->exists()) {
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
