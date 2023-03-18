<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        return view('auth.login');
    }

    /**
     * login
     *
     * @param  LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        if (auth()->attempt($request->validated())) {
            session()->flash('success', 'Вы успешно вошли в систему');

            if (auth()->user()->is_admin)
                return redirect()->route('admin.index');

            return redirect()->route('home');
        }

        return redirect()->route('login')
            ->with('error', 'Неправильный логин или пароль');
    }

    /**
     * logout
     *
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.create');
    }
}
