<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AdminUserService
{
    /**
     * store
     *
     * @param  User $user
     * @param  mixed $check
     * @return RedirectResponse
     */
    public function store(User $user, $checked): RedirectResponse
    {
        if ($checked) {
            auth()->logout();
            auth()->login($user);

            return redirect()
                ->route('home')
                ->with('success', 'Пользователь успешно зарегистрирован');
        }

        return redirect()
            ->route('users.index')
            ->with('success', 'Пользователь успешно зарегистрирован');
    }

    /**
     * update
     *
     * @param  User $user
     * @param  mixed $checked
     * @return RedirectResponse
     */
    public function update(User $user, $checked): RedirectResponse
    {
        if (auth()->user()->email === $user->email && auth()->user() != $user) {
            auth()->logout();
            auth()->login($user);
        }

        if (!$checked) {
            return redirect()
                ->route('users.index')
                ->with('success', 'Пользователь успешно сохранен');
        }

        if (auth()->user() != $user) {
            auth()->logout();
            auth()->login($user);
        }
    }

    /**
     * delete
     *
     * @param  int|string $id
     * @return RedirectResponse
     */
    public function delete(int|string $id): RedirectResponse
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
    protected function deleteAll(): RedirectResponse
    {
        DB::delete('DELETE FROM users WHERE id != ' . auth()->user()->id);

        return redirect()
            ->route('users.index')
            ->with('success', 'Все пользователи успешно удалены');
    }

    /**
     * deleteOne
     *
     * @param  int|string $id
     * @return RedirectResponse
     */
    protected function deleteOne(int|string $id): RedirectResponse
    {
        User::find($id)->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'Пользователь успешно удален');
    }
}
