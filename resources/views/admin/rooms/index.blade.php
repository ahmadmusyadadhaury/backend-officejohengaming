@extends('layouts.app')
@section('title', 'Kelola Ruangan')
@section('page-title', 'Kelola Ruangan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2">
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.rooms.create') }}" class="px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">+ Tambah Ruangan</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($rooms as $room)
        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-semibold text-primary">{{ $room->name }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $room->location ?? '-' }}</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $room->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $room->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-sm text-gray-600">Kapasitas: {{ $room->capacity }} orang</span>
            </div>
            @if($room->facilities)
            <div class="flex flex-wrap gap-1 mb-3">
                @foreach($room->facilities as $f)
                    <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-xs">{{ $f }}</span>
                @endforeach
            </div>
            @endif
            <div class="flex gap-2 pt-3 border-t border-gray-100">
                <a href="{{ route('admin.rooms.edit', $room) }}" class="flex-1 text-center px-3 py-1.5 bg-secondary/10 text-secondary rounded text-xs hover:bg-secondary hover:text-white transition">Edit</a>
                <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Hapus ruangan ini?')" class="flex-1">
                    @csrf @method('DELETE')
                    <button class="w-full px-3 py-1.5 bg-red-50 text-red-600 rounded text-xs hover:bg-red-600 hover:text-white transition">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-3 bg-white rounded-xl shadow-sm p-8 text-center text-gray-400">Belum ada ruangan.</div>
        @endforelse
    </div>
    <div class="mt-4">{{ $rooms->links() }}</div>
</div>
@endsection
