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
<div class="pt-2 max-w-2xl">

    {{-- Status Banner --}}
    @if(in_array($meeting->status, ['cancelled', 'rejected']))
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 flex items-center gap-3">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-red-700">
                    Meeting ini telah {{ $meeting->status === 'cancelled' ? 'dibatalkan' : 'ditolak' }}
                </p>
                @if($meeting->reject_reason)
                    <p class="text-xs text-red-600 mt-0.5">Alasan: {{ $meeting->reject_reason }}</p>
                @endif
            </div>
        </div>
    @endif

    {{-- Card Undangan --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        {{-- Header --}}
        <div class="bg-gradient-to-r from-primary to-accent p-6">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="text-white/70 text-sm">Undangan Meeting</span>
            </div>
            <h2 class="text-xl font-bold text-white">{{ $meeting->title }}</h2>
            <p class="text-blue-200 text-sm mt-1">
                Dari: {{ $meeting->requester->name }} · {{ $meeting->team->name }}
                @if($meeting->teams->count())
                    @foreach($meeting->teams as $t) + {{ $t->name }} @endforeach
                @endif
            </p>
        </div>

        {{-- Info Waktu & Tempat --}}
        <div class="grid grid-cols-3 gap-4 px-6 py-4 bg-gray-50 border-b border-gray-100">
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Tanggal</p>
                <p class="text-sm font-semibold text-primary">{{ $meeting->meeting_date->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Waktu</p>
                <p class="text-sm font-semibold text-primary">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }} WIB</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-0.5">Ruangan</p>
                <p class="text-sm font-semibold text-primary">{{ $meeting->room->name }}</p>
            </div>
        </div>

        {{-- Detail 5W1H --}}
        <div class="px-6 py-5 space-y-4">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">WHY — Kenapa meeting ini diadakan?</p>
                <p class="text-sm text-gray-700 bg-blue-50 rounded-lg p-3">{{ $meeting->why }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">WHAT — Apa yang akan dibahas?</p>
                <p class="text-sm text-gray-700 bg-blue-50 rounded-lg p-3">{{ $meeting->what }}</p>
            </div>
            @if($meeting->how_expected)
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">HOW — Hasil yang diharapkan</p>
                <p class="text-sm text-gray-700 bg-blue-50 rounded-lg p-3">{{ $meeting->how_expected }}</p>
            </div>
            @endif
        </div>

        {{-- File Lampiran --}}
        @if($meeting->file_path)
        <div class="px-6 pb-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">File Lampiran</p>
            <a href="{{ Storage::url($meeting->file_path) }}" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary/5 border border-primary/20 text-primary rounded-lg text-sm hover:bg-primary hover:text-white transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Lihat / Download File
            </a>
        </div>
        @endif

        {{-- Footer --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-400">
                @if($invitation->read_at)
                    Dibaca pada {{ $invitation->read_at->format('d M Y H:i') }}
                @endif
            </p>
            @php
                $statusColors = ['approved'=>'bg-blue-100 text-blue-700','confirmed'=>'bg-indigo-100 text-indigo-700','in_progress'=>'bg-purple-100 text-purple-700','completed'=>'bg-green-100 text-green-700','cancelled'=>'bg-red-100 text-red-700','rejected'=>'bg-red-100 text-red-700'];
            @endphp
            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$meeting->status] ?? 'bg-gray-100 text-gray-600' }}">
                {{ ucfirst($meeting->status) }}
            </span>
        </div>
    </div>

</div>
@endsection
