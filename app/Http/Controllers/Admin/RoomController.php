<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Room;
use App\Models\Team;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::with('team');

        // Search by name
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by status
        if ($status = $request->input('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $rooms = $query->orderBy('name')->paginate(10)->withQueryString();
        $teams = Team::where('is_active', true)->orderBy('name')->get();

        $assetQuery = Asset::query();
        if ($assetSearch = $request->input('asset_search')) {
            $assetQuery->where('name', 'like', "%{$assetSearch}%");
        }
        if ($assetStatus = $request->input('asset_status')) {
            if ($assetStatus === 'active') {
                $assetQuery->where('is_active', true);
            } elseif ($assetStatus === 'inactive') {
                $assetQuery->where('is_active', false);
            }
        }
        $assets = $assetQuery->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.rooms.index', compact('rooms', 'teams', 'assets'));
    }

    public function create()
    {
        $teams = Team::where('is_active', true)->orderBy('name')->get();

        return view('admin.rooms.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer|min:1',
            'location' => 'required',
            'team_id' => 'nullable|exists:teams,id',
        ]);
        $facilities = $request->facilities ? array_filter(array_map('trim', explode("\n", $request->facilities))) : [];
        Room::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'facilities' => $facilities,
            'location' => $request->location,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active', true),
            'team_id' => $request->team_id ?: null,
            'is_weekly_only' => $request->boolean('is_weekly_only'),
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        $teams = Team::where('is_active', true)->orderBy('name')->get();

        return view('admin.rooms.edit', compact('room', 'teams'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'name' => 'required',
            'capacity' => 'required|integer|min:1',
            'location' => 'required',
            'team_id' => 'nullable|exists:teams,id',
        ]);
        $facilities = $request->facilities ? array_filter(array_map('trim', explode("\n", $request->facilities))) : [];
        $room->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'facilities' => $facilities,
            'location' => $request->location,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
            'team_id' => $request->team_id ?: null,
            'is_weekly_only' => $request->boolean('is_weekly_only'),
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
