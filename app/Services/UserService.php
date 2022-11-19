<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class UserService 
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
                ->with('clearCache', true);
        }

        return redirect()
            ->route('users.index')
            ->with([
                'success' => 'Пользователь успешно зарегистрирован',
                'clearCache' => true
            ]);
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
            ->with([
                'success' => 'Пользователь успешно сохранен',
                'clearCache' => true
            ]);
            
        }

        if (auth()->user() != $user) {
            auth()->logout();
            auth()->login($user);
        }

        if ($user->is_admin)
            return redirect()
                ->route('admin.index')
                ->with('clearCache', true);

        return redirect()
            ->route('home')
            ->with('clearCache', true);        
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
            ->with([
                'success' => 'Все пользователи успешно удалены',
                'clearCache' => true
            ]);
    }
    
    /**
     * deleteOne
     *
     * @param  int|string $id
     * @return RedirectResponse
     */
    protected function deleteOne(int|string $id): RedirectResponse
    {
        User::deleteById($id);

        return redirect()
            ->route('users.index')
            ->with([
                'success' => 'Пользователь успешно удален',
                'clearCache' => true
            ]);
    }
}