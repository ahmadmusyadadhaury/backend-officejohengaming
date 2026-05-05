@extends('layouts.app')
@section('title', 'Detail Meeting')
@section('page-title', 'Detail Meeting')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-3xl space-y-4">
    @php
        $statusColors = [
            'pending'     => 'bg-yellow-100 text-yellow-700',
            'approved'    => 'bg-blue-100 text-blue-700',
            'rejected'    => 'bg-red-100 text-red-700',
            'confirmed'   => 'bg-indigo-100 text-indigo-700',
            'cancelled'   => 'bg-gray-100 text-gray-600',
            'in_progress' => 'bg-purple-100 text-purple-700',
            'completed'   => 'bg-green-100 text-green-700',
        ];
    @endphp

    {{-- Info Utama --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-bold text-primary">{{ $meeting->title }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $meeting->team->name }}
                    @foreach($meeting->teams as $t) + {{ $t->name }} @endforeach
                </p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$meeting->status] ?? '' }}">
                    {{ ucfirst($meeting->status) }}
                </span>
                @if($meeting->queue_position !== null)
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ \App\Services\MeetingQueueService::queueColor($meeting->queue_position) }}">
                        {{ \App\Services\MeetingQueueService::queueLabel($meeting->queue_position) }}
                    </span>
                @endif
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-gray-100">
            <div><p class="text-xs text-gray-400">Tanggal</p><p class="text-sm font-medium">{{ $meeting->meeting_date->format('d M Y') }}</p></div>
            <div>
                <p class="text-xs text-gray-400">Waktu</p>
                <p class="text-sm font-medium">
                    {{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}
                    @if($meeting->actual_end_time)
                        <span class="text-xs text-green-600">(Selesai {{ substr($meeting->actual_end_time,0,5) }})</span>
                    @endif
                </p>
            </div>
            <div><p class="text-xs text-gray-400">Ruangan</p><p class="text-sm font-medium">{{ $meeting->room->name }}</p></div>
        </div>
    </div>

    {{-- APPROVED: Konfirmasi + Selesaikan --}}
    @if($meeting->status === 'approved')
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-5">
        <p class="text-sm font-semibold text-blue-800 mb-3">Meeting disetujui! Pilih tindakan:</p>
        <div class="flex flex-wrap gap-2">
            <form method="POST" action="{{ route('koordinator.meetings.confirm', $meeting) }}">
                @csrf @method('PATCH')
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700 transition">✓ Konfirmasi Hadir</button>
            </form>
            <form method="POST" action="{{ route('koordinator.meetings.finish', $meeting) }}"
                class="flex items-center gap-2" onsubmit="return confirm('Selesaikan meeting sekarang?')">
                @csrf @method('PATCH')
                <input type="time" name="actual_end_time" value="{{ now()->format('H:i') }}"
                    class="px-2 py-2 border border-blue-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">
                    ✓ Selesaikan Meeting
                </button>
            </form>
            <form method="POST" action="{{ route('koordinator.meetings.cancel', $meeting) }}"
                onsubmit="return confirm('Batalkan meeting ini?')">
                @csrf @method('PATCH')
                <button class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600 transition">✗ Batalkan</button>
            </form>
        </div>
    </div>
    @endif

    {{-- CONFIRMED: Selesaikan --}}
    @if($meeting->status === 'confirmed')
    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-5">
        <p class="text-sm font-semibold text-indigo-800 mb-3">Meeting terkonfirmasi. Selesaikan jika meeting sudah berakhir.</p>
        <form method="POST" action="{{ route('koordinator.meetings.finish', $meeting) }}"
            class="flex flex-wrap items-center gap-2" onsubmit="return confirm('Selesaikan meeting sekarang?')">
            @csrf @method('PATCH')
            <div>
                <label class="block text-xs text-indigo-600 mb-1">Jam selesai aktual</label>
                <input type="time" name="actual_end_time" value="{{ now()->format('H:i') }}"
                    class="px-3 py-2 border border-indigo-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>
            <button class="px-5 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition mt-4">
                ✓ Selesaikan Meeting
            </button>
            <form method="POST" action="{{ route('koordinator.meetings.cancel', $meeting) }}"
                onsubmit="return confirm('Batalkan meeting ini?')" class="mt-4">
                @csrf @method('PATCH')
                <button class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600 transition">✗ Batalkan</button>
            </form>
        </form>
    </div>
    @endif

    {{-- REJECTED --}}
    @if($meeting->status === 'rejected')
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <p class="text-sm font-semibold text-red-700">Meeting ditolak</p>
        <p class="text-sm text-red-600 mt-1">{{ $meeting->reject_reason }}</p>
    </div>
    @endif

    {{-- CANCELLED --}}
    @if($meeting->status === 'cancelled')
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
        <p class="text-sm font-semibold text-gray-600">Meeting telah dibatalkan.</p>
    </div>
    @endif

    {{-- COMPLETED: MOM --}}
    @if($meeting->status === 'completed')
    <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3">
        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm font-semibold text-green-700">Meeting telah selesai.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-primary text-sm">Minutes of Meeting (MOM)</h3>
            @if(!$meeting->mom)
                <a href="{{ route('koordinator.meetings.mom.create', $meeting) }}"
                    class="px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">+ Buat MOM</a>
            @endif
        </div>
        @if($meeting->mom)
            <div class="space-y-2 text-sm">
                <p><span class="font-medium text-gray-600">Status:</span>
                    <span class="px-2 py-0.5 rounded-full text-xs {{ $meeting->mom->status === 'sent' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($meeting->mom->status) }}
                    </span>
                </p>
                <p><span class="font-medium text-gray-600">PIC:</span> {{ $meeting->mom->pic }}</p>
                @if($meeting->mom->status === 'draft')
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('koordinator.mom.edit', $meeting->mom) }}"
                            class="px-3 py-1.5 bg-secondary/10 text-secondary rounded text-xs hover:bg-secondary hover:text-white transition">Edit MOM</a>
                        <form method="POST" action="{{ route('koordinator.mom.send', $meeting->mom) }}">
                            @csrf @method('PATCH')
                            <button class="px-3 py-1.5 bg-green-600 text-white rounded text-xs hover:bg-green-700 transition">Kirim MOM</button>
                        </form>
                    </div>
                @endif
            </div>
        @else
            <p class="text-sm text-gray-400">Belum ada MOM. Buat MOM setelah meeting selesai (maks H+1).</p>
        @endif
    </div>
    @endif

    <a href="{{ route('koordinator.meetings.index') }}" class="inline-block text-sm text-gray-500 hover:text-primary">← Kembali</a>
</div>
@endsection
