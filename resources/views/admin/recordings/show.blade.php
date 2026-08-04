@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Detail Rekap Rapat')
@section('page-title', 'Detail Rekap Hasil Rangkuman Rapat')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-3xl animate-fade-in space-y-4">

    {{-- Info Meeting --}}
    <div class="gaming-card p-6">
        <div class="flex items-start justify-between gap-4">
            <div class="min-w-0">
                <h2 class="font-gaming font-bold text-xl" style="color:var(--text-primary);">{{ $recording->meeting->title ?? '—' }}</h2>
                <p class="text-sm mt-1" style="color:var(--text-muted);">
                    <span style="color:var(--color-accent-light);">{{ $recording->meeting->room->name ?? '—' }}</span>
                    · {{ $recording->meeting->meeting_date ? $recording->meeting->meeting_date->format('d M Y') : '—' }}
                    @if($recording->meeting->start_time)
                        · {{ substr($recording->meeting->start_time,0,5) }} – {{ substr($recording->meeting->end_time,0,5) }}
                    @endif
                </p>
            </div>
            <span class="badge {{ $recording->status === 'finalized' ? 'badge-green' : 'badge-yellow' }}">{{ ucfirst($recording->status) }}</span>
        </div>
        <div class="grid grid-cols-3 gap-3 mt-4 pt-4" style="border-top:1px solid var(--border-color);">
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Durasi</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);font-family:monospace;">{{ $recording->duration_formatted }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Dibuat Oleh</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $recording->creator->name ?? '—' }}</p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Tanggal Rekaman</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $recording->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- Audio Player --}}
    @if($recording->audio_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($recording->audio_path))
    <div class="gaming-card p-5">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-4 h-4" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M9 10a1 1 0 011-1h1a1 1 0 011 1v4a1 1 0 01-1 1h-1a1 1 0 01-1-1v-4zM5.636 15.364A9 9 0 015 12a9 9 0 01.636-3.364"/></svg>
            <span class="text-xs font-bold" style="color:#f87171;">REKAMAN AUDIO</span>
        </div>
        <audio controls style="width:100%;height:40px;border-radius:10px;">
            <source src="{{ Storage::disk('public')->url($recording->audio_path) }}" type="audio/webm">
            Browser Anda tidak mendukung audio player.
        </audio>
    </div>
    @endif

    {{-- Transcript --}}
    @if($recording->transcript)
    <div class="gaming-card p-5">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-4 h-4" style="color:#60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span class="text-xs font-bold" style="color:#60a5fa;">TRANSKRIP OTOMATIS</span>
        </div>
        <div class="p-4 rounded-xl text-sm whitespace-pre-wrap" style="background:var(--bg-surface-2);border:1px solid var(--border-color);color:var(--text-secondary);line-height:1.8;font-size:0.8rem;">
            {{ $recording->transcript }}
        </div>
    </div>
    @endif

    {{-- Summary / Rekap --}}
    @if($recording->summary)
    <div class="gaming-card p-5">
        <div class="flex items-center gap-2 mb-3">
            <svg class="w-4 h-4" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-xs font-bold" style="color:#10b981;">REKAP RAPAT</span>
        </div>
        <div class="p-4 rounded-xl text-sm whitespace-pre-wrap" style="background:rgba(16,185,129,0.05);border:1px solid rgba(16,185,129,0.2);color:var(--text-primary);line-height:1.8;font-size:0.8rem;">
            {{ $recording->summary }}
        </div>
    </div>
    @endif

    {{-- Aksi --}}
    <div class="flex gap-3">
        @if($recording->status === 'draft')
            <form method="POST" action="{{ route('admin.recordings.update', $recording) }}">
                @csrf @method('PUT')
                <input type="hidden" name="action" value="finalize">
                <input type="hidden" name="summary" value="{{ $recording->summary }}">
                <input type="hidden" name="transcript" value="{{ $recording->transcript }}">
                <button class="btn btn-success btn-sm inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Finalisasi
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('admin.recordings.update', $recording) }}">
                @csrf @method('PUT')
                <input type="hidden" name="action" value="unfinalize">
                <input type="hidden" name="summary" value="{{ $recording->summary }}">
                <input type="hidden" name="transcript" value="{{ $recording->transcript }}">
                <button class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Buka Kembali (Draft)
                </button>
            </form>
        @endif
        <a href="{{ route('admin.recordings.edit', $recording) }}" class="btn btn-primary btn-sm inline-flex items-center gap-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Rekap
        </a>
        <form method="POST" action="{{ route('admin.recordings.destroy', $recording) }}" onsubmit="return confirm('Hapus rekaman ini secara permanen?')">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus
            </button>
        </form>
        <a href="{{ route('admin.recordings.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
</div>
@endsection
