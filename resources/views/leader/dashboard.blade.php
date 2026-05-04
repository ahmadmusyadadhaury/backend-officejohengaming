@extends('layouts.app')

@section('title', 'Dashboard Leader')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang, ' . auth()->user()->name)

@section('sidebar-menu')
    @include('partials.sidebar-leader')
@endsection

@section('content')
<div class="space-y-6 pt-2">

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['label' => 'Menunggu',   'value' => $stats['pending'],   'color' => 'bg-yellow-500', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Disetujui',  'value' => $stats['approved'],  'color' => 'bg-secondary',  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Selesai',    'value' => $stats['completed'], 'color' => 'bg-green-600',  'icon' => 'M5 13l4 4L19 7'],
                ['label' => 'Dibatalkan', 'value' => $stats['cancelled'], 'color' => 'bg-red-500',    'icon' => 'M6 18L18 6M6 6l12 12'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="bg-white rounded-xl shadow-sm p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl {{ $card['color'] }} flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-primary">{{ $card['value'] }}</p>
                    <p class="text-xs text-gray-500">{{ $card['label'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Upcoming Meetings --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-primary text-sm">Meeting Mendatang</h3>
                <a href="{{ route('koordinator.meetings.index') }}" class="text-xs text-accent hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($upcomingMeetings as $meeting)
                    <div class="px-6 py-3">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-800">{{ $meeting->title }}</p>
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                {{ $meeting->status === 'approved' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($meeting->status) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">{{ $meeting->room->name }} · {{ $meeting->meeting_date->format('d M Y') }}</p>
                        <p class="text-xs text-gray-400">{{ substr($meeting->start_time, 0, 5) }} – {{ substr($meeting->end_time, 0, 5) }}</p>
                    </div>
                @empty
                    <p class="px-6 py-4 text-sm text-gray-400">Tidak ada meeting mendatang.</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Meetings --}}
        <div class="bg-white rounded-xl shadow-sm">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="font-semibold text-primary text-sm">Riwayat Meeting</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentMeetings as $meeting)
                    <div class="px-6 py-3 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $meeting->title }}</p>
                            <p class="text-xs text-gray-400">{{ $meeting->meeting_date->format('d M Y') }}</p>
                        </div>
                        @php
                            $statusColor = match($meeting->status) {
                                'pending'     => 'bg-yellow-100 text-yellow-700',
                                'approved'    => 'bg-blue-100 text-blue-700',
                                'confirmed'   => 'bg-indigo-100 text-indigo-700',
                                'completed'   => 'bg-green-100 text-green-700',
                                'rejected'    => 'bg-red-100 text-red-700',
                                'cancelled'   => 'bg-gray-100 text-gray-600',
                                'in_progress' => 'bg-purple-100 text-purple-700',
                                default       => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ ucfirst($meeting->status) }}
                        </span>
                    </div>
                @empty
                    <p class="px-6 py-4 text-sm text-gray-400">Belum ada riwayat meeting.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Quick Action --}}
    <div class="bg-gradient-to-r from-primary to-accent rounded-xl p-6 flex items-center justify-between">
        <div>
            <p class="text-white font-semibold">Buat Request Meeting Baru</p>
            <p class="text-blue-200 text-sm mt-1">Ajukan permintaan ruang meeting ke Admin HR</p>
        </div>
        <a href="{{ route('koordinator.meetings.create') }}"
            class="px-5 py-2.5 bg-white text-primary font-semibold rounded-lg text-sm hover:bg-blue-50 transition flex-shrink-0">
            + Request Meeting
        </a>
    </div>

</div>
@endsection
