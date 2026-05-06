@extends('layouts.app')
@section('title', 'Kelola Ruangan')
@section('page-title', 'Kelola Ruangan')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">
    <div class="flex justify-end">
        <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Ruangan
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 stagger-children">
        @forelse($rooms as $room)
        <div class="gaming-card p-5 animate-fade-in">
            <div class="flex items-start justify-between mb-3">
                <div class="min-w-0">
                    <h3 class="font-gaming font-semibold truncate" style="color:var(--text-primary);">{{ $room->name }}</h3>
                    <p class="text-xs mt-0.5" style="color:var(--text-muted);">📍 {{ $room->location ?? '-' }}</p>
                </div>
                <span class="badge {{ $room->is_active ? 'badge-green' : 'badge-red' }} flex-shrink-0">
                    {{ $room->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <div class="flex items-center gap-2 mb-3 p-2 rounded-lg" style="background:var(--bg-surface-2);">
                <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-sm font-medium" style="color:var(--text-primary);">{{ $room->capacity }} orang</span>
            </div>
            @if($room->facilities && count($room->facilities) > 0)
            <div class="flex flex-wrap gap-1.5 mb-3">
                @foreach($room->facilities as $f)
                    <span class="badge badge-cyan">{{ $f }}</span>
                @endforeach
            </div>
            @endif
            @if($room->description)
            <p class="text-xs mb-3 line-clamp-2" style="color:var(--text-muted);">{{ $room->description }}</p>
            @endif
            <div class="flex gap-2 pt-3" style="border-top:1px solid var(--border-color);">
                <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-secondary btn-sm flex-1">Edit</a>
                <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" onsubmit="return confirm('Hapus ruangan ini?')" class="flex-1">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm w-full">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-3 gaming-card p-8 text-center">
            <svg class="w-12 h-12 mx-auto mb-3" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <p style="color:var(--text-muted);">Belum ada ruangan.</p>
        </div>
        @endforelse
    </div>
    @if($rooms->hasPages())
    <div class="gaming-card p-4">{{ $rooms->links() }}</div>
    @endif
</div>
@endsection
