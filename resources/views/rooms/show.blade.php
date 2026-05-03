@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold">{{ $room->name }}</h1>
                <a href="{{ route('rooms.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Rooms
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-4">Room Information</h2>
                    <p class="mb-2"><strong>Capacity:</strong> {{ $room->capacity }} people</p>
                    @if($room->location)
                        <p class="mb-2"><strong>Location:</strong> {{ $room->location }}</p>
                    @endif
                    @if($room->description)
                        <p class="mb-4"><strong>Description:</strong> {{ $room->description }}</p>
                    @endif

                    <h3 class="text-lg font-semibold mb-4">Upcoming Bookings</h3>
                    @if($bookings->count() > 0)
                        <div class="space-y-2">
                            @foreach($bookings as $booking)
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="font-medium">{{ $booking->title }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $booking->start_time->format('M j, Y g:i A') }} - {{ $booking->end_time->format('g:i A') }}
                                    </p>
                                    <p class="text-sm text-gray-600">Booked by: {{ $booking->user->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No upcoming bookings</p>
                    @endif
                </div>

                <div>
                    <h2 class="text-xl font-semibold mb-4">Book This Room</h2>
                    <form method="POST" action="{{ route('bookings.store') }}">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">

                        <div class="mb-4">
                            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Meeting Title</label>
                            <input type="text" name="title" id="title" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="participants" class="block text-gray-700 text-sm font-bold mb-2">Participants (Optional)</label>
                            <textarea name="participants" id="participants" rows="3" placeholder="john@example.com&#10;jane@example.com"
                                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="start_time" class="block text-gray-700 text-sm font-bold mb-2">Start Time</label>
                            <input type="datetime-local" name="start_time" id="start_time" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="mb-4">
                            <label for="end_time" class="block text-gray-700 text-sm font-bold mb-2">End Time</label>
                            <input type="datetime-local" name="end_time" id="end_time" required
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Book Room
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection