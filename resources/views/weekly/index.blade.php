@extends('layouts.app')
@section('title', 'Undangan Meeting Mingguan')
@section('page-title', 'Meeting Mingguan')
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
    <a href="{{ route('weekly.show', $inv) }}"
        class="gaming-card p-5 flex items-start justify-between gap-3 animate-fade-in"
        style="display:flex;border-left:3px solid {{ !$inv->is_read ? 'var(--color-neon-blue)' : 'transparent' }};">
        <div class="min-w-0">
            <div class="flex items-center gap-2 mb-1">
                @if(!$inv->is_read)
                    <span class="w-2 h-2 rounded-full flex-shrink-0 animate-glow-pulse" style="background:var(--color-neon-blue);"></span>
                @endif
                <p class="font-gaming font-semibold truncate" style="color:var(--text-primary);">🔁 {{ $inv->session->weeklyMeeting->title }}</p>
            </div>
            <p class="text-sm" style="color:var(--text-muted);">{{ $inv->session->weeklyMeeting->room->name }}</p>
            <p class="text-sm" style="color:var(--text-muted);">
                {{ $inv->session->session_date->isoFormat('ddd, D MMM Y') }}
                · {{ substr($inv->session->start_time,0,5) }} – {{ substr($inv->session->end_time,0,5) }}
            </p>
        </div>
        @php
            $sc = match($inv->session->status) {
                'active'    => 'badge-green',
                'extended'  => 'badge-yellow',
                'completed' => 'badge-gray',
                default     => 'badge-cyan',
            };
        @endphp
        <span class="badge {{ $sc }} flex-shrink-0">{{ ucfirst($inv->session->status) }}</span>
    </a>
    @empty
    <div class="gaming-card p-10 text-center">
        <svg class="w-12 h-12 mx-auto mb-3" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        <p style="color:var(--text-muted);">Tidak ada undangan meeting mingguan aktif.</p>
    </div>
    @endforelse
</div>
@endsection
