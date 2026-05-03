@extends('layouts.app')
@section('title', 'Meeting Mingguan')
@section('page-title', 'Meeting Mingguan')
@section('page-subtitle', 'Jadwal meeting rutin yang otomatis muncul di kalender')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2">
    @php
        $days = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'];
    @endphp
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.weekly-meetings.create') }}" class="px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">+ Tambah Jadwal Mingguan</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($weeklies as $weekly)
        <div class="bg-white rounded-xl shadow-sm p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <h3 class="font-semibold text-primary">{{ $weekly->title }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $weekly->room->name }}</p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $weekly->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                    {{ $weekly->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <div class="space-y-1 text-sm text-gray-600 mb-4">
                <p>📅 Setiap <strong>{{ $days[$weekly->day_of_week] ?? '-' }}</strong></p>
                <p>🕐 {{ substr($weekly->start_time,0,5) }} – {{ substr($weekly->end_time,0,5) }}</p>
            </div>
            <div class="flex gap-2 pt-3 border-t border-gray-100">
                <a href="{{ route('admin.weekly-meetings.edit', $weekly) }}" class="flex-1 text-center px-3 py-1.5 bg-secondary/10 text-secondary rounded text-xs hover:bg-secondary hover:text-white transition">Edit</a>
                <form method="POST" action="{{ route('admin.weekly-meetings.destroy', $weekly) }}" onsubmit="return confirm('Hapus jadwal ini?')" class="flex-1">
                    @csrf @method('DELETE')
                    <button class="w-full px-3 py-1.5 bg-red-50 text-red-600 rounded text-xs hover:bg-red-600 hover:text-white transition">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-3 bg-white rounded-xl shadow-sm p-8 text-center text-gray-400">Belum ada jadwal meeting mingguan.</div>
        @endforelse
    </div>
</div>
@endsection
