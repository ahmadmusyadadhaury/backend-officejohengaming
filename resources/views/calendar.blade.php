@extends('layouts.app')

@section('title', 'Kalender Meeting')
@section('page-title', 'Kalender Meeting')
@section('page-subtitle', 'Lihat jadwal semua meeting')

@section('sidebar-menu')
    @if(auth()->user()->hasFullAccess())
        @include('partials.sidebar-admin')
    @elseif(auth()->user()->role === 'koordinator')
        @include('partials.sidebar-leader')
    @else
        @include('partials.sidebar-user')
    @endif
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <style>
        #event-modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:999; align-items:center; justify-content:center; }
        #event-modal.show { display:flex; }
    </style>
@endpush

@section('content')
<div class="pt-2">
    {{-- Filter --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-4 flex flex-wrap gap-3 items-center">
        <input type="date" id="filter-date" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-accent">
        <button onclick="filterByDate()" class="px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-light transition">Cari</button>
        <button onclick="resetFilter()" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition">Reset</button>
        <div class="flex items-center gap-4 ml-auto text-xs text-gray-500">
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-primary inline-block"></span> Terjadwal</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-indigo-600 inline-block"></span> Terkonfirmasi</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-accent inline-block"></span> Berlangsung</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-gray-400 inline-block"></span> Selesai</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4">
        <div id="calendar"></div>
    </div>
</div>

{{-- Event Detail Modal --}}
<div id="event-modal">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden">
        <div id="modal-header" class="p-5 text-white">
            <p class="text-xs font-medium opacity-80 mb-1">Detail Meeting</p>
            <h3 id="modal-title" class="font-bold text-lg leading-tight"></h3>
        </div>
        <div class="p-5 space-y-3">
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Ruangan</p>
                    <p id="modal-room" class="text-sm font-semibold text-primary"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Tim</p>
                    <p id="modal-team" class="text-sm font-semibold text-primary"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-0.5">Jam Mulai</p>
                    <p id="modal-start" class="text-sm font-semibold text-primary"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-3">
                    <p class="text-xs text-gray-400 mb-0.5" id="modal-end-label">Jam Selesai (Estimasi)</p>
                    <p id="modal-end" class="text-sm font-semibold text-primary"></p>
                </div>
            </div>
            <div id="modal-actual-wrap" class="hidden bg-green-50 border border-green-200 rounded-lg p-3">
                <p class="text-xs text-green-600 mb-0.5">Jam Selesai Aktual</p>
                <p id="modal-actual" class="text-sm font-bold text-green-700"></p>
            </div>
            <div class="flex items-center justify-between pt-1">
                <span id="modal-status" class="px-3 py-1 rounded-full text-xs font-medium"></span>
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    let calendar;

    const statusColors = {
        approved:    { bg: '#1e3a5f', badge: 'background:#dbeafe;color:#1d4ed8' },
        confirmed:   { bg: '#4f46e5', badge: 'background:#e0e7ff;color:#3730a3' },
        in_progress: { bg: '#7c3aed', badge: 'background:#ede9fe;color:#6d28d9' },
        completed:   { bg: '#6b7280', badge: 'background:#f3f4f6;color:#374151' },
    };

    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '{{ route("calendar.events") }}',
            eventClick: function (info) {
                const p = info.event.extendedProps;
                const sc = statusColors[p.status] || { bg: '#1e3a5f', badge: '' };

                document.getElementById('modal-header').style.background = sc.bg;
                document.getElementById('modal-title').textContent = info.event.title.split(' (Selesai')[0];
                document.getElementById('modal-room').textContent = p.room;
                document.getElementById('modal-team').textContent = p.team;
                document.getElementById('modal-start').textContent = p.start_time;
                document.getElementById('modal-end').textContent = p.end_time;
                document.getElementById('modal-end-label').textContent = p.actual_end_time ? 'Jam Selesai (Estimasi)' : 'Jam Selesai';

                const actualWrap = document.getElementById('modal-actual-wrap');
                if (p.actual_end_time) {
                    actualWrap.classList.remove('hidden');
                    document.getElementById('modal-actual').textContent = p.actual_end_time + ' WIB';
                } else {
                    actualWrap.classList.add('hidden');
                }

                const statusEl = document.getElementById('modal-status');
                statusEl.textContent = p.status.charAt(0).toUpperCase() + p.status.slice(1);
                statusEl.style.cssText = sc.badge;

                document.getElementById('event-modal').classList.add('show');
            },
            height: 'auto',
            slotMinTime: '07:00:00',
            slotMaxTime: '21:00:00',
        });
        calendar.render();
    });

    function closeModal() {
        document.getElementById('event-modal').classList.remove('show');
    }

    document.getElementById('event-modal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    function filterByDate() {
        const date = document.getElementById('filter-date').value;
        if (date) {
            calendar.gotoDate(date);
            calendar.changeView('timeGridDay');
        }
    }

    function resetFilter() {
        document.getElementById('filter-date').value = '';
        calendar.changeView('timeGridWeek');
        calendar.today();
    }
</script>
@endpush
