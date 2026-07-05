@extends('layouts.app')
@section('title', 'Booking Saya')
@section('page-title', 'Booking Saya')
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
    @if($bookings->count() > 0)
    <div class="space-y-3 stagger-children">
        @foreach($bookings as $booking)
        @php
            $sc = match($booking->status) {
                'approved'  => 'badge-green',
                'pending'   => 'badge-yellow',
                'cancelled' => 'badge-red',
                default     => 'badge-gray',
            };
        @endphp
        <div class="gaming-card p-5 animate-fade-in">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <h3 class="font-gaming font-semibold" style="color:var(--text-primary);">{{ $booking->title }}</h3>
                    <p class="text-sm mt-0.5" style="color:var(--text-muted);">{{ $booking->room->name }}</p>
                    <p class="text-sm" style="color:var(--text-muted);">
                        {{ $booking->start_time->format('d M Y H:i') }} – {{ $booking->end_time->format('H:i') }}
                    </p>
                    @if($booking->description)
                        <p class="text-sm mt-1" style="color:var(--text-muted);">{{ $booking->description }}</p>
                    @endif
                    <span class="badge {{ $sc }} mt-2 inline-flex">{{ ucfirst($booking->status) }}</span>
                </div>
                <div class="flex gap-2 flex-shrink-0">
                    <a href="{{ route('bookings.show', $booking) }}" class="btn btn-secondary btn-sm">Detail</a>
                    @if($booking->status !== 'cancelled')
                    <form method="POST" action="{{ route('bookings.destroy', $booking) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Batalkan booking ini?">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Batal</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="gaming-card p-10 text-center">
        <svg class="w-12 h-12 mx-auto mb-3" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="mb-4" style="color:var(--text-muted);">Belum ada booking.</p>
        <a href="{{ route('rooms.index') }}" class="btn btn-primary btn-sm">Lihat Ruangan</a>
    </div>
    @endif
</div>
@endsection
