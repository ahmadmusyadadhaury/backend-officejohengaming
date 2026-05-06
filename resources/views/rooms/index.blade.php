@extends('layouts.app')
@section('title', 'Ruang Meeting')
@section('page-title', 'Ruang Meeting')
@section('page-subtitle', 'Pilih ruangan untuk booking')
@section('sidebar-menu')
    @if(auth()->user()->hasFullAccess())
        @include('partials.sidebar-admin')
    @elseif(auth()->user()->role === 'koordinator')
        @include('partials.sidebar-leader')
    @else
        @include('partials.sidebar-user')
    @endif
@endsection
@section('content')
<div class="pt-2 animate-fade-in">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 stagger-children">
        @forelse($rooms as $room)
        <div class="gaming-card p-5 animate-fade-in">
            <div class="flex items-start justify-between mb-3">
                <div class="min-w-0">
                    <h3 class="font-gaming font-semibold truncate" style="color:var(--text-primary);">{{ $room->name }}</h3>
                    @if($room->location)
                        <p class="text-xs mt-0.5" style="color:var(--text-muted);">📍 {{ $room->location }}</p>
                    @endif
                </div>
                <span class="badge badge-green flex-shrink-0">Aktif</span>
            </div>
            <div class="flex items-center gap-2 mb-3 p-2 rounded-lg" style="background:var(--bg-surface-2);">
                <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-sm font-medium" style="color:var(--text-primary);">{{ $room->capacity }} orang</span>
            </div>
            @if($room->description)
                <p class="text-xs mb-3 line-clamp-2" style="color:var(--text-muted);">{{ $room->description }}</p>
            @endif
            <a href="{{ route('rooms.show', $room) }}" class="btn btn-primary btn-sm w-full">Lihat Detail</a>
        </div>
        @empty
        <div class="col-span-3 gaming-card p-10 text-center">
            <p style="color:var(--text-muted);">Belum ada ruangan tersedia.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
