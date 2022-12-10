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
        $message = Message::findOrFail($id);
        $message->delete();

        return back();
    }

    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        $message->seen = now('Europe/Moscow')->toDateTimeString();
        $message->save();

        return back();
    }

    public function markAsUnread($id)
    {
        $message = Message::findOrFail($id);
        $message->seen = null;
        $message->save();

        return back();
    }
}
