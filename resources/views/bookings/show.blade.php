@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">{{ $booking->title }}</h1>
                <a href="{{ route('bookings.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to My Bookings
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-4">Booking Details</h2>
                    <p class="mb-2"><strong>Room:</strong> {{ $booking->room->name }}</p>
                    <p class="mb-2"><strong>Start Time:</strong> {{ $booking->start_time->format('M j, Y g:i A') }}</p>
                    <p class="mb-2"><strong>End Time:</strong> {{ $booking->end_time->format('g:i A') }}</p>
                    <p class="mb-2"><strong>Status:</strong>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                            @if($booking->status === 'approved') bg-green-100 text-green-800
                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </p>
                    @if($booking->description)
                        <p class="mb-4"><strong>Description:</strong> {{ $booking->description }}</p>
                    @endif
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-4">Room Information</h2>
                    <p class="mb-2"><strong>Capacity:</strong> {{ $booking->room->capacity }} people</p>
                    @if($booking->room->location)
                        <p class="mb-2"><strong>Location:</strong> {{ $booking->room->location }}</p>
                    @endif
                    @if($booking->room->description)
                        <p class="mb-4"><strong>Description:</strong> {{ $booking->room->description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection