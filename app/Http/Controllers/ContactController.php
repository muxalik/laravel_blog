<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('contact');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ContactRequest  $request
     * @return RedirectResponse
     */
    public function store(ContactRequest $request): RedirectResponse
    {
        Message::create($request->validated());

        return redirect()
            ->route('home')
            ->with('success', 'Сообщение было успешно отправлено');
    }
}
