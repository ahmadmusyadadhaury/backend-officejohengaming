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
        #event-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            align-items: flex-end;
            justify-content: center;
            padding: 0;
        }
        #event-modal.show { display: flex; }

        @media (min-width: 640px) {
            #event-modal {
                align-items: center;
                padding: 1rem;
            }
            #modal-card {
                border-radius: 1rem;
                max-width: 28rem;
            }
        }

        #modal-card {
            width: 100%;
            border-radius: 1rem 1rem 0 0;
            max-height: 90vh;
            overflow-y: auto;
            background: var(--bg-surface);
        }

        /* FullCalendar gaming theme */
        .fc { color: var(--text-primary); }
        .fc .fc-toolbar { flex-wrap: wrap; gap: 0.5rem; }
        .fc .fc-toolbar-title { font-size: 1rem !important; font-family: 'Rajdhani', sans-serif; font-weight: 700; color: var(--text-primary); }
        .fc .fc-button { padding: 0.25rem 0.5rem !important; font-size: 0.75rem !important; background: var(--color-accent) !important; border-color: var(--color-accent) !important; }
        .fc .fc-button:hover { opacity: 0.85 !important; }
        .fc .fc-button-active { background: var(--color-primary) !important; border-color: var(--color-primary) !important; }
        .fc .fc-event-title { font-size: 0.7rem; }
        .fc .fc-timegrid-slot { height: 2rem !important; }
        .fc .fc-col-header-cell { background: var(--bg-surface-2); color: var(--text-secondary); }
        .fc td, .fc th { border-color: var(--border-color) !important; }
        .fc .fc-list-day-cushion { background: var(--bg-surface-2) !important; }
        .fc .fc-list-event:hover td { background: rgba(124,58,237,0.05) !important; }
        .fc .fc-daygrid-day-number, .fc .fc-list-day-text, .fc .fc-list-day-side-text { color: var(--text-secondary); }
        .fc .fc-day-today { background: rgba(124,58,237,0.05) !important; }

        @media (min-width: 640px) {
            .fc .fc-toolbar-title { font-size: 1.25rem !important; }
            .fc .fc-button { padding: 0.375rem 0.75rem !important; font-size: 0.875rem !important; }
            .fc .fc-event-title { font-size: 0.75rem; }
            .fc .fc-timegrid-slot { height: 2.5rem !important; }
        }
    </style>
@endpush

@section('content')
<div class="pt-2 space-y-3">

    {{-- Filter & Legenda --}}
    <div class="gaming-card p-3 lg:p-4">
        <div class="flex flex-wrap gap-2 mb-3">
            <input type="date" id="filter-date" class="gaming-input flex-1 min-w-0">
            <button onclick="filterByDate()" class="btn btn-primary btn-sm whitespace-nowrap">Cari</button>
            <button onclick="resetFilter()" class="btn btn-secondary btn-sm whitespace-nowrap">Reset</button>
        </div>
        <div class="flex flex-wrap gap-x-4 gap-y-1.5" style="font-size:0.75rem;color:var(--text-muted);">
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full inline-block" style="background:#3b82f6;"></span> Di Booking</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full inline-block" style="background:#7c3aed;"></span> Berlangsung</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full inline-block" style="background:#f97316;"></span> Antrian</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full inline-block" style="background:#6b7280;"></span> Selesai</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full inline-block" style="background:#0891b2;"></span> Mingguan</span>
            <span id="last-update" class="ml-auto hidden sm:block" style="color:var(--text-muted);"></span>
        </div>
    </div>

    {{-- Kalender --}}
    <div class="gaming-card p-2 sm:p-4">
        <div id="calendar"></div>
    </div>
</div>

