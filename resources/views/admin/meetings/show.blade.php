@extends('layouts.app')
@section('title', 'Detail Meeting')
@section('page-title', 'Detail Permintaan Meeting')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 max-w-3xl space-y-4">

    {{-- Header Card --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-start justify-between">
            <div>
                <h2 class="text-xl font-bold text-primary">{{ $meeting->title }}</h2>
                <p class="text-sm text-gray-500 mt-1">Oleh: {{ $meeting->requester->name }} · {{ $meeting->team->name }}
                    @if($meeting->secondTeam) + {{ $meeting->secondTeam->name }} @endif
                </p>
            </div>
            @php
                $statusColors = ['pending'=>'bg-yellow-100 text-yellow-700','approved'=>'bg-blue-100 text-blue-700','rejected'=>'bg-red-100 text-red-700','confirmed'=>'bg-indigo-100 text-indigo-700','cancelled'=>'bg-gray-100 text-gray-600','in_progress'=>'bg-purple-100 text-purple-700','completed'=>'bg-green-100 text-green-700'];
            @endphp
            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$meeting->status] ?? '' }}">{{ ucfirst($meeting->status) }}</span>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-gray-100">
            <div><p class="text-xs text-gray-400">Tanggal</p><p class="text-sm font-medium">{{ $meeting->meeting_date->format('d M Y') }}</p></div>
            <div><p class="text-xs text-gray-400">Waktu</p><p class="text-sm font-medium">{{ substr($meeting->start_time,0,5) }} – {{ substr($meeting->end_time,0,5) }}</p></div>
            <div><p class="text-xs text-gray-400">Ruangan</p><p class="text-sm font-medium">{{ $meeting->room->name }}</p></div>
        </div>
    </div>

    {{-- 5W1H --}}
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-primary mb-4">Detail Meeting (5W1H)</h3>
        <div class="space-y-3">
            @foreach(['why'=>'WHY (Alasan)', 'what'=>'WHAT (Yang Dibahas)', 'where_detail'=>'WHERE (Lokasi Detail)', 'who_summary'=>'WHO (Peserta)', 'how_expected'=>'HOW (Hasil yang Diharapkan)'] as $field => $label)
                @if($meeting->$field)
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">{{ $label }}</p>
                    <p class="text-sm text-gray-700 mt-0.5">{{ $meeting->$field }}</p>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Peserta & Aset --}}
    @if($meeting->participants->count())
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-primary mb-3">Peserta ({{ $meeting->participants->count() }})</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($meeting->participants as $p)
                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">{{ $p->name }}</span>
            @endforeach
        </div>
    </div>
    @endif

    @if($meeting->assets->count())
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-primary mb-3">Aset yang Dibutuhkan</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($meeting->assets as $a)
                <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs">{{ $a->name }} ({{ $a->pivot->quantity }})</span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Approve / Reject --}}
    @if($meeting->status === 'pending')
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-primary mb-4">Tindakan</h3>
        <div class="flex gap-3">
            <form method="POST" action="{{ route('admin.meetings.approve', $meeting) }}">
                @csrf @method('PATCH')
                <button class="px-5 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700 transition">✓ Setujui Meeting</button>
            </form>
        </div>
        <form method="POST" action="{{ route('admin.meetings.reject', $meeting) }}" class="mt-3">
            @csrf @method('PATCH')
            <textarea name="reject_reason" placeholder="Alasan penolakan..." required rows="2"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-400 mb-2"></textarea>
            <button class="px-5 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition">✗ Tolak Meeting</button>
        </form>
    </div>
    @endif

    @if($meeting->reject_reason)
    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
        <p class="text-sm font-medium text-red-700">Alasan Penolakan:</p>
        <p class="text-sm text-red-600 mt-1">{{ $meeting->reject_reason }}</p>
    </div>
    @endif

    <a href="{{ route('admin.meetings.index') }}" class="inline-block text-sm text-gray-500 hover:text-primary">← Kembali</a>
</div>
@endsection
