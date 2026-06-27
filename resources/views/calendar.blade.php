@extends('layouts.app')

@section('title', 'Jadwal Meeting')
@section('page-title', 'Jadwal Meeting')
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
        /* ── Modal Overlay ── */
        #event-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        #event-modal.show { display: flex; }

        /* ── Modal Card ── */
        #modal-card {
            width: 100%;
            max-width: 26rem;
            border-radius: 1.25rem;
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-lg), var(--shadow-glow);
            overflow: hidden;
            transform: scale(0.92) translateY(12px);
            opacity: 0;
            transition: transform 0.28s cubic-bezier(0.34,1.56,0.64,1), opacity 0.22s ease;
        }
        #event-modal.show #modal-card {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
        @media (max-width: 639px) {
            #modal-card { max-height: 90vh; overflow-y: auto; }
        }

        /* ── Modal Header ── */
        #modal-header {
            position: relative;
            overflow: hidden;
        }
        #modal-header::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 60%);
            pointer-events: none;
        }
        #modal-header::before {
            content: '';
            position: absolute;
            bottom: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        }

        /* ── Modal Info Grid ── */
        .modal-info-item {
            background: var(--bg-surface-2);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.625rem 0.875rem;
            transition: border-color 0.2s ease;
        }
        .modal-info-item:hover { border-color: var(--border-glow); }

        /* ── Calendar Wrapper ── */
        .calendar-wrapper {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            padding: 1rem;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }
        .calendar-wrapper::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--color-accent), var(--color-neon-blue), var(--color-accent));
            background-size: 200% auto;
            animation: shimmer 4s linear infinite;
        }

        /* ── FullCalendar Overrides ── */
        .fc { font-family: 'Inter', sans-serif; }

        /* Toolbar */
        .fc .fc-toolbar { flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1rem !important; }
        .fc .fc-toolbar-title {
            font-family: 'Rajdhani', sans-serif !important;
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.04em;
            color: var(--text-primary) !important;
        }

        /* Buttons */
        .fc .fc-button {
            background: var(--bg-surface-2) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-secondary) !important;
            border-radius: 0.5rem !important;
            font-family: 'Rajdhani', sans-serif !important;
            font-weight: 600 !important;
            letter-spacing: 0.04em !important;
            padding: 0.3rem 0.75rem !important;
            font-size: 0.78rem !important;
            transition: all 0.15s ease !important;
            box-shadow: none !important;
            text-shadow: none !important;
        }
        .fc .fc-button:hover {
            background: rgba(124,58,237,0.12) !important;
            border-color: rgba(124,58,237,0.4) !important;
            color: var(--color-accent-light) !important;
        }
        .fc .fc-button-active,
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background: linear-gradient(135deg, var(--color-accent), var(--color-primary-light)) !important;
            border-color: transparent !important;
            color: white !important;
            box-shadow: 0 4px 12px rgba(124,58,237,0.35) !important;
        }
        .fc .fc-today-button {
            background: rgba(0,212,255,0.1) !important;
            border-color: rgba(0,212,255,0.3) !important;
            color: var(--color-neon-blue) !important;
        }
        .fc .fc-today-button:hover {
            background: rgba(0,212,255,0.2) !important;
        }

        /* Header cells */
        .fc .fc-col-header-cell {
            background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary)) !important;
            border-color: rgba(255,255,255,0.06) !important;
        }
        .fc .fc-col-header-cell-cushion {
            font-family: 'Rajdhani', sans-serif !important;
            font-weight: 700 !important;
            font-size: 0.78rem !important;
            letter-spacing: 0.08em !important;
            text-transform: uppercase !important;
            color: rgba(255,255,255,0.85) !important;
            padding: 0.5rem 0.25rem !important;
            text-decoration: none !important;
        }

        /* Today highlight */
        .fc .fc-day-today {
            background: rgba(124,58,237,0.06) !important;
        }
        .fc .fc-timegrid-col.fc-day-today {
            background: rgba(124,58,237,0.05) !important;
        }

        /* Time slots */
        .fc .fc-timegrid-slot { height: 2.25rem !important; }
        .fc .fc-timegrid-slot-label-cushion {
            font-size: 0.7rem !important;
            color: var(--text-muted) !important;
            font-family: 'Rajdhani', sans-serif !important;
            letter-spacing: 0.04em;
        }

        /* Events */
        .fc .fc-event {
            border: none !important;
            border-radius: 0.4rem !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2) !important;
            cursor: pointer !important;
            transition: transform 0.15s ease, box-shadow 0.15s ease !important;
        }
        .fc .fc-event:hover {
            transform: translateY(-1px) scale(1.01) !important;
            box-shadow: 0 4px 16px rgba(0,0,0,0.3) !important;
            z-index: 10 !important;
        }
        .fc .fc-event-title {
            font-size: 0.7rem !important;
            font-weight: 600 !important;
            font-family: 'Inter', sans-serif !important;
        }
        .fc .fc-event-time {
            font-size: 0.65rem !important;
            opacity: 0.85;
        }

        /* Grid lines — bersih & rapi */
        .fc .fc-scrollgrid { border-color: var(--border-color) !important; }
        .fc td, .fc th { border-color: var(--border-color) !important; }

        /* Weekly column vertical dividers */
        .fc .fc-timegrid-col { border-left: 1px solid var(--border-color) !important; }
        .fc .fc-timegrid-col:first-child { border-left: none !important; }

        /* Horizontal slot lines */
        .fc .fc-timegrid-slot-lane { border-bottom: 1px solid var(--border-color) !important; }

        /* Clean solid background — tanpa alternating */
        .fc .fc-timegrid-slot-lane { background: var(--bg-surface) !important; }

        /* Light mode — manual toggle (body.light) */
        body.light .calendar-wrapper { background: #f0f3f8 !important; border-color: #c8d0dc !important; }
        body.light .fc td, body.light .fc th { border-color: #c8d0dc !important; }
        body.light .fc .fc-scrollgrid { border-color: #c8d0dc !important; }
        body.light .fc .fc-timegrid-col { border-left-color: #c8d0dc !important; }
        body.light .fc .fc-timegrid-slot-lane { border-bottom-color: #d4dae5 !important; background: #f7f9fc !important; }
        body.light .fc .fc-day-today { background: rgba(124,58,237,0.18) !important; }
        body.light .fc .fc-timegrid-col.fc-day-today { background: rgba(124,58,237,0.14) !important; }
        body.light .fc .fc-col-header-cell.fc-day-today {
            background: linear-gradient(135deg, #7c3aed, #6d28d9) !important;
            box-shadow: 0 2px 8px rgba(124,58,237,0.4) !important;
        }
        body.light .fc .fc-daygrid-day { background: #f7f9fc !important; }
        body.light .fc .fc-list-table td { border-color: #c8d0dc !important; }
        body.light .fc .fc-list-event:hover td { background: rgba(124,58,237,0.08) !important; }
        body.light .fc .fc-timegrid-axis { border-color: #c8d0dc !important; }

        /* Light mode — OS prefers-color-scheme */
        @media (prefers-color-scheme: light) {
            .calendar-wrapper { background: #f0f3f8 !important; border-color: #c8d0dc !important; }
            .fc td, .fc th { border-color: #c8d0dc !important; }
            .fc .fc-scrollgrid { border-color: #c8d0dc !important; }
            .fc .fc-timegrid-col { border-left-color: #c8d0dc !important; }
            .fc .fc-timegrid-slot-lane { border-bottom-color: #d4dae5 !important; background: #f7f9fc !important; }
            .fc .fc-day-today { background: rgba(124,58,237,0.18) !important; }
            .fc .fc-timegrid-col.fc-day-today { background: rgba(124,58,237,0.14) !important; }
            .fc .fc-col-header-cell.fc-day-today {
                background: linear-gradient(135deg, #7c3aed, #6d28d9) !important;
                box-shadow: 0 2px 8px rgba(124,58,237,0.4) !important;
            }
            .fc .fc-daygrid-day { background: #f7f9fc !important; }
            .fc .fc-list-table td { border-color: #c8d0dc !important; }
            .fc .fc-list-event:hover td { background: rgba(124,58,237,0.08) !important; }
            .fc .fc-timegrid-axis { border-color: #c8d0dc !important; }
        }

        /* List view */
        .fc .fc-list-event:hover td { background: rgba(124,58,237,0.06) !important; }
        .fc .fc-list-day-cushion {
            background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary)) !important;
        }
        .fc .fc-list-day-text,
        .fc .fc-list-day-side-text {
            font-family: 'Rajdhani', sans-serif !important;
            font-weight: 700 !important;
            letter-spacing: 0.05em !important;
            color: rgba(255,255,255,0.9) !important;
            text-decoration: none !important;
        }
        .fc .fc-list-event-title a {
            color: var(--text-primary) !important;
            text-decoration: none !important;
            font-size: 0.875rem !important;
        }
        .fc .fc-list-event-time {
            color: var(--text-muted) !important;
            font-size: 0.8rem !important;
        }

        /* Month view day number */
        .fc .fc-daygrid-day-number {
            font-family: 'Rajdhani', sans-serif !important;
            font-weight: 600 !important;
            color: var(--text-secondary) !important;
            text-decoration: none !important;
            font-size: 0.85rem !important;
        }
        .fc .fc-day-today .fc-daygrid-day-number {
            background: linear-gradient(135deg, var(--color-accent), var(--color-primary-light));
            color: white !important;
            border-radius: 50%;
            width: 1.75rem;
            height: 1.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 4px;
        }

        /* No events */
        .fc .fc-list-empty {
            background: var(--bg-surface-2) !important;
            color: var(--text-muted) !important;
            font-family: 'Rajdhani', sans-serif !important;
            letter-spacing: 0.05em;
        }

        /* Sembunyikan teks all-day */
        .fc .fc-timegrid-axis-cushion { visibility: hidden !important; }

        @media (min-width: 640px) {
            .fc .fc-toolbar-title { font-size: 1.25rem !important; }
            .fc .fc-button { padding: 0.375rem 0.875rem !important; font-size: 0.82rem !important; }
            .fc .fc-timegrid-slot { height: 2.5rem !important; }
            .calendar-wrapper { padding: 1.25rem; }
        }

        /* ── Layout 2 Kolom ── */
        .cal-layout {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
        }
        .cal-sidebar {
            width: 220px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            position: sticky;
            top: 1rem;
        }
        .cal-main { flex: 1; min-width: 0; }

        /* Sembunyikan sidebar di mobile */
        @media (max-width: 1023px) {
            .cal-layout { flex-direction: column; }
            .cal-sidebar {
                width: 100%;
                position: static;
                flex-direction: row;
                flex-wrap: wrap;
            }
            .cal-sidebar-panel { flex: 1; min-width: 200px; }
        }

        /* ── Sidebar Panel ── */
        .cal-sidebar-panel {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }
        .cal-sidebar-panel-header {
            padding: 0.625rem 0.875rem;
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-surface-2);
        }

        /* ── Mini Calendar ── */
        .mini-cal { padding: 0.75rem; }
        .mini-cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .mini-cal-title {
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.04em;
            color: var(--text-primary);
        }
        .mini-cal-nav {
            width: 1.5rem; height: 1.5rem;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color);
            background: var(--bg-surface-2);
            color: var(--text-muted);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.15s ease;
            font-size: 0.7rem;
        }
        .mini-cal-nav:hover {
            border-color: var(--color-accent);
            color: var(--color-accent-light);
            background: rgba(124,58,237,0.1);
        }
        .mini-cal-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
        }
        .mini-cal-dow {
            text-align: center;
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0.2rem 0;
        }
        .mini-cal-day {
            text-align: center;
            font-size: 0.72rem;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 600;
            padding: 0.25rem 0;
            border-radius: 0.375rem;
            cursor: pointer;
            color: var(--text-secondary);
            transition: all 0.15s ease;
            position: relative;
        }
        .mini-cal-day:hover {
            background: rgba(124,58,237,0.12);
            color: var(--color-accent-light);
        }
        .mini-cal-day.today {
            background: linear-gradient(135deg, var(--color-accent), var(--color-primary-light));
            color: white !important;
            box-shadow: 0 2px 8px rgba(124,58,237,0.4);
        }
        .mini-cal-day.other-month { color: var(--text-muted); opacity: 0.4; }
        .mini-cal-day.has-event::after {
            content: '';
            position: absolute;
            bottom: 1px; left: 50%; transform: translateX(-50%);
            width: 3px; height: 3px;
            border-radius: 50%;
            background: var(--color-neon-blue);
        }
        .mini-cal-day.selected {
            background: rgba(0,212,255,0.15);
            color: var(--color-neon-blue);
            border: 1px solid rgba(0,212,255,0.3);
        }

        /* ── View Switcher ── */
        .view-switcher {
            display: flex;
            gap: 0.25rem;
            background: var(--bg-surface-2);
            border: 1px solid var(--border-color);
            border-radius: 0.625rem;
            padding: 0.2rem;
        }
        .view-btn {
            flex: 1;
            padding: 0.3rem 0.5rem;
            border-radius: 0.4rem;
            border: none;
            background: transparent;
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            font-size: 0.72rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.18s ease;
            white-space: nowrap;
        }
        .view-btn:hover { color: var(--text-primary); }
        .view-btn.active {
            background: linear-gradient(135deg, var(--color-accent), var(--color-primary-light));
            color: white;
            box-shadow: 0 2px 8px rgba(124,58,237,0.35);
        }

        /* ── Legenda item ── */
        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.875rem;
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-family: 'Inter', sans-serif;
        }
        .legend-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ── Calendar header override (sembunyikan toolbar bawaan FC) ── */
        .fc .fc-toolbar { display: none !important; }

        /* ── Custom header ── */
        .cal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            margin-bottom: 0.875rem;
            flex-wrap: wrap;
        }
        .cal-header-title {
            font-family: 'Rajdhani', sans-serif;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            color: var(--text-primary);
        }
        .cal-nav-btn {
            width: 2rem; height: 2rem;
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            background: var(--bg-surface-2);
            color: var(--text-muted);
            cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.15s ease;
        }
        .cal-nav-btn:hover {
            border-color: var(--color-accent);
            color: var(--color-accent-light);
            background: rgba(124,58,237,0.1);
        }
        .cal-today-btn {
            padding: 0.3rem 0.75rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(0,212,255,0.3);
            background: rgba(0,212,255,0.08);
            color: var(--color-neon-blue);
            font-family: 'Rajdhani', sans-serif;
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .cal-today-btn:hover { background: rgba(0,212,255,0.15); }
    </style>
@endpush

@section('content')
<div class="pt-2 animate-fade-in">
    <div class="lg:hidden gaming-card-flat p-3 mb-3">
        <div class="flex gap-2">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 pointer-events-none" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <input type="date" id="filter-date-mobile" class="gaming-input pl-9 text-xs" style="padding:6px 10px 6px 2.5rem;" onchange="filterByDate(this.value)">
            </div>
            <button onclick="filterByDate(document.getElementById('filter-date-mobile').value)" class="btn btn-primary btn-sm">Cari</button>
            <button onclick="resetFilter()" class="btn btn-secondary btn-sm">Reset</button>
        </div>
    </div>

    {{-- Layout 2 kolom --}}
    <div class="cal-layout">

        {{-- ── SIDEBAR KIRI ── --}}
        <aside class="cal-sidebar hidden lg:flex">

            {{-- Weekly Meeting Info --}}
            @php $wm = $weeklyMeetings->first(); @endphp
            <div id="weekly-panel" class="cal-sidebar-panel" style="border-color:rgba(0,212,255,0.25);background:linear-gradient(135deg,rgba(0,212,255,0.05),rgba(124,58,237,0.05));">
                <div class="cal-sidebar-panel-header flex items-center justify-between" style="border-bottom-color:rgba(0,212,255,0.15);">
                    <span style="color:var(--text-muted);font-size:0.6rem;letter-spacing:0.12em;">Mingguan Berulang</span>
                    @if(in_array(auth()->user()->role, ['admin', 'hr']))
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="openWeeklyEdit({{ $wm?->id ?? 0 }})" class="p-1 rounded-lg transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.color='var(--color-neon-blue)'" onmouseout="this.style.color='var(--text-muted)'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
                        <button type="button" onclick="deleteWeekly({{ $wm?->id ?? 0 }})" class="p-1 rounded-lg transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='var(--text-muted)'">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="p-3 space-y-2">
                    @if($wm)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-neon-blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <p id="weekly-panel-title" class="text-sm font-semibold" style="color:var(--text-primary);">{{ $wm->title }}</p>
                    </div>
                    <div class="space-y-1">
                            <p id="weekly-panel-day" class="flex items-center gap-1.5 text-xs" style="color:var(--text-secondary);">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" style="color:var(--color-neon-blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Setiap <span id="weekly-panel-day-text">{{ $days[$wm->day_of_week] ?? 'Hari' }}</span>
                            </p>
                            <p id="weekly-panel-time" class="flex items-center gap-1.5 text-xs" style="color:var(--text-secondary);">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" style="color:var(--color-neon-blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span id="weekly-panel-time-text">{{ substr($wm->start_time, 0, 5) }} – {{ substr($wm->end_time, 0, 5) }}</span>
                            </p>
                            <p id="weekly-panel-room" class="flex items-center gap-1.5 text-xs" style="color:var(--text-secondary);">
                                <svg class="w-3.5 h-3.5 flex-shrink-0" style="color:var(--color-neon-blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span id="weekly-panel-room-text">{{ $wm->room->name ?? '-' }}</span>
                            </p>
                    </div>
                    @else
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-neon-blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        <p class="text-sm font-semibold" style="color:var(--text-primary);">Weekly Meeting</p>
                    </div>
                    <div class="space-y-1">
                        <p class="flex items-center gap-1.5 text-xs" style="color:var(--text-secondary);">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" style="color:var(--color-neon-blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Setiap Senin
                        </p>
                        <p class="flex items-center gap-1.5 text-xs" style="color:var(--text-secondary);">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" style="color:var(--color-neon-blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            13:00 – selesai
                        </p>
                        <p class="flex items-center gap-1.5 text-xs" style="color:var(--text-secondary);">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" style="color:var(--color-neon-blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Meeting Room Utama
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Mini Calendar --}}
            <div class="cal-sidebar-panel cal-sidebar-panel-full">
                <div class="cal-sidebar-panel-header">Navigasi</div>
                <div class="mini-cal">
                    <div class="mini-cal-header">
                        <button class="mini-cal-nav" onclick="miniCalPrev()">
                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <span class="mini-cal-title" id="mini-cal-title"></span>
                        <button class="mini-cal-nav" onclick="miniCalNext()">
                            <svg width="10" height="10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                    <div class="mini-cal-grid" id="mini-cal-grid"></div>
                </div>
            </div>

            {{-- Legenda --}}
            <div class="cal-sidebar-panel cal-sidebar-panel-full">
                <div class="cal-sidebar-panel-header">Legenda</div>
                <div class="py-1">
                    <div class="legend-item">
                        <span class="legend-dot" style="background:#3b82f6;box-shadow:0 0 5px rgba(59,130,246,0.6);"></span> Di Booking
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background:#7c3aed;box-shadow:0 0 5px rgba(124,58,237,0.6);"></span> Berlangsung
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background:#f97316;box-shadow:0 0 5px rgba(249,115,22,0.6);"></span> Antrian
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background:#6b7280;"></span> Selesai
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background:#00d4ff;box-shadow:0 0 5px rgba(0,212,255,0.6);"></span> Mingguan
                    </div>
                </div>
                <div class="px-3 pb-2.5">
                    <span id="last-update" class="text-xs" style="color:var(--text-muted);"></span>
                </div>
            </div>

        </aside>

        {{-- Edit Weekly Modal --}}
        <div id="weekly-edit-modal" style="display:none;position:fixed;inset:0;background:var(--bg-overlay);z-index:999;align-items:center;justify-content:center;padding:16px;">
            <div style="width:100%;max-width:420px;background:var(--bg-surface);border-radius:1.25rem;border:1px solid var(--border-color);box-shadow:var(--shadow-lg);overflow:hidden;" onclick="event.stopPropagation()">
                <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);">
                    <h3 id="weekly-modal-title" class="text-sm font-bold" style="color:var(--text-primary);">Edit Jadwal Mingguan</h3>
                    <button type="button" onclick="closeModal('weekly-edit-modal')" class="p-1 rounded-lg transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <form id="weekly-edit-form" method="POST" class="p-5 space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs font-semibold mb-1" style="color:var(--text-muted);">Judul</label>
                        <input type="text" name="title" id="we-title" required class="w-full px-3 py-2 rounded-xl text-sm" style="border:1px solid var(--border-color);background:var(--bg-surface-2);color:var(--text-primary);outline:none;">
                    </div>
                    <div>
                        <label class="text-xs font-semibold mb-1" style="color:var(--text-muted);">Ruangan</label>
                        <div style="position:relative;">
                            <select name="room_id" id="we-room" required class="w-full px-3 py-2 rounded-xl text-sm" style="appearance:none;-webkit-appearance:none;border:1px solid var(--border-color);background:var(--bg-surface-2);color:var(--text-primary);outline:none;padding-right:2rem;">
                                @foreach($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                            <svg style="position:absolute;right:10px;top:50%;transform:translateY(-50%);pointer-events:none;color:var(--text-muted);" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-semibold mb-1" style="color:var(--text-muted);">Hari</label>
                        <div style="position:relative;">
                            <select name="day_of_week" id="we-day" required class="w-full px-3 py-2 rounded-xl text-sm" style="appearance:none;-webkit-appearance:none;border:1px solid var(--border-color);background:var(--bg-surface-2);color:var(--text-primary);outline:none;padding-right:2rem;">
                                @foreach($days as $val => $label)
                                <option value="{{ $val }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <svg style="position:absolute;right:10px;top:50%;transform:translateY(-50%);pointer-events:none;color:var(--text-muted);" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold mb-1" style="color:var(--text-muted);">Jam Mulai</label>
                            <input type="time" name="start_time" id="we-start" required class="w-full px-3 py-2 rounded-xl text-sm" style="border:1px solid var(--border-color);background:var(--bg-surface-2);color:var(--text-primary);outline:none;">
                        </div>
                        <div>
                            <label class="text-xs font-semibold mb-1" style="color:var(--text-muted);">Jam Selesai</label>
                            <input type="time" name="end_time" id="we-end" required class="w-full px-3 py-2 rounded-xl text-sm" style="border:1px solid var(--border-color);background:var(--bg-surface-2);color:var(--text-primary);outline:none;">
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="we-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                        <label for="we-active" class="text-xs" style="color:var(--text-secondary);cursor:pointer;">Jadwal Aktif</label>
                    </div>
                    <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                        <button type="submit" class="flex-1 px-4 py-2 rounded-xl text-sm font-semibold text-white transition" style="background:#10b981;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">Simpan</button>
                        <button type="button" onclick="closeModal('weekly-edit-modal')" class="flex-1 px-4 py-2 rounded-xl text-sm font-semibold transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);">Batal</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MAIN CALENDAR --}}
        <div class="cal-main">
            <div class="calendar-wrapper">

                {{-- Custom Header --}}
                <div class="cal-header">
                    <div class="flex items-center gap-2">
                        <button class="cal-nav-btn" onclick="calPrev()">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button class="cal-nav-btn" onclick="calNext()">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </button>
                        <h2 class="cal-header-title" id="cal-header-title"></h2>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="cal-today-btn" onclick="calToday()">Hari Ini</button>
                        {{-- Desktop view switcher --}}
                        <div class="view-switcher hidden lg:flex">
                            <button class="view-btn active" id="desk-btn-timeGridWeek" onclick="switchView('timeGridWeek')">Minggu</button>
                            <button class="view-btn" id="desk-btn-dayGridMonth" onclick="switchView('dayGridMonth')">Bulan</button>
                            <button class="view-btn" id="desk-btn-timeGridDay" onclick="switchView('timeGridDay')">Hari</button>
                            <button class="view-btn" id="desk-btn-listWeek" onclick="switchView('listWeek')">List</button>
                        </div>
                    </div>
                </div>

                <div id="calendar"></div>
            </div>
        </div>

    </div>
</div>

{{-- Event Detail Modal --}}
<div id="event-modal">
    <div id="modal-card">
        {{-- Header --}}
        <div id="modal-header" class="p-4 sm:p-5 text-white">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-widest opacity-70 mb-1" style="font-family:'Rajdhani',sans-serif;">Detail Meeting</p>
                    <h3 id="modal-title" class="font-bold text-base sm:text-lg leading-tight" style="font-family:'Rajdhani',sans-serif;"></h3>
                </div>
                <button onclick="closeModal()" class="flex-shrink-0 w-7 h-7 rounded-lg flex items-center justify-center transition" style="background:rgba(255,255,255,0.15);color:white;border:none;cursor:pointer;" onmouseover="this.style.background='rgba(255,255,255,0.25)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Body --}}
        <div class="p-4 sm:p-5 space-y-2.5">
            <div class="grid grid-cols-2 gap-2">
                <div class="modal-info-item">
                    <p class="text-xs mb-0.5" style="color:var(--text-muted);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;text-transform:uppercase;font-size:0.62rem;">Ruangan</p>
                    <p id="modal-room" class="text-sm font-semibold truncate" style="color:var(--text-primary);"></p>
                </div>
                <div class="modal-info-item">
                    <p class="text-xs mb-0.5" style="color:var(--text-muted);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;text-transform:uppercase;font-size:0.62rem;">Tim</p>
                    <p id="modal-team" class="text-sm font-semibold truncate" style="color:var(--text-primary);"></p>
                </div>
                <div class="modal-info-item">
                    <p class="text-xs mb-0.5" style="color:var(--text-muted);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;text-transform:uppercase;font-size:0.62rem;">Jam Mulai</p>
                    <p id="modal-start" class="text-sm font-bold" style="color:var(--color-neon-blue);font-family:'Rajdhani',sans-serif;font-size:1rem;"></p>
                </div>
                <div class="modal-info-item">
                    <p id="modal-end-label" class="text-xs mb-0.5" style="color:var(--text-muted);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;text-transform:uppercase;font-size:0.62rem;">Jam Selesai</p>
                    <p id="modal-end" class="text-sm font-bold" style="color:var(--color-neon-blue);font-family:'Rajdhani',sans-serif;font-size:1rem;"></p>
                </div>
            </div>

            <div id="modal-actual-wrap" class="hidden modal-info-item" style="border-color:rgba(16,185,129,0.3);background:rgba(16,185,129,0.06);">
                <p class="text-xs mb-0.5" style="color:#10b981;font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;text-transform:uppercase;font-size:0.62rem;">Jam Selesai Aktual</p>
                <p id="modal-actual" class="text-sm font-bold" style="color:#34d399;font-family:'Rajdhani',sans-serif;font-size:1rem;"></p>
            </div>

            <div class="modal-info-item flex items-center justify-between">
                <p class="text-xs" style="color:var(--text-muted);font-family:'Rajdhani',sans-serif;letter-spacing:0.06em;text-transform:uppercase;font-size:0.62rem;">Status</p>
                <span id="modal-rt-status" class="px-3 py-1 rounded-full text-xs font-semibold" style="font-family:'Rajdhani',sans-serif;letter-spacing:0.04em;"></span>
            </div>

            <button onclick="closeModal()" class="btn btn-secondary w-full mt-1" style="justify-content:center;">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    let calendar;
    let currentEventId = null;
    let miniCalDate = new Date();
    let eventDates = new Set();
    const isMobile = () => window.innerWidth < 1024;

    const MONTHS_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    const DAYS_ID   = ['Min','Sen','Sel','Rab','Kam','Jum','Sab'];

    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: isMobile() ? 'listWeek' : 'timeGridWeek',
            locale: 'id',
            headerToolbar: false,
            events: '{{ route("calendar.events") }}',
            eventClick: function (info) {
                const p = info.event.extendedProps;
                currentEventId = p.meeting_id;
                showModal(info.event.title, p);
            },
            eventDidMount: function(info) {
                info.el.style.opacity = '0';
                info.el.style.transform = 'translateY(4px)';
                info.el.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                requestAnimationFrame(() => {
                    info.el.style.opacity = '1';
                    info.el.style.transform = 'translateY(0)';
                });
                // Kumpulkan tanggal event untuk mini calendar
                if (info.event.start) {
                    eventDates.add(info.event.start.toISOString().slice(0,10));
                    renderMiniCal();
                }
            },
            datesSet: function(info) {
                updateHeader();
                miniCalDate = calendar.getDate();
                renderMiniCal();
            },
            height: isMobile() ? 'auto' : 620,
            slotMinTime: '07:00:00',
            slotMaxTime: '21:00:00',
            listDayFormat: { weekday: 'long', day: 'numeric', month: 'long' },
            noEventsText: 'Tidak ada meeting',
            windowResize: function() {
                calendar.setOption('height', isMobile() ? 'auto' : 620);
            }
        });

        calendar.render();
        updateHeader();
        renderMiniCal();

        setInterval(refreshRealtimeStatus, 30000);
        setInterval(refreshWeeklyStatus, 30000);
        refreshRealtimeStatus();
        refreshWeeklyStatus();
    });

    /* ── Header & Navigasi ── */
    function updateHeader() {
        if (!calendar) return;
        const date  = calendar.getDate();
        const view  = calendar.view.type;
        let title   = '';

        if (view === 'dayGridMonth') {
            title = MONTHS_ID[date.getMonth()] + ' ' + date.getFullYear();
        } else if (view === 'timeGridWeek' || view === 'listWeek') {
            const start = calendar.view.currentStart;
            const end   = new Date(calendar.view.currentEnd - 1);
            if (start.getMonth() === end.getMonth()) {
                title = MONTHS_ID[start.getMonth()] + ' ' + start.getFullYear();
            } else {
                title = MONTHS_ID[start.getMonth()] + ' – ' + MONTHS_ID[end.getMonth()] + ' ' + end.getFullYear();
            }
        } else if (view === 'timeGridDay') {
            title = date.getDate() + ' ' + MONTHS_ID[date.getMonth()] + ' ' + date.getFullYear();
        }

        const el = document.getElementById('cal-header-title');
        if (el) el.textContent = title;
    }

    function calPrev()  { calendar.prev();  updateHeader(); miniCalDate = calendar.getDate(); renderMiniCal(); }
    function calNext()  { calendar.next();  updateHeader(); miniCalDate = calendar.getDate(); renderMiniCal(); }
    function calToday() { calendar.today(); updateHeader(); miniCalDate = calendar.getDate(); renderMiniCal(); }

    /* ── View Switcher ── */
    function switchView(view) {
        calendar.changeView(view);
        updateHeader();

        // Update semua tombol view (sidebar + desktop header + mobile)
        ['timeGridWeek','dayGridMonth','timeGridDay','listWeek'].forEach(v => {
            ['btn-','desk-btn-','mob-btn-'].forEach(prefix => {
                const el = document.getElementById(prefix + v);
                if (el) el.classList.toggle('active', v === view);
            });
        });
    }

    /* ── Mini Calendar ── */
    function renderMiniCal() {
        const titleEl = document.getElementById('mini-cal-title');
        const gridEl  = document.getElementById('mini-cal-grid');
        if (!titleEl || !gridEl) return;

        const year  = miniCalDate.getFullYear();
        const month = miniCalDate.getMonth();
        titleEl.textContent = MONTHS_ID[month] + ' ' + year;

        const today    = new Date();
        const selected = calendar ? calendar.getDate() : today;
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        let html = DAYS_ID.map(d => `<div class="mini-cal-dow">${d}</div>`).join('');

        // Padding hari sebelumnya
        const prevDays = new Date(year, month, 0).getDate();
        for (let i = firstDay - 1; i >= 0; i--) {
            html += `<div class="mini-cal-day other-month">${prevDays - i}</div>`;
        }

        for (let d = 1; d <= daysInMonth; d++) {
            const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
            const isToday    = today.getFullYear()===year && today.getMonth()===month && today.getDate()===d;
            const isSelected = selected.getFullYear()===year && selected.getMonth()===month && selected.getDate()===d;
            const hasEvent   = eventDates.has(dateStr);

            let cls = 'mini-cal-day';
            if (isToday)    cls += ' today';
            if (isSelected && !isToday) cls += ' selected';
            if (hasEvent)   cls += ' has-event';

            html += `<div class="${cls}" onclick="miniCalGoto('${dateStr}')">${d}</div>`;
        }

        // Padding hari sesudahnya
        const totalCells = firstDay + daysInMonth;
        const remaining  = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
        for (let d = 1; d <= remaining; d++) {
            html += `<div class="mini-cal-day other-month">${d}</div>`;
        }

        gridEl.innerHTML = html;
    }

    function miniCalPrev() { miniCalDate = new Date(miniCalDate.getFullYear(), miniCalDate.getMonth() - 1, 1); renderMiniCal(); }
    function miniCalNext() { miniCalDate = new Date(miniCalDate.getFullYear(), miniCalDate.getMonth() + 1, 1); renderMiniCal(); }

    function miniCalGoto(dateStr) {
        calendar.gotoDate(dateStr);
        calendar.changeView('timeGridDay');
        switchView('timeGridDay');
        updateHeader();
        renderMiniCal();
    }

    /* ── Filter ── */
    function filterByDate(val) {
        const date = val || document.getElementById('filter-date-mobile')?.value;
        if (date) {
            calendar.gotoDate(date);
            switchView('timeGridDay');
        }
    }

    function resetFilter() {
        const inp = document.getElementById('filter-date-mobile');
        if (inp) inp.value = '';
        calendar.today();
        switchView(isMobile() ? 'listWeek' : 'timeGridWeek');
        miniCalDate = new Date();
        renderMiniCal();
    }

    /* ── Modal ── */
    function showModal(title, p) {
        document.getElementById('modal-title').textContent     = title.split(' (Selesai')[0];
        document.getElementById('modal-room').textContent      = p.room  || '-';
        document.getElementById('modal-team').textContent      = p.team  || '-';
        document.getElementById('modal-start').textContent     = p.start_time || '-';
        document.getElementById('modal-end').textContent       = p.end_time   || '-';
        document.getElementById('modal-end-label').textContent = p.actual_end_time ? 'Jam Selesai (Est.)' : 'Jam Selesai';

        const color = p.rt_dot || '#1e3a5f';
        document.getElementById('modal-header').style.background = `linear-gradient(135deg, ${color}dd, ${color}88)`;

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
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.getElementById('event-modal').classList.remove('show');
        document.body.style.overflow = '';
        currentEventId = null;
    }

    function getRtStyle(label) {
        if (!label) return '';
        if (label.includes('Berlangsung')) return 'background:rgba(124,58,237,0.15);color:#a78bfa;border:1px solid rgba(124,58,237,0.3);';
        if (label.includes('Antrian'))     return 'background:rgba(249,115,22,0.15);color:#fb923c;border:1px solid rgba(249,115,22,0.3);';
        if (label.includes('Di Booking'))  return 'background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);';
        if (label.includes('Selesai'))     return 'background:rgba(107,114,128,0.15);color:#9ca3af;border:1px solid rgba(107,114,128,0.3);';
        if (label.includes('Mingguan'))    return 'background:rgba(0,212,255,0.15);color:#00d4ff;border:1px solid rgba(0,212,255,0.3);';
        return 'background:rgba(148,163,184,0.15);color:#94a3b8;border:1px solid rgba(148,163,184,0.3);';
    }

    /* ── Realtime ── */
    function refreshRealtimeStatus() {
        fetch('{{ route("realtime.meetings") }}')
            .then(r => r.json())
            .then(data => {
                data.forEach(m => {
                    calendar.getEvents()
                        .filter(e => e.extendedProps.meeting_id === m.id)
                        .forEach(e => {
                            e.setProp('color', m.rt_dot);
                            e.setExtendedProp('rt_label', m.rt_label);
                            e.setExtendedProp('rt_dot', m.rt_dot);
                        });
                });
                if (currentEventId) {
                    const cur = data.find(m => m.id === currentEventId);
                    if (cur) {
                        const rtEl = document.getElementById('modal-rt-status');
                        if (rtEl) {
                            rtEl.textContent   = cur.rt_label;
                            rtEl.style.cssText = getRtStyle(cur.rt_label);
                            document.getElementById('modal-header').style.background =
                                `linear-gradient(135deg, ${cur.rt_dot}dd, ${cur.rt_dot}88)`;
                        }
                    }
                }
                const el = document.getElementById('last-update');
                if (el) el.textContent = '⟳ ' + new Date().toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit'});
            }).catch(() => {});
    }

    function refreshWeeklyStatus() {
        fetch('{{ route("realtime.weekly") }}')
            .then(r => r.json())
            .then(data => {
                data.forEach(s => {
                    calendar.getEvents()
                        .filter(e => e.extendedProps.weekly_id && e.start &&
                            e.start.toISOString().startsWith(s.date))
                        .forEach(e => {
                            e.setProp('color', s.rt_dot);
                            e.setExtendedProp('rt_label', s.rt_label);
                            if (s.rt_label === 'Sedang Berlangsung')
                                e.setProp('title', '🔁 ' + s.title + ' — Sedang Berlangsung');
                            else if (s.rt_label === 'Selesai') {
                                e.setProp('title', '🔁 ' + s.title + ' (Selesai)');
                                e.setProp('color', '#6b7280');
                            }
                        });
                });
            }).catch(() => {});
    }

    // ── Weekly Meeting Edit/Delete ──
    const weeklyData = @json($weeklyData);

    var firstRoomId = {{ $rooms->first()?->id ?? 'null' }};
    function openWeeklyEdit(id) {
        const modal = document.getElementById('weekly-edit-modal');
        const form = document.getElementById('weekly-edit-form');
        const title = document.getElementById('weekly-modal-title');
        if (!id) {
            title.textContent = 'Tambah Jadwal Mingguan';
            form.action = '/admin/weekly-meetings';
            document.getElementById('we-title').value = 'Weekly Meeting';
            if (firstRoomId !== null) document.getElementById('we-room').value = firstRoomId;
            document.getElementById('we-day').value = '1';
            document.getElementById('we-start').value = '13:00';
            document.getElementById('we-end').value = '14:00';
            document.getElementById('we-active').checked = true;
            openModal('weekly-edit-modal');
            return;
        }
        const w = weeklyData.find(i => i.id === id);
        if (!w) return;
        title.textContent = 'Edit Jadwal Mingguan';
        form.action = '/admin/weekly-meetings/' + id;
        document.getElementById('we-title').value = w.title;
        document.getElementById('we-room').value = w.room_id;
        document.getElementById('we-day').value = w.day_of_week;
        document.getElementById('we-start').value = w.start_time;
        document.getElementById('we-end').value = w.end_time;
        document.getElementById('we-active').checked = w.is_active;
        openModal('weekly-edit-modal');
    }

    function closeWeeklyEdit() {
        closeModal('weekly-edit-modal');
    }

    document.getElementById('weekly-edit-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeModal('weekly-edit-modal');
    });

    document.getElementById('weekly-edit-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';
        const body = new URLSearchParams(new FormData(this));
        const isUpdate = this.action.match(/\/admin\/weekly-meetings\/(\d+)$/);
        if (isUpdate) {
            body.set('_method', 'PUT');
        }
        fetch(this.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: body
        }).then(r => {
            if (!r.ok) throw new Error('Gagal menyimpan');
            return r.json();
        }).then(() => {
            // Baca nilai dari form
            const title = document.getElementById('we-title').value.trim();
            const roomId = parseInt(document.getElementById('we-room').value);
            const dayOfWeek = parseInt(document.getElementById('we-day').value);
            const startTime = document.getElementById('we-start').value;
            const endTime = document.getElementById('we-end').value;
            const isActive = document.getElementById('we-active').checked;
            const roomSelect = document.getElementById('we-room');
            const roomName = roomSelect.options[roomSelect.selectedIndex]?.text || '';
            const dayNames = {1:'Senin',2:'Selasa',3:'Rabu',4:'Kamis',5:'Jumat',6:'Sabtu',7:'Minggu'};
            const dayName = dayNames[dayOfWeek] || 'Hari';

            // Update weeklyData di memori (untuk edit selanjutnya)
            if (isUpdate) {
                const id = parseInt(isUpdate[1]);
                const idx = weeklyData.findIndex(i => i.id === id);
                if (idx !== -1) {
                    weeklyData[idx] = {
                        ...weeklyData[idx],
                        title: title, room_id: roomId, day_of_week: dayOfWeek,
                        start_time: startTime, end_time: endTime,
                        is_active: isActive, room_name: roomName
                    };
                }
            }

            // Update sidebar panel
            const titleEl = document.getElementById('weekly-panel-title');
            if (titleEl) titleEl.textContent = title;
            const dayTextEl = document.getElementById('weekly-panel-day-text');
            if (dayTextEl) dayTextEl.textContent = dayName;
            const timeTextEl = document.getElementById('weekly-panel-time-text');
            if (timeTextEl) timeTextEl.textContent = startTime + ' \u2013 ' + endTime;
            const roomTextEl = document.getElementById('weekly-panel-room-text');
            if (roomTextEl) roomTextEl.textContent = roomName;

            // Refetch calendar events — langsung tampilkan perubahan
            if (calendar) calendar.refetchEvents();

            closeModal('weekly-edit-modal');
        }).catch(() => {
            location.reload();
        }).finally(() => {
            btn.disabled = false;
            btn.textContent = 'Simpan';
        });
    });

    function deleteWeekly(id) {
        if (!id) return;
        if (!confirm('Hapus jadwal mingguan ini?')) return;
        fetch('/admin/weekly-meetings/' + id, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: new URLSearchParams({ _method: 'DELETE' })
        }).then(() => {
            // Hapus dari weeklyData
            const idx = weeklyData.findIndex(i => i.id === id);
            if (idx !== -1) weeklyData.splice(idx, 1);
            // Refetch events & sembunyikan panel
            if (calendar) calendar.refetchEvents();
            const panel = document.getElementById('weekly-panel');
            if (panel) panel.style.display = 'none';
        }).catch(() => { location.reload(); });
    }

    // Tutup modal
    document.getElementById('event-modal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
</script>
@endpush
