<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\AdminUserService;

class UserController extends Controller
{

    public function __construct(AdminUserService $service)
    {
        $this->service = $service;
    }
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
        $user = User::create($request->validated());
        return $this->service->store($user, $request->check);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        $this->service->update($user, $request->check);

        if ($user->is_admin)
            return redirect()
                ->route('admin.index')
                ->with([
                    'success' => 'Пользователь успешно сохранен',
                    'clearCache' => true
                ]);

        return redirect()
            ->route('home')
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
        return $this->service->delete($id);        
    }

    public function refresh()
    {
        return view('admin.users.table', [
            'users' => User::all()
        ]);
    }
}
