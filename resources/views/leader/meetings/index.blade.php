@extends('layouts.app')
@section('title', 'Meeting Saya')
@section('page-title', 'Meeting Saya')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2">
    @php $statusColors = ['pending'=>'bg-yellow-100 text-yellow-700','approved'=>'bg-blue-100 text-blue-700','rejected'=>'bg-red-100 text-red-700','confirmed'=>'bg-indigo-100 text-indigo-700','cancelled'=>'bg-gray-100 text-gray-600','in_progress'=>'bg-purple-100 text-purple-700','completed'=>'bg-green-100 text-green-700']; @endphp
    <div class="flex justify-end mb-4">
        <a href="{{ route('koordinator.meetings.create') }}" class="px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">+ Request Meeting</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-primary text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Judul</th>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Waktu</th>
                    <th class="px-4 py-3 text-left">Ruangan</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($meetings as $meeting)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium">{{ $meeting->title }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $meeting->meeting_date->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $meeting->room->name }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$meeting->status] ?? '' }}">{{ ucfirst($meeting->status) }}</span></td>
                    <td class="px-4 py-3">
                        <a href="{{ route('koordinator.meetings.show', $meeting) }}" class="px-3 py-1 bg-primary/10 text-primary rounded text-xs hover:bg-primary hover:text-white transition">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada meeting.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $meetings->links() }}</div>
    </div>
</div>
@endsection
