@extends('layouts.app')

@section('title', 'Kalender Meeting')
@section('page-title', 'Kalender Meeting')
@section('page-subtitle', 'Lihat jadwal semua meeting')

@section('sidebar-menu')
    @if(auth()->user()->role === 'admin')
        @include('partials.sidebar-admin')
    @elseif(auth()->user()->role === 'leader')
        @include('partials.sidebar-leader')
    @else
        @include('partials.sidebar-user')
    @endif
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
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
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-accent inline-block"></span> Berlangsung</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-gray-400 inline-block"></span> Selesai</span>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4">
        <div id="calendar"></div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    let calendar;

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
                alert(`📅 ${info.event.title}\n🏢 Ruangan: ${p.room}\n👥 Tim: ${p.team}\n📌 Status: ${p.status}`);
            },
            height: 'auto',
            slotMinTime: '07:00:00',
            slotMaxTime: '21:00:00',
        });
        calendar.render();
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
