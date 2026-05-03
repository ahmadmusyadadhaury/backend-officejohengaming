@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-6">My Bookings</h1>

            @if($bookings->count() > 0)
                <div class="space-y-4">
                    @foreach($bookings as $booking)
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $booking->title }}</h3>
                                    <p class="text-gray-600 mb-2">{{ $booking->room->name }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $booking->start_time->format('M j, Y g:i A') }} - {{ $booking->end_time->format('g:i A') }}
                                    </p>
                                    @if($booking->description)
                                        <p class="text-sm text-gray-600 mt-2">{{ $booking->description }}</p>
                                    @endif
                                    <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded-full
                                        @if($booking->status === 'approved') bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('bookings.show', $booking) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        View
                                    </a>
                                    @if($booking->status !== 'cancelled')
                                        <form method="POST" action="{{ route('bookings.destroy', $booking) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm"
                                                    onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">You haven't made any bookings yet.</p>
                <a href="{{ route('rooms.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4 inline-block">
                    Browse Rooms
                </a>
            @endif
        </div>
    </div>
@endsection