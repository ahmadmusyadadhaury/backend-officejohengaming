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
<div class="pt-2 max-w-2xl animate-fade-in">

    {{-- Status Banner --}}
    @if(in_array($meeting->status, ['cancelled', 'rejected']))
    <div class="mb-4 p-4 rounded-xl flex items-center gap-3" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold" style="color:#f87171;">
                Meeting ini telah {{ $meeting->status === 'cancelled' ? 'dibatalkan' : 'ditolak' }}
            </p>
            @if($meeting->reject_reason)
                <p class="text-xs mt-0.5" style="color:#fca5a5;">Alasan: {{ $meeting->reject_reason }}</p>
            @endif
        </div>
    </div>
    @endif

    {{-- Card Undangan --}}
    <div class="gaming-card overflow-hidden">
        {{-- Header --}}
        <div class="p-6 relative" style="background:linear-gradient(135deg,var(--color-primary-dark),var(--color-accent));">
            <div class="absolute inset-0 grid-pattern opacity-20"></div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4" style="color:rgba(255,255,255,0.6);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span style="color:rgba(255,255,255,0.6);font-size:0.8rem;">Undangan Meeting</span>
                </div>
                <h2 class="font-gaming font-bold text-xl text-white">{{ $meeting->title }}</h2>
                <p class="text-sm mt-1" style="color:rgba(255,255,255,0.7);">
                    Dari: {{ $meeting->requester->name }} · <span style="color:var(--color-neon-blue);">{{ $meeting->team->name }}</span>
                    @if($meeting->teams->count())
                        @foreach($meeting->teams as $t) + {{ $t->name }} @endforeach
                    @endif
                </p>
            </div>
        </div>

        {{-- Info Waktu & Tempat --}}
        <div class="grid grid-cols-3 gap-3 p-4" style="background:var(--bg-surface-2);border-bottom:1px solid var(--border-color);">
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Tanggal</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $meeting->meeting_date->isoFormat('ddd, D MMM Y') }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Ruangan</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $meeting->room->name }}</p>
            </div>
        </div>

        {{-- Detail 5W1H --}}
        <div class="p-6 space-y-4">
            @foreach(['why'=>'WHY — Kenapa meeting ini diadakan?','what'=>'WHAT — Apa yang akan dibahas?','how_expected'=>'HOW — Hasil yang diharapkan'] as $field => $label)
            @if($meeting->$field)
            <div>
                <p class="gaming-label">{{ $label }}</p>
                <p class="text-sm p-3 rounded-lg" style="color:var(--text-secondary);background:var(--bg-surface-2);border:1px solid var(--border-color);">{{ $meeting->$field }}</p>
            </div>
            @endif
            @endforeach
        </div>

        {{-- File Lampiran --}}
        @if($meeting->file_path)
        <div class="px-6 pb-5">
            <p class="gaming-label">File Lampiran</p>
            <a href="{{ route('files.show', $meeting->file_path) }}" target="_blank" class="btn btn-secondary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Lihat / Download File
            </a>
        </div>
        @endif

        {{-- Footer --}}
        <div class="px-6 py-4 flex items-center justify-between" style="border-top:1px solid var(--border-color);background:var(--bg-surface-2);">
            <p class="text-xs" style="color:var(--text-muted);">
                @if($invitation->read_at) Dibaca {{ $invitation->read_at->format('d M Y H:i') }} @endif
            </p>
            @php
                $sb = match($meeting->status) {
                    'approved'=>'badge-blue','confirmed'=>'badge-primary',
                    'in_progress'=>'badge-primary','completed'=>'badge-green',
                    'cancelled'=>'badge-red','rejected'=>'badge-red',default=>'badge-gray'
                };
            @endphp
            <span class="badge {{ $sb }}">{{ ucfirst($meeting->status) }}</span>
        </div>
    </div>

</div>
@endsection
