<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return auth()->user()->unreadNotifications()->get()->toJson();
    }

    public function markAsRead(Request $request)
    {
        auth()->user()->unreadNotifications->where('id', $request->id)->markAsRead();
        return response()->json(['status' => 'success']);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}