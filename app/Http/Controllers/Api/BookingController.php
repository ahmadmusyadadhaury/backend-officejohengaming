<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user:id,name,email', 'room:id,name,location'])
            ->where('status', '!=', 'cancelled');

        // Filter by date if provided
        if ($request->has('date') && $request->date) {
            $query->whereDate('start_time', $request->date);
        }

        // If not admin, only show user's own bookings
        if (Auth::user()->role !== 'ADMIN') {
            $query->where('user_id', Auth::id());
        }

        $bookings = $query->orderBy('start_time')->get();

        return response()->json($bookings->map(function ($booking) {
            return [
                'id' => $booking->id,
                'title' => $booking->title,
                'description' => $booking->description,
                'participants' => $booking->participants,
                'start_time' => $booking->start_time,
                'end_time' => $booking->end_time,
                'status' => $booking->status,
                'room_name' => $booking->room->name,
                'room_location' => $booking->room->location,
                'user_name' => $booking->user->name,
            ];
        }));
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'participants' => 'nullable|string',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $room = Room::findOrFail($request->room_id);

        // Check if room is active
        if (!$room->is_active) {
            return response()->json([
                'error' => 'Room is not available'
            ], 400);
        }

        // Check for conflicts
        if (!$room->isAvailable($request->start_time, $request->end_time)) {
            return response()->json([
                'error' => 'Room is not available at the selected time'
            ], 409);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'title' => $request->title,
            'description' => $request->description,
            'participants' => $request->participants,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'approved',
        ]);

        return response()->json([
            'message' => 'Booking created successfully',
            'booking' => [
                'id' => $booking->id,
                'user_id' => $booking->user_id,
                'room_id' => $booking->room_id,
                'title' => $booking->title,
                'description' => $booking->description,
                'participants' => $booking->participants,
                'start_time' => $booking->start_time,
                'end_time' => $booking->end_time,
                'status' => $booking->status,
            ]
        ], 201);
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking)
    {
        // Check if user owns the booking or is admin
        if ($booking->user_id !== Auth::id() && Auth::user()->role !== 'ADMIN') {
            return response()->json([
                'error' => 'Unauthorized'
            ], 403);
        }

        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully'
        ]);
    }
}
