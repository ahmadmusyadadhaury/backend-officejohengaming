<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = auth()->user()->ticketNotifications()
            ->with('ticket')
            ->latest()
            ->paginate(20);

        return view('tickets.notifications', compact('notifications'));
    }

    public function read(Request $request)
    {
        auth()->user()->ticketNotifications()->where('is_read', false)->update(['is_read' => true]);

        if ($request->input('url')) {
            return redirect($request->input('url'));
        }

        return back()->with('success', 'Semua notifikasi ditandai dibaca.');
    }

    public function unreadCount()
    {
        return response()->json([
            'count' => auth()->user()->ticketNotifications()->where('is_read', false)->count(),
        ]);
    }

    public function destroy(Request $request)
    {
        auth()->user()->ticketNotifications()->delete();

        return back()->with('success', 'Semua notifikasi dihapus.');
    }
}
