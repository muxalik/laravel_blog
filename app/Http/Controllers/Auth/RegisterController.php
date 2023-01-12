<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{    
    /**
     * create
     *
     * @return View
     */
    public function index(): View
    {
        return view('auth.register');
    }
    
    /**
     * store
     *
     * @param  RegisterRequest $request
     * @return RedirectResponse
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());
        auth()->login($user);
        event(new Registered($user));

        return redirect()
            ->route('home')
            ->with('success', 'Вы успешно зарегистрировались');
    }
}
