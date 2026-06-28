<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function conversations()
    {
        $userId = auth()->id();

        $users = User::where('id', '!=', $userId)
            ->whereIn('role', array_merge(User::FULL_ACCESS_ROLES, ['koordinator', 'user']))
            ->where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function ($user) use ($userId) {
                $lastMsg = Message::betweenUsers($userId, $user->id)
                    ->latest()
                    ->first();

                $unread = Message::unreadForUser($userId)
                    ->where('sender_id', $user->id)
                    ->count();

                return [
                    'user' => $user,
                    'last_message' => $lastMsg?->message ?? '',
                    'last_time' => $lastMsg?->created_at,
                    'unread' => $unread,
                ];
            })
            ->sortByDesc(fn ($c) => $c['last_time'])
            ->values();

        $totalUnread = Message::unreadForUser($userId)->count();

        return response()->json([
            'conversations' => $users,
            'total_unread' => $totalUnread,
        ]);
    }

    public function messages(Request $request)
    {
        $request->validate(['with' => 'required|exists:users,id']);

        $userId = auth()->id();
        $withId = $request->integer('with');

        Message::where('sender_id', $withId)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::betweenUsers($userId, $withId)
            ->with('sender:id,name,role')
            ->oldest()
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:5000',
        ]);

        $msg = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->integer('receiver_id'),
            'message' => $request->message,
        ]);

        $msg->load('sender:id,name,role');

        return response()->json(['message' => $msg], 201);
    }

    public function unreadCount()
    {
        $count = Message::unreadForUser(auth()->id())->count();

        return response()->json(['unread' => $count]);
    }
}
