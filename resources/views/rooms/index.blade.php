@extends('layouts.app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-6">Available Meeting Rooms</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rooms as $room)
                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                        <h3 class="text-lg font-semibold mb-2">{{ $room->name }}</h3>
                        <p class="text-gray-600 mb-2">Capacity: {{ $room->capacity }} people</p>
                        @if($room->location)
                            <p class="text-gray-600 mb-2">Location: {{ $room->location }}</p>
                        @endif
                        @if($room->description)
                            <p class="text-gray-600 mb-4">{{ $room->description }}</p>
                        @endif
                        <a href="{{ route('rooms.show', $room) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            View Details
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection