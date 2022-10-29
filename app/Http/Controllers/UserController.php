<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect()
            ->route('home')
            ->with('success', 'Вы успешно зарегистрировались');
    }

    public function loginForm()
    {
        return view('user.login');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            session()->flash('success', 'Вы успешно вошли в систему');

            if (Auth::user()->is_admin)
                return redirect()->route('admin.index');

            return redirect()->route('home');
        }

        return redirect()
            ->back()
            ->with('error', 'Неправильный логин или пароль');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.create');
    }

    public function contactForm()
    {
        return view('user.contact');
    }

    public function contactStore(ContactRequest $request)
    {
        Message::create($request->all());

        return redirect()
            ->route('home')
            ->with('success', 'Сообщение было успешно отправлено');
    }

}
