<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index() { return view('admin.rooms.index', ['rooms' => Room::paginate(15)]); }
    public function create() { return view('admin.rooms.create'); }
    public function store(Request $request) {
        $request->validate(['name' => 'required', 'capacity' => 'required|integer|min:1', 'location' => 'required']);
        $facilities = $request->facilities ? array_filter(array_map('trim', explode("\n", $request->facilities))) : [];
        Room::create(['name' => $request->name, 'capacity' => $request->capacity, 'facilities' => $facilities, 'location' => $request->location, 'description' => $request->description, 'is_active' => $request->boolean('is_active', true)]);
        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }
    public function edit(Room $room) { return view('admin.rooms.edit', compact('room')); }
    public function update(Request $request, Room $room) {
        $request->validate(['name' => 'required', 'capacity' => 'required|integer|min:1', 'location' => 'required']);
        $facilities = $request->facilities ? array_filter(array_map('trim', explode("\n", $request->facilities))) : [];
        $room->update(['name' => $request->name, 'capacity' => $request->capacity, 'facilities' => $facilities, 'location' => $request->location, 'description' => $request->description, 'is_active' => $request->boolean('is_active')]);
        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil diperbarui.');
    }
    public function destroy(Room $room) {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
