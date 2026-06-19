<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\WeeklyMeeting;
use Illuminate\Http\Request;

class WeeklyMeetingController extends Controller
{
    public function index()
    {
        return view('admin.weekly.index', ['weeklies' => WeeklyMeeting::with('room')->get()]);
    }

    public function create()
    {
        return view('admin.weekly.create', ['rooms' => Room::where('is_active', true)->get()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'room_id' => 'required|exists:rooms,id',
            'day_of_week' => 'required|integer|between:1,7',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);
        WeeklyMeeting::create($request->only('title', 'room_id', 'day_of_week', 'start_time', 'end_time') + ['created_by' => auth()->id(), 'is_active' => true]);

        return redirect()->route('admin.weekly-meetings.index')->with('success', 'Meeting mingguan berhasil dibuat.');
    }

    public function edit(WeeklyMeeting $weeklyMeeting)
    {
        return view('admin.weekly.edit', ['weekly' => $weeklyMeeting, 'rooms' => Room::where('is_active', true)->get()]);
    }

    public function update(Request $request, WeeklyMeeting $weeklyMeeting)
    {
        $request->validate(['title' => 'required', 'room_id' => 'required', 'day_of_week' => 'required|integer|between:1,7', 'start_time' => 'required', 'end_time' => 'required']);
        $weeklyMeeting->update($request->only('title', 'room_id', 'day_of_week', 'start_time', 'end_time', 'is_active'));

        return redirect()->route('admin.weekly-meetings.index')->with('success', 'Meeting mingguan diperbarui.');
    }

    public function destroy(WeeklyMeeting $weeklyMeeting)
    {
        $weeklyMeeting->delete();

        return redirect()->route('admin.weekly-meetings.index')->with('success', 'Meeting mingguan dihapus.');
    }
}
