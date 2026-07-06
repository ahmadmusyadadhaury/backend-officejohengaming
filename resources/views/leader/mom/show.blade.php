@extends('layouts.app')
@section('title', 'Detail MOM')
@section('page-title', 'Minutes of Meeting')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-2xl space-y-4 animate-fade-in">
    <div class="gaming-card overflow-hidden">
        {{-- Header --}}
        <div class="p-5" style="background:linear-gradient(135deg,var(--color-primary-dark),var(--color-accent));position:relative;">
            <div class="absolute inset-0 grid-pattern opacity-20"></div>
            <div class="relative flex items-start justify-between gap-3">
                <div>
                    <h2 class="font-gaming font-bold text-lg text-white">{{ $mom->meeting->title }}</h2>
                    <p class="text-sm mt-1" style="color:rgba(255,255,255,0.7);">{{ $mom->meeting->meeting_date->format('d M Y') }} · {{ $mom->meeting->room->name }}</p>
                </div>
                <span class="badge {{ $mom->status === 'sent' ? 'badge-green' : 'badge-yellow' }} flex-shrink-0">
                    {{ $mom->status === 'sent' ? 'Terkirim' : 'Draft' }}
                </span>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-6 space-y-4">
            @foreach(['summary'=>'Ringkasan Pembahasan','decisions'=>'Keputusan','action_plan'=>'Action Plan'] as $field => $label)
            <div>
                <p class="gaming-label">{{ $label }}</p>
                <p class="text-sm p-3 rounded-lg" style="color:var(--text-secondary);background:var(--bg-surface-2);border:1px solid var(--border-color);">{{ $mom->$field }}</p>
            </div>
            @endforeach
            <div>
                <p class="gaming-label">Penanggung Jawab (PIC)</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $mom->pic }}</p>
            </div>
            @if($mom->file_path)
            <div>
                <p class="gaming-label">File Lampiran</p>
                <a href="{{ Storage::url($mom->file_path) }}" target="_blank" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download File
                </a>
            </div>
            @endif
            @if($mom->sent_at)
            <p class="text-xs" style="color:var(--text-muted);">Dikirim pada {{ $mom->sent_at->format('d M Y H:i') }}</p>
            @endif
        </div>

        @if($mom->status === 'draft')
        <div class="flex gap-3 px-6 pb-6 pt-2" style="border-top:1px solid var(--border-color);">
            <a href="{{ route('koordinator.mom.edit', $mom) }}" class="btn btn-secondary btn-sm">Edit MOM</a>
            <form method="POST" action="{{ route('koordinator.mom.send', $mom) }}">
                @csrf @method('PATCH')
                <button class="btn btn-success btn-sm">Kirim MOM</button>
            </form>
        </div>
        @endif
        <div class="flex gap-3 px-6 pb-6 pt-2" style="border-top:1px solid var(--border-color);">
            <a href="{{ route('mom.export', $mom->id) }}" class="btn btn-primary btn-sm inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export
            </a>
        </div>
    </div>

    <a href="{{ route('koordinator.meetings.show', $mom->meeting_id) }}" class="inline-flex items-center gap-1.5 text-sm" style="color:var(--text-muted);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Meeting
    </a>
</div>
@endsection
