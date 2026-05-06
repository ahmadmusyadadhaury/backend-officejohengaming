@extends('layouts.app')
@section('title', 'Undangan Meeting')
@section('page-title', 'Undangan Meeting')
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
<div class="pt-2 space-y-3 animate-fade-in stagger-children">
    @forelse($invitations as $inv)
    @php
        $sb = match($inv->meeting->status) {
            'approved'    => 'badge-blue',
            'confirmed'   => 'badge-primary',
            'in_progress' => 'badge-primary',
            'cancelled'   => 'badge-red',
            'rejected'    => 'badge-red',
            default       => 'badge-gray',
        };
    @endphp
    <a href="{{ route('invitation.show', $inv) }}"
        class="gaming-card p-5 flex items-start justify-between gap-3 animate-fade-in"
        style="display:flex;border-left:3px solid {{ !$inv->is_read ? 'var(--color-accent)' : 'transparent' }};">
        <div class="min-w-0">
            <div class="flex items-center gap-2 mb-1">
                @if(!$inv->is_read)
                    <span class="w-2 h-2 rounded-full flex-shrink-0 animate-glow-pulse" style="background:var(--color-accent);"></span>
                @endif
                <p class="font-gaming font-semibold truncate" style="color:var(--text-primary);">{{ $inv->meeting->title }}</p>
            </div>
            <p class="text-sm" style="color:var(--text-muted);">{{ $inv->meeting->team->name }} · {{ $inv->meeting->room->name }}</p>
            <p class="text-sm" style="color:var(--text-muted);">{{ $inv->meeting->meeting_date->isoFormat('ddd, D MMM Y') }} · {{ substr($inv->meeting->start_time,0,5) }} – {{ substr($inv->meeting->end_time,0,5) }}</p>
        </div>
        <span class="badge {{ $sb }} flex-shrink-0">{{ ucfirst($inv->meeting->status) }}</span>
    </a>
    @empty
    <div class="gaming-card p-10 text-center">
        <svg class="w-12 h-12 mx-auto mb-3" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        <p style="color:var(--text-muted);">Tidak ada undangan meeting aktif.</p>
    </div>
    @endforelse
</div>
@endsection
