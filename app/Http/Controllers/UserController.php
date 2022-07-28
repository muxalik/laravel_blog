<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        session()->flash('success', 'You\'ve registered successfully');
        Auth::login($user);
        return redirect()->route('home');
    }

    public function loginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            session()->flash('success', 'You\'ve logged in');

            if (Auth::user()->is_admin) {
                return redirect()->route('admin.index');
            }

            return redirect()->route('home');
        }

        return redirect()->back()->with('error', 'Incorrect login or password');
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

    public function contactStore(Request $request) 
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|regex:/[0-9\s]{13}/',
            'subject' => 'required|max:50',
            'message' => 'required|max:299'
        ]);

        Message::create($request->all());
        
        return redirect()->route('home')->with('success', 'Message has been sent successfully');
    }
}
