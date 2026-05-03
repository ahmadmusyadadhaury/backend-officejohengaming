@extends('layouts.app')
@section('title', 'Detail Meeting')
@section('page-title', 'Detail Meeting')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2 max-w-3xl space-y-4">
    @php $statusColors = ['pending'=>'bg-yellow-100 text-yellow-700','approved'=>'bg-blue-100 text-blue-700','rejected'=>'bg-red-100 text-red-700','confirmed'=>'bg-indigo-100 text-indigo-700','cancelled'=>'bg-gray-100 text-gray-600','in_progress'=>'bg-purple-100 text-purple-700','completed'=>'bg-green-100 text-green-700']; @endphp

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-bold text-primary">{{ $meeting->title }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $meeting->team->name }} @if($meeting->secondTeam) + {{ $meeting->secondTeam->name }} @endif</p>
            </div>
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$meeting->status] ?? '' }}">{{ ucfirst($meeting->status) }}</span>
        </div>
        <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-gray-100">
            <div><p class="text-xs text-gray-400">Tanggal</p><p class="text-sm font-medium">{{ $meeting->meeting_date->format('d M Y') }}</p></div>
            <div><p class="text-xs text-gray-400">Waktu</p><p class="text-sm font-medium">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}</p></div>
            <div><p class="text-xs text-gray-400">Ruangan</p><p class="text-sm font-medium">{{ $meeting->room->name }}</p></div>
        </div>
    </div>

    {{-- Aksi berdasarkan status --}}
    @if($meeting->status === 'approved')
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold text-blue-800">Meeting disetujui! Konfirmasi kehadiran kamu.</p>
            <p class="text-xs text-blue-600 mt-0.5">Konfirmasi bahwa kamu akan hadir atau batalkan meeting.</p>
        </div>
        <div class="flex gap-2">
            <form method="POST" action="{{ route('leader.meetings.confirm', $meeting) }}">
                @csrf @method('PATCH')
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">✓ Hadir</button>
            </form>
            <form method="POST" action="{{ route('leader.meetings.cancel', $meeting) }}">
                @csrf @method('PATCH')
                <button class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600 transition">✗ Batalkan</button>
            </form>
        </div>
    </div>
    @endif

    @if($meeting->status === 'confirmed')
    <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 flex items-center justify-between">
        <p class="text-sm font-semibold text-indigo-800">Meeting terkonfirmasi. Selesaikan meeting jika sudah selesai.</p>
        <form method="POST" action="{{ route('leader.meetings.finish', $meeting) }}" class="flex items-center gap-2">
            @csrf @method('PATCH')
            <input type="time" name="actual_end_time" class="px-2 py-1 border border-indigo-300 rounded text-sm">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700 transition">Selesaikan</button>
        </form>
    </div>
    @endif

    @if($meeting->status === 'rejected')
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <p class="text-sm font-semibold text-red-700">Meeting ditolak</p>
        <p class="text-sm text-red-600 mt-1">{{ $meeting->reject_reason }}</p>
    </div>
    @endif

    {{-- MOM --}}
    @if($meeting->status === 'completed')
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-semibold text-primary text-sm">Minutes of Meeting (MOM)</h3>
            @if(!$meeting->mom)
                <a href="{{ route('leader.meetings.mom.create', $meeting) }}" class="px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">+ Buat MOM</a>
            @endif
        </div>
        @if($meeting->mom)
            <div class="space-y-2 text-sm">
                <p><span class="font-medium text-gray-600">Status:</span>
                    <span class="px-2 py-0.5 rounded-full text-xs {{ $meeting->mom->status === 'sent' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($meeting->mom->status) }}</span>
                </p>
                <p><span class="font-medium text-gray-600">PIC:</span> {{ $meeting->mom->pic }}</p>
                @if($meeting->mom->status === 'draft')
                    <div class="flex gap-2 mt-3">
                        <a href="{{ route('leader.mom.edit', $meeting->mom) }}" class="px-3 py-1.5 bg-secondary/10 text-secondary rounded text-xs hover:bg-secondary hover:text-white transition">Edit MOM</a>
                        <form method="POST" action="{{ route('leader.mom.send', $meeting->mom) }}">
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

    <a href="{{ route('leader.meetings.index') }}" class="inline-block text-sm text-gray-500 hover:text-primary">← Kembali</a>
</div>
@endsection
