<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of rooms.
     */
    public function index()
    {
        $rooms = Room::where('is_active', true)
            ->select('id', 'name', 'capacity', 'facilities', 'location', 'description')
            ->get();

        // Parse facilities JSON
        $rooms->transform(function ($room) {
            $room->facilities = $room->facilities ? json_decode($room->facilities) : [];

            return $room;
        });

        return response()->json($rooms);
    }

    /**
     * Store a newly created room.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|array',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        $room = Room::create([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'facilities' => json_encode($request->facilities ?? []),
            'location' => $request->location,
            'description' => $request->description,
            'is_active' => true,
        ]);

        return response()->json([
            'message' => 'Room created successfully',
            'room' => [
                'id' => $room->id,
                'name' => $room->name,
                'capacity' => $room->capacity,
                'facilities' => $room->facilities ? json_decode($room->facilities) : [],
                'location' => $room->location,
                'description' => $room->description,
                'is_active' => $room->is_active,
            ],
        ], 201);
    }

    /**
     * Update the specified room.
     */
    public function update(Request $request, Room $room)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'facilities' => 'nullable|array',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        $room->update([
            'name' => $request->name,
            'capacity' => $request->capacity,
            'facilities' => json_encode($request->facilities ?? []),
            'location' => $request->location,
            'description' => $request->description,
            'is_active' => $request->is_active ?? $room->is_active,
        ]);

        return response()->json([
            'message' => 'Room updated successfully',
            'room' => [
                'id' => $room->id,
                'name' => $room->name,
                'capacity' => $room->capacity,
                'facilities' => $room->facilities ? json_decode($room->facilities) : [],
                'location' => $room->location,
                'description' => $room->description,
                'is_active' => $room->is_active,
            ],
        ]);
    }

    /**
     * Remove the specified room.
     */
    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json([
            'message' => 'Room deleted successfully',
        ]);
    }
}