{{-- Event Detail Modal (bottom sheet di mobile, center di desktop) --}}
<div id="event-modal">
    <div id="modal-card" class="shadow-2xl w-full sm:max-w-md overflow-hidden" style="background:var(--bg-surface);">
        <div class="flex justify-center pt-3 pb-1 sm:hidden">
            <div class="w-10 h-1 rounded-full" style="background:var(--border-color);"></div>
        </div>

        <div id="modal-header" class="p-4 sm:p-5 text-white">
            <p class="text-xs font-medium mb-1" style="opacity:0.7;">Detail Meeting</p>
            <h3 id="modal-title" class="font-gaming font-bold text-base sm:text-lg leading-tight"></h3>
        </div>

        <div class="p-4 sm:p-5 space-y-3">
            <div class="grid grid-cols-2 gap-2 sm:gap-3">
                <div class="gaming-card-flat p-2.5 sm:p-3">
                    <p class="text-xs mb-0.5" style="color:var(--text-muted);">Ruangan</p>
                    <p id="modal-room" class="text-sm font-semibold" style="color:var(--text-primary);"></p>
                </div>
                <div class="gaming-card-flat p-2.5 sm:p-3">
                    <p class="text-xs mb-0.5" style="color:var(--text-muted);">Tim</p>
                    <p id="modal-team" class="text-sm font-semibold" style="color:var(--text-primary);"></p>
                </div>
                <div class="gaming-card-flat p-2.5 sm:p-3">
                    <p class="text-xs mb-0.5" style="color:var(--text-muted);">Jam Mulai</p>
                    <p id="modal-start" class="text-sm font-semibold" style="color:var(--text-primary);"></p>
                </div>
                <div class="gaming-card-flat p-2.5 sm:p-3">
                    <p class="text-xs mb-0.5" id="modal-end-label" style="color:var(--text-muted);">Jam Selesai</p>
                    <p id="modal-end" class="text-sm font-semibold" style="color:var(--text-primary);"></p>
                </div>
            </div>

            <div id="modal-actual-wrap" class="hidden p-2.5 sm:p-3 rounded-lg" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);">
                <p class="text-xs mb-0.5" style="color:#34d399;">Jam Selesai Aktual</p>
                <p id="modal-actual" class="text-sm font-bold" style="color:#34d399;"></p>
            </div>

            <div class="gaming-card-flat p-2.5 sm:p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Status</p>
                <span id="modal-rt-status" class="badge"></span>
            </div>

            <button onclick="closeModal()" class="btn btn-secondary w-full">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    let calendar;
    let currentEventId = null;

    // Deteksi mobile
    const isMobile = () => window.innerWidth < 640;

    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            // Mobile: listWeek, Desktop: timeGridWeek
            initialView: isMobile() ? 'listWeek' : 'timeGridWeek',
            locale: 'id',
            headerToolbar: isMobile()
                ? { left: 'prev,next', center: 'title', right: 'listWeek,timeGridDay' }
                : { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' },
            events: '{{ route("calendar.events") }}',
            eventClick: function (info) {
                const p = info.event.extendedProps;
                currentEventId = p.meeting_id;
                showModal(info.event.title, p);
            },
            height: isMobile() ? 'auto' : 600,
            slotMinTime: '07:00:00',
            slotMaxTime: '21:00:00',
            listDayFormat: { weekday: 'long', day: 'numeric', month: 'long' },
            noEventsText: 'Tidak ada meeting',
            windowResize: function(view) {
                if (isMobile()) {
                    calendar.changeView('listWeek');
                    calendar.setOption('headerToolbar', { left: 'prev,next', center: 'title', right: 'listWeek,timeGridDay' });
                } else {
                    calendar.changeView('timeGridWeek');
                    calendar.setOption('headerToolbar', { left: 'prev,next today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay' });
                }
            }
        });

        calendar.render();

        setInterval(refreshRealtimeStatus, 30000);
        setInterval(refreshWeeklyStatus, 30000);
        refreshRealtimeStatus();
        refreshWeeklyStatus();
    });

    function showModal(title, p) {
        document.getElementById('modal-header').style.background = p.rt_dot || '#1e3a5f';
        document.getElementById('modal-title').textContent = title.split(' (Selesai')[0];
        document.getElementById('modal-room').textContent  = p.room;
        document.getElementById('modal-team').textContent  = p.team;
        document.getElementById('modal-start').textContent = p.start_time;
        document.getElementById('modal-end').textContent   = p.end_time;
        document.getElementById('modal-end-label').textContent = p.actual_end_time ? 'Jam Selesai (Estimasi)' : 'Jam Selesai';

        const actualWrap = document.getElementById('modal-actual-wrap');
        if (p.actual_end_time) {
            actualWrap.classList.remove('hidden');
            document.getElementById('modal-actual').textContent = p.actual_end_time + ' WIB';
        } else {
            actualWrap.classList.add('hidden');
        }

        const rtEl = document.getElementById('modal-rt-status');
        rtEl.textContent   = p.rt_label || '';
        rtEl.style.cssText = getRtStyle(p.rt_label);

        document.getElementById('event-modal').classList.add('show');
    }

    function getRtStyle(label) {
        if (!label) return '';
        if (label.includes('Berlangsung')) return 'background:rgba(124,58,237,0.15);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);';
        if (label.includes('Antrian'))     return 'background:rgba(249,115,22,0.15);color:#fb923c;border:1px solid rgba(249,115,22,0.3);';
        if (label.includes('Di Booking'))  return 'background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);';
        if (label.includes('Selesai'))     return 'background:rgba(148,163,184,0.15);color:#94a3b8;border:1px solid rgba(148,163,184,0.3);';
        if (label.includes('Mingguan'))    return 'background:rgba(0,212,255,0.15);color:#00d4ff;border:1px solid rgba(0,212,255,0.3);';
        return 'background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);';
    }

    function refreshRealtimeStatus() {
        fetch('{{ route("realtime.meetings") }}')
            .then(r => r.json())
            .then(data => {
                data.forEach(m => {
                    const events = calendar.getEvents().filter(e => e.extendedProps.meeting_id === m.id);
                    events.forEach(e => {
                        e.setProp('color', m.rt_dot);
                        e.setExtendedProp('rt_label', m.rt_label);
                        e.setExtendedProp('rt_dot', m.rt_dot);
                    });
                });

                if (currentEventId) {
                    const current = data.find(m => m.id === currentEventId);
                    if (current) {
                        const rtEl = document.getElementById('modal-rt-status');
                        if (rtEl) {
                            rtEl.textContent   = current.rt_label;
                            rtEl.style.cssText = getRtStyle(current.rt_label);
                            document.getElementById('modal-header').style.background = current.rt_dot;
                        }
                    }
                }

                const el = document.getElementById('last-update');
                if (el) el.textContent = 'Update: ' + new Date().toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});
            }).catch(() => {});
    }

    function refreshWeeklyStatus() {
        fetch('{{ route("realtime.weekly") }}')
            .then(r => r.json())
            .then(data => {
                data.forEach(s => {
                    const events = calendar.getEvents().filter(e =>
                        e.extendedProps.weekly_id && e.start &&
                        e.start.toISOString().startsWith(s.date)
                    );
                    events.forEach(e => {
                        e.setProp('color', s.rt_dot);
                        e.setExtendedProp('rt_label', s.rt_label);
                        if (s.rt_label === 'Sedang Berlangsung') {
                            e.setProp('title', '🔁 ' + s.title + ' — Sedang Berlangsung');
                        } else if (s.rt_label === 'Selesai') {
                            e.setProp('title', '🔁 ' + s.title + ' (Selesai)');
                            e.setProp('color', '#6b7280');
                        }
                    });
                });
            }).catch(() => {});
    }

    function closeModal() {
        document.getElementById('event-modal').classList.remove('show');
        currentEventId = null;
    }

    // Tutup modal klik overlay
    document.getElementById('event-modal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });

    // Swipe down untuk tutup modal di mobile
    let touchStartY = 0;
    document.getElementById('modal-card').addEventListener('touchstart', e => {
        touchStartY = e.touches[0].clientY;
    });
    document.getElementById('modal-card').addEventListener('touchend', e => {
        if (e.changedTouches[0].clientY - touchStartY > 80) closeModal();
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
        calendar.changeView(isMobile() ? 'listWeek' : 'timeGridWeek');
        calendar.today();
    }
</script>
@endpush
