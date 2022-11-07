<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session('clearCache'))
            User::clearCache();

        return view('admin.users.index', [
            'users' => User::getAllCached()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        $user = User::create($request->all());

        // Login after creating
        if ($request->check) {
            Auth::logout();
            Auth::login($user);

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

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.users.edit', [
            'user' => User::getById($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $user = User::getById($id);

        $user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        // Relogin if current user was updated
        if (Auth::user()->email === $user->email && Auth::user() != $user) {
            Auth::logout();
            Auth::login($user);
        }

        // Login after updating
        if ($request->check) {
            if (Auth::user() != $user) {
                Auth::logout();
                Auth::login($user);
            }

            if ($user->is_admin)
                return redirect()
                    ->route('admin.index')
                    ->with('clearCache', true);

            return redirect()
                ->route('home')
                ->with('clearCache', true);
        }

        return redirect()
            ->route('users.index')
            ->with([
                'success' => 'Пользователь успешно сохранен',
                'clearCache' => true
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id === 'all')
            return static::deleteAll();

        return static::deleteOne($id);
    }

    protected static function deleteAll()
    {
        DB::delete('DELETE FROM users WHERE id != ' . Auth::user()->id);

        return redirect()
            ->route('users.index')
            ->with([
                'success' => 'Все пользователи успешно удалены',
                'clearCache' => true
            ]);
    }

    protected static function deleteOne($id)
    {
        User::deleteById($id);

        return redirect()
            ->route('users.index')
            ->with([
                'success' => 'Пользователь успешно удален',
                'clearCache' => true
            ]);
    }

    public function refresh()
    {
        return view('admin.users.table', [
            'users' => User::all()
        ]);
    }
}
