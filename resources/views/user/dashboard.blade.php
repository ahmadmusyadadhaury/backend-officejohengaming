@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)
@section('sidebar-menu') @include('partials.sidebar-user') @endsection

@section('content')
<div class="space-y-5 pt-2 stagger-children">

    {{-- Profile Banner --}}
    <div class="gaming-card p-5 relative overflow-hidden"
        style="background:linear-gradient(135deg,var(--color-primary-dark),var(--color-primary));">
        <div class="absolute inset-0 grid-pattern opacity-20"></div>
        <div class="relative flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center font-gaming font-bold text-xl flex-shrink-0"
                style="background:linear-gradient(135deg,var(--color-accent),var(--color-neon-blue));color:white;box-shadow:0 4px 16px rgba(124,58,237,0.4);">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="font-gaming font-bold text-xl text-white tracking-wide">{{ auth()->user()->name }}</h2>
                <div class="flex items-center gap-2 mt-1 flex-wrap">
                    <span class="badge badge-cyan">{{ auth()->user()->role_label }}</span>
                    @if(auth()->user()->team)
                        <span class="badge badge-blue">{{ auth()->user()->team->name }}</span>
                    @endif
                    <span style="color:rgba(255,255,255,0.5);font-size:0.7rem;">NIK: {{ auth()->user()->username }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        {{-- Meeting Saya --}}
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">MEETING SAYA</h3>
                <a href="{{ route('calendar') }}" class="badge badge-primary">Kalender</a>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                @forelse($myMeetings as $meeting)
                <div class="px-5 py-3 transition"
                    onmouseover="this.style.background='rgba(124,58,237,0.04)'"
                    onmouseout="this.style.background='transparent'">
                    <p class="text-sm font-medium" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                    <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $meeting->room->name }} · {{ $meeting->meeting_date->format('d M Y') }}</p>
                    <p class="text-xs" style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}</p>
                    <p class="text-xs mt-0.5" style="color:var(--text-muted);">Oleh: {{ $meeting->requester->name }}</p>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Kamu belum diundang ke meeting apapun</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Meeting Hari Ini --}}
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">MEETING HARI INI</h3>
                <span class="badge badge-blue">{{ today()->isoFormat('D MMM') }}</span>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                @forelse($todayMeetings as $meeting)
                <div class="px-5 py-3 transition"
                    onmouseover="this.style.background='rgba(124,58,237,0.04)'"
                    onmouseout="this.style.background='transparent'">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full flex-shrink-0"
                            style="background:{{ $meeting->status === 'in_progress' ? 'var(--color-accent)' : 'var(--color-secondary)' }};
                                   box-shadow:0 0 6px {{ $meeting->status === 'in_progress' ? 'rgba(124,58,237,0.8)' : 'rgba(59,130,246,0.6)' }};
                                   {{ $meeting->status === 'in_progress' ? 'animation:glowPulse 2s ease-in-out infinite;' : '' }}"></span>
                        <p class="text-sm font-medium" style="color:var(--text-primary);">{{ $meeting->title }}</p>
                    </div>
                    <p class="text-xs ml-4" style="color:var(--text-muted);">{{ $meeting->team->name }} · {{ $meeting->room->name }}</p>
                    <p class="text-xs ml-4" style="color:var(--text-muted);">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}</p>
                </div>
                @empty
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Tidak ada meeting hari ini</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
