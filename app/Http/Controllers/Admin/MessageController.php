<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        return view('admin.messages.index', [
            'messages' => Message::with('user')->get()
        ]);
    }

    public function destroy($id)
    {
        if ($id === 'all')
            Message::truncate();
        else
            Message::where('id', $id)->delete();

        return back();
    }

    public function markAsRead($id)
    {
        Message::where('id', $id)->update(['seen' => now()]);
        return back();
    }

    public function markAsUnread($id)
    {
        Message::where('id', $id)->update(['seen' => null]);
        return back();
    }

    public function markAllAsRead()
    {
        Message::whereNull('seen')->update(['seen' => now()]);
        return back();
    }

    public function markAllAsUnread()
    {
        Message::query()->update(['seen' => null]);
        return back();
    }
}
