@extends('layouts.app')
@section('title', 'Detail Permintaan Override')
@section('page-title', 'Detail Permintaan Override')
@section('sidebar-menu')
    @if(auth()->user()->role === 'admin' || in_array(auth()->user()->role, \App\Models\User::FULL_ACCESS_ROLES))
        @include('partials.sidebar-admin')
    @elseif(in_array(auth()->user()->role, ['koordinator']))
        @include('partials.sidebar-leader')
    @else
        @include('partials.sidebar-user')
    @endif
@endsection
@section('content')
<div class="pt-2 max-w-3xl space-y-4 animate-fade-in">

    @if(session('success'))
    <div class="p-4 rounded-xl text-sm font-semibold" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#34d399;">
        {{ session('success') }}
    </div>
    @endif

    {{-- Status --}}
    @php
        $statusBadge = match($override->status) {
            'pending' => 'badge-yellow',
            'accepted' => 'badge-green',
            'rejected' => 'badge-red',
            default => 'badge-gray'
        };
        $statusLabel = match($override->status) {
            'pending' => 'Menunggu',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
        };
    @endphp

    <div class="gaming-card p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-gaming font-bold text-xl" style="color:var(--text-primary);">Permintaan Override</h2>
                <p class="text-sm mt-1" style="color:var(--text-muted);">
                    Diajukan oleh: <strong style="color:var(--color-accent-light);">{{ $override->requesterMeeting->requester->name }}</strong>
                    (Tim {{ $override->requesterMeeting->team->name }})
                </p>
            </div>
            <span class="badge {{ $statusBadge }} flex-shrink-0">{{ $statusLabel }}</span>
        </div>
    </div>

    {{-- Target Meeting (the one being overridden) --}}
    <div class="gaming-card p-6" style="border-color:rgba(239,68,68,0.2);">
        <h3 class="font-gaming font-semibold mb-3" style="color:#f87171;letter-spacing:0.05em;">BOOKING YANG AKAN DIGANTIKAN</h3>
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="font-semibold" style="color:var(--text-primary);">{{ $override->targetMeeting->title }}</p>
                <p class="text-sm mt-1" style="color:var(--text-muted);">
                    Oleh: {{ $override->targetMeeting->requester->name }} · Tim {{ $override->targetMeeting->team->name }}
                </p>
            </div>
            @php $ts = match($override->targetMeeting->status) {'approved'=>'badge-blue','confirmed'=>'badge-primary','cancelled'=>'badge-gray','in_progress'=>'badge-primary','completed'=>'badge-green',default=>'badge-gray'}; @endphp
            <span class="badge {{ $ts }} flex-shrink-0">{{ ucfirst($override->targetMeeting->status) }}</span>
        </div>
        <div class="grid grid-cols-3 gap-3 mt-3 pt-3" style="border-top:1px solid var(--border-color);">
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Tanggal</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $override->targetMeeting->meeting_date->format('d M Y') }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ substr($override->targetMeeting->start_time,0,5) }} – {{ substr($override->targetMeeting->end_time,0,5) }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Ruangan</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $override->targetMeeting->room->name }}</p>
            </div>
        </div>
    </div>

    {{-- Requester Meeting --}}
    <div class="gaming-card p-6" style="border-color:rgba(59,130,246,0.2);">
        <h3 class="font-gaming font-semibold mb-3" style="color:#60a5fa;letter-spacing:0.05em;">BOOKING PENGGANTI</h3>
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="font-semibold" style="color:var(--text-primary);">{{ $override->requesterMeeting->title }}</p>
                <p class="text-sm mt-1" style="color:var(--text-muted);">
                    Oleh: {{ $override->requesterMeeting->requester->name }} · Tim {{ $override->requesterMeeting->team->name }}
                </p>
            </div>
            @php $rs = match($override->requesterMeeting->status) {'pending'=>'badge-yellow','approved'=>'badge-blue','rejected'=>'badge-red',default=>'badge-gray'}; @endphp
            <span class="badge {{ $rs }} flex-shrink-0">{{ ucfirst($override->requesterMeeting->status) }}</span>
        </div>
        <div class="grid grid-cols-3 gap-3 mt-3 pt-3" style="border-top:1px solid var(--border-color);">
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Tanggal</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $override->requesterMeeting->meeting_date->format('d M Y') }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ substr($override->requesterMeeting->start_time,0,5) }} – {{ substr($override->requesterMeeting->end_time,0,5) }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Ruangan</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $override->requesterMeeting->room->name }}</p>
            </div>
        </div>
    </div>

    {{-- Reason --}}
    <div class="gaming-card p-6">
        <h3 class="font-gaming font-semibold mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">ALASAN OVERRIDE</h3>
        <div class="p-4 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
            <p class="text-sm" style="color:var(--text-secondary);">{{ $override->reason }}</p>
        </div>
    </div>

    {{-- Accept/Reject Buttons (only for target meeting owner) --}}
    @if($canRespond)
    <div class="gaming-card p-6" style="border-color:rgba(245,158,11,0.3);background:rgba(245,158,11,0.05);">
        <h3 class="font-gaming font-semibold mb-3" style="color:#f59e0b;letter-spacing:0.05em;">TINDAKAN</h3>
        <p class="text-sm mb-4" style="color:var(--text-secondary);">
            Kamu memiliki booking di slot waktu ini. Jika kamu menyetujui override, booking kamu akan dibatalkan dan digantikan oleh pemohon.
        </p>
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="{{ route('override.accept', $override) }}" onsubmit="return confirm('Setujui override? Booking kamu akan dibatalkan.')">
                @csrf @method('PATCH')
                <button class="btn btn-success">✓ Setujui Override</button>
            </form>
            <form method="POST" action="{{ route('override.reject', $override) }}" onsubmit="return confirm('Tolak override?')">
                @csrf @method('PATCH')
                <button class="btn btn-danger">✗ Tolak Override</button>
            </form>
        </div>
    </div>
    @endif

    <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-sm" style="color:var(--text-muted);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>
@endsection
