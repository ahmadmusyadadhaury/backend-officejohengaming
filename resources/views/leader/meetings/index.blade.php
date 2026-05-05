@extends('layouts.app')
@section('title', 'Meeting Saya')
@section('page-title', 'Meeting Saya')
@section('sidebar-menu') @include('partials.sidebar-leader') @endsection
@section('content')
<div class="pt-2">
    <div class="flex justify-end mb-4">
        <a href="{{ route('koordinator.meetings.create') }}" class="px-4 py-2 bg-accent text-white rounded-lg text-sm hover:bg-accent/90 transition">+ Request Meeting</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full text-sm min-w-[550px]">
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
                @php $rt = \App\Services\MeetingQueueService::realtimeStatus($meeting); @endphp
                <tr class="hover:bg-gray-50" data-meeting-id="{{ $meeting->id }}">
                    <td class="px-4 py-3 font-medium">{{ $meeting->title }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $meeting->meeting_date->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ substr($meeting->start_time,0,5) }}–{{ substr($meeting->end_time,0,5) }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $meeting->room->name }}</td>
                    <td class="px-4 py-3">
                        <span class="rt-badge px-2 py-0.5 rounded-full text-xs font-medium {{ $rt['color'] }}">
                            {{ $rt['label'] }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('koordinator.meetings.show', $meeting) }}" class="px-3 py-1 bg-primary/10 text-primary rounded text-xs hover:bg-primary hover:text-white transition">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada meeting.</td></tr>
                @endforelse
            </tbody>
        </table>
        </table>
        </div>
        <div class="px-4 py-3 border-t flex items-center justify-between">
            {{ $meetings->links() }}
            <span id="rt-update" class="text-xs text-gray-400"></span>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function refreshStatus() {
        fetch('{{ route("realtime.meetings") }}')
            .then(r => r.json())
            .then(data => {
                data.forEach(m => {
                    const row = document.querySelector(`tr[data-meeting-id="${m.id}"]`);
                    if (!row) return;
                    const badge = row.querySelector('.rt-badge');
                    if (!badge) return;
                    badge.textContent = m.rt_label;
                    badge.className = 'rt-badge px-2 py-0.5 rounded-full text-xs font-medium';
                    badge.style.cssText = getRtStyle(m.rt_label);
                });
                const el = document.getElementById('rt-update');
                if (el) el.textContent = 'Update: ' + new Date().toLocaleTimeString('id-ID');
            }).catch(() => {});
    }

    function getRtStyle(label) {
        if (!label) return '';
        if (label.includes('Berlangsung')) return 'background:#f3e8ff;color:#7c3aed';
        if (label.includes('Antrian'))     return 'background:#ffedd5;color:#c2410c';
        if (label.includes('Di Booking'))  return 'background:#dbeafe;color:#1d4ed8';
        if (label.includes('Selesai'))     return 'background:#f3f4f6;color:#374151';
        return 'background:#fef9c3;color:#854d0e';
    }

    setInterval(refreshStatus, 30000);
</script>
@endpush
