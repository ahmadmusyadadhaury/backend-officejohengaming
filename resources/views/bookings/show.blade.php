@extends('layouts.app')
@section('title', 'Detail Booking')
@section('page-title', 'Detail Booking')
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
<div class="pt-2 max-w-2xl animate-fade-in space-y-4">

    <div class="gaming-card overflow-hidden">
        {{-- Header --}}
        <div class="p-5 relative" style="background:linear-gradient(135deg,var(--color-primary-dark),var(--color-accent));">
            <div class="absolute inset-0 grid-pattern opacity-20"></div>
            <div class="relative flex items-start justify-between gap-3">
                <div>
                    <h2 class="font-gaming font-bold text-xl text-white">{{ $booking->title }}</h2>
                    <p class="text-sm mt-1" style="color:rgba(255,255,255,0.7);">{{ $booking->room->name }}</p>
                </div>
                @php
                    $sc = match($booking->status) {
                        'approved'  => 'badge-green',
                        'pending'   => 'badge-yellow',
                        'cancelled' => 'badge-red',
                        default     => 'badge-gray',
                    };
                @endphp
                <span class="badge {{ $sc }} flex-shrink-0">{{ ucfirst($booking->status) }}</span>
            </div>
        </div>

        {{-- Detail --}}
        <div class="p-5">
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="gaming-card-flat p-3">
                    <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu Mulai</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $booking->start_time->format('d M Y H:i') }}</p>
                </div>
                <div class="gaming-card-flat p-3">
                    <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu Selesai</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $booking->end_time->format('d M Y H:i') }}</p>
                </div>
                <div class="gaming-card-flat p-3">
                    <p class="text-xs mb-1" style="color:var(--text-muted);">Kapasitas</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $booking->room->capacity }} orang</p>
                </div>
                @if($booking->room->location)
                <div class="gaming-card-flat p-3">
                    <p class="text-xs mb-1" style="color:var(--text-muted);">Lokasi</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $booking->room->location }}</p>
                </div>
                @endif
            </div>
            @if($booking->description)
            <div class="p-3 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Deskripsi</p>
                <p class="text-sm" style="color:var(--text-secondary);">{{ $booking->description }}</p>
            </div>
            @endif
        </div>
    </div>

    <a href="{{ route('bookings.index') }}" class="inline-flex items-center gap-1.5 text-sm" style="color:var(--text-muted);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Booking Saya
    </a>
</div>
@endsection
