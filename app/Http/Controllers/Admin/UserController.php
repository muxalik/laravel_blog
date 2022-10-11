<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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
        if (Cache::has('users_all')) {
            $users = Cache::get('users_all');
        } else {
            $users = User::all();
            Cache::put('users_all', $users, env('CACHE_TIME_FOR_ADMIN_PART'));
        }

        return view('admin.users.index', compact('users'));
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:64',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($request->check) {
            Auth::logout();
            Auth::login($user);
            return redirect()->route('home');
        }
        
        return redirect()->route('users.index')->with('success', 'Пользователь успешно зарегистрирован');
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
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
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
        $request->validate([
            'name' => 'required|max:64|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::find($id);

        $user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        if (Auth::user()->email === $user->email && Auth::user() != $user) {
            Auth::logout();
            Auth::login($user);
        }

        if ($request->check) {
            if (Auth::user() != $user) {
                Auth::logout();
                Auth::login($user);
            }
            
            if ($user->is_admin) 
                return redirect()->route('admin.index');    
            
            return redirect()->route('home');
        }
        
        return redirect()->route('users.index')->with('success', 'Пользователь успешно сохранен');
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
            DB::delete('DELETE FROM users WHERE id != ' . Auth::user()->id);
            return redirect()->route('users.index')->with('success', 'Все пользователи успешно удалены');
        }

        $user = User::find($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Пользователь успешно удален');
    }
}
