@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', $jenisLabels[$jenis])
@section('page-title', 'Pembayaran')
@section('page-subtitle', $jenis === 'internet' ? 'Data WiFi prabayar — Indosat billing tgl 5, IndiHome billing tgl 20. Input setelah bayar.' : 'Kelola tagihan '.$jenisLabels[$jenis])
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<script>window.INLINE_TEST = 'WORKS';</script>
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- Stat Cards --}}
    @if($jenis === 'internet')

    @php
        $alertGroups = collect();
        if (isset($alerts) && $alerts->isNotEmpty()) {
            $alertGroups = $alerts->groupBy(function($w) {
                $s = $w->status_internet;
                if ($s === 'mati') return 'mati';
                if ($s === 'segera_habis') return 'segera_habis';
                if ($s === 'jatuh_tempo') return 'jatuh_tempo';
                return 'other';
            });
        }
    @endphp
    @if(isset($alerts) && $alerts->isNotEmpty())
    @if(isset($alertGroups['mati']))
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:#ef4444;">WiFi Mati</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);">
                {{ $alertGroups['mati']->count() }} WiFi dengan masa tenggang sudah lewat.
                <button type="button" onclick="setFilter('mati')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
    </div>
    @endif
    @if(isset($alertGroups['segera_habis']))
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:#f59e0b;">Segera Habis</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);">
                {{ $alertGroups['segera_habis']->count() }} WiFi akan segera habis masa tenggangnya (≤3 hari).
                <button type="button" onclick="setFilter('segera_habis')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
    </div>
    @endif
    @if(isset($alertGroups['jatuh_tempo']))
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.25);">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f97316;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:#f97316;">Jatuh Tempo</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);">
                {{ $alertGroups['jatuh_tempo']->count() }} WiFi akan jatuh tempo (≤7 hari).
                <button type="button" onclick="setFilter('jatuh_tempo')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
    </div>
    @endif
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:none rgba(124,58,237,0.25);">
                <svg class="w-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01M3.5 13.58a10.5 10.5 0 0117 0"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-primary);">Total WiFi</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh data WiFi</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:none rgba(16,185,129,0.2);">
                <svg class="w-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#34d399;">{{ $stats['aktif'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Aktif</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(249,115,22,0.15);box-shadow:none rgba(249,115,22,0.2);">
                <svg class="w-[18px]" style="color:#fb923c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#fb923c;">{{ $stats['jatuh_tempo'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Jatuh Tempo</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:none rgba(245,158,11,0.2);">
                <svg class="w-[18px]" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#f59e0b;">{{ $stats['segera_habis'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Segera Habis</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:none rgba(239,68,68,0.2);">
                <svg class="w-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;">{{ $stats['mati'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Mati</div>
                
            </div>
        </div>
    </div>
    @elseif($jenis === 'aset_digital')

    @php
        $alertGroups = collect();
        if (isset($alerts) && $alerts->isNotEmpty()) {
            $alertGroups = $alerts->groupBy(function($a) {
                if ($a->status_digital === 'mati') return 'mati';
                if ($a->status_digital === 'segera_habis') return 'segera_habis';
                if ($a->status_digital === 'jatuh_tempo') return 'jatuh_tempo';
                return 'other';
            });
        }
    @endphp
    @if(isset($alerts) && $alerts->isNotEmpty())
    @if(isset($alertGroups['mati']))
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:#ef4444;">Lewat Jatuh Tempo</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);">
                {{ $alertGroups['mati']->count() }} Aset Digital lewat jatuh tempo.
                <button type="button" onclick="setFilter('mati')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
    </div>
    @endif
    @if(isset($alertGroups['segera_habis']))
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:#f59e0b;">Segera Jatuh Tempo</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);">
                {{ $alertGroups['segera_habis']->count() }} Aset Digital akan segera jatuh tempo (≤3 hari).
                <button type="button" onclick="setFilter('segera_habis')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
    </div>
    @endif
    @if(isset($alertGroups['jatuh_tempo']))
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.25);">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f97316;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:#f97316;">Jatuh Tempo</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);">
                {{ $alertGroups['jatuh_tempo']->count() }} Aset Digital akan jatuh tempo (≤7 hari).
                <button type="button" onclick="setFilter('jatuh_tempo')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
    </div>
    @endif
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:none rgba(124,58,237,0.25);">
                <svg class="w-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-primary);">Total Aset Digital</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">{{ $stats['total'] }} tagihan</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:none rgba(16,185,129,0.2);">
                <svg class="w-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#34d399;">{{ $stats['aktif'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Aktif</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(249,115,22,0.15);box-shadow:none rgba(249,115,22,0.2);">
                <svg class="w-[18px]" style="color:#fb923c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#fb923c;">{{ $stats['jatuh_tempo'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Jatuh Tempo</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:none rgba(245,158,11,0.2);">
                <svg class="w-[18px]" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#f59e0b;">{{ $stats['segera_habis'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Segera Habis</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:none rgba(239,68,68,0.2);">
                <svg class="w-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;">{{ $stats['mati'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Mati</div>
                
            </div>
        </div>
    </div>
    @elseif($jenis === 'ipl_ruko')

    @php
        $alertGroups = collect();
        if (isset($alerts) && $alerts->isNotEmpty()) {
            $alertGroups = $alerts->groupBy(function($a) {
                if ($a->status_ipl === 'mati') return 'mati';
                if ($a->status_ipl === 'segera_habis') return 'segera_habis';
                if ($a->status_ipl === 'jatuh_tempo') return 'jatuh_tempo';
                return 'other';
            });
        }
    @endphp
    @if(isset($alerts) && $alerts->isNotEmpty())
    @if(isset($alertGroups['mati']))
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:#ef4444;">Lewat Jatuh Tempo</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);">
                {{ $alertGroups['mati']->count() }} IPL Ruko lewat jatuh tempo.
                <button type="button" onclick="setFilter('mati')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
    </div>
    @endif
    @if(isset($alertGroups['segera_habis']))
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:#f59e0b;">Segera Jatuh Tempo</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);">
                {{ $alertGroups['segera_habis']->count() }} IPL Ruko akan segera jatuh tempo (≤3 hari).
                <button type="button" onclick="setFilter('segera_habis')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
    </div>
    @endif
    @if(isset($alertGroups['jatuh_tempo']))
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:rgba(249,115,22,0.1);border:1px solid rgba(249,115,22,0.25);">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f97316;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:#f97316;">Jatuh Tempo</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);">
                {{ $alertGroups['jatuh_tempo']->count() }} IPL Ruko akan jatuh tempo (≤7 hari).
                <button type="button" onclick="setFilter('jatuh_tempo')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
    </div>
    @endif
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:none rgba(124,58,237,0.25);">
                <svg class="w-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-primary);">Total IPL Ruko</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">{{ $stats['total'] }} tagihan</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:none rgba(16,185,129,0.2);">
                <svg class="w-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#34d399;">{{ $stats['aktif'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Aktif</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(249,115,22,0.15);box-shadow:none rgba(249,115,22,0.2);">
                <svg class="w-[18px]" style="color:#fb923c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#fb923c;">{{ $stats['jatuh_tempo'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Jatuh Tempo</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:none rgba(245,158,11,0.2);">
                <svg class="w-[18px]" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#f59e0b;">{{ $stats['segera_habis'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Segera Habis</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:none rgba(239,68,68,0.2);">
                <svg class="w-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;">{{ $stats['mati'] }}</div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Mati</div>
                
            </div>
        </div>
    </div>
    @elseif($jenis !== 'listrik')
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:0 0 16px rgba(124,58,237,0.25);">
                <svg class="w-6 h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2H9a3 3 0 013-3V7a2 2 0 012 2h-2zm0 8a3 3 0 01-3-3h1a2 2 0 002 2v1zm2-4h4v2h-4v-2zm-8 0H2v2h4v-2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);">{{ $stats['total'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Total Tagihan</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $stats['total'] }} tagihan</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:0 0 16px rgba(16,185,129,0.2);">
                <svg class="w-6 h-6" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;">{{ $stats['aktif'] }}</div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Sudah Dibayar</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">Tagihan lunas</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Alert Jatuh Tempo / Masa Tenggang --}}
    @if(!in_array($jenis, ['internet', 'aset_digital', 'ipl_ruko']) && $alertItems->isNotEmpty())
        @php
            $today = now()->startOfDay();
            $redItems = collect();
            $yellowItems = collect();
            $dueField = $jenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
            foreach ($alertItems as $a) {
                $dueDate = $a->{$dueField};
                if (!$dueDate) continue;
                $dueStart = $dueDate->copy()->startOfDay();
                if ($dueStart->lte($today)) {
                    $redItems->push($a);
                } elseif ($dueStart->lte($today->copy()->addDays(3))) {
                    $yellowItems->push($a);
                }
            }
        @endphp
        @if($redItems->isNotEmpty() || $yellowItems->isNotEmpty())
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            @if($redItems->isNotEmpty())
            <div style="flex:1;min-width:280px;">
                <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-bold" style="color:#ef4444;">{{ $redItems->count() }} Lewat Jatuh Tempo</div>
                        <div class="text-xs mt-1" style="color:var(--text-secondary);">{{ $redItems->count() }} tagihan lewat jatuh tempo.</div>
                    </div>
                    <button type="button" onclick="showAlertPopup('danger')" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.25);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
                </div>
            </div>
            @endif
            @if($yellowItems->isNotEmpty())
            <div style="flex:1;min-width:280px;">
                <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-bold" style="color:#f59e0b;">{{ $yellowItems->count() }} Segera Jatuh Tempo</div>
                        <div class="text-xs mt-1" style="color:var(--text-secondary);">{{ $yellowItems->count() }} tagihan jatuh tempo dalam 3 hari.</div>
                    </div>
                    <button type="button" onclick="showAlertPopup('warning')" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.25);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
                </div>
            </div>
            @endif
        </div>
        @endif
    @endif

    {{-- Popup Detail Alert --}}
    <div id="alert-overlay" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);" onclick="if(event.target===this)closeAlertPopup()">
        <div class="w-full max-w-[460px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);" id="alert-popup-title">Detail Tagihan</h3>
                <button type="button" onclick="closeAlertPopup()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1" id="alert-popup-body"></div>
            <div class="px-6 py-4 flex-shrink-0 flex justify-end items-center" style="border-top:1px solid var(--border-color);">
                <button type="button" onclick="closeAlertPopup()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Token Listrik Alert --}}
    @if($jenis === 'listrik' && $tokenAlert)
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:{{ $tokenAlert['level'] === 'danger' ? 'rgba(239,68,68,0.1)' : ($tokenAlert['level'] === 'warning' ? 'rgba(245,158,11,0.1)' : 'rgba(59,130,246,0.1)') }};border:1px solid {{ $tokenAlert['level'] === 'danger' ? 'rgba(239,68,68,0.25)' : ($tokenAlert['level'] === 'warning' ? 'rgba(245,158,11,0.25)' : 'rgba(59,130,246,0.25)') }};">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:{{ $tokenAlert['level'] === 'danger' ? '#ef4444' : ($tokenAlert['level'] === 'warning' ? '#f59e0b' : '#3b82f6') }};" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:{{ $tokenAlert['level'] === 'danger' ? '#ef4444' : ($tokenAlert['level'] === 'warning' ? '#f59e0b' : '#3b82f6') }};">Token Listrik</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);">{{ $tokenAlert['message'] }}</div>
        </div>
    </div>
    @endif

    {{-- Pill Switcher Internet --}}
    @if($jenis === 'internet')
    <div class="flex items-center gap-1" style="border:1px solid var(--border-color);border-radius:10px;padding:3px;background:var(--bg-card);width:fit-content;margin-bottom:12px;">
        <button type="button" id="pill-internet-bayar" onclick="switchInternetTab('bayar')" style="padding:6px 14px;border:none;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;background:rgba(124,58,237,0.15);color:#a78bfa;">Pembayaran Internet</button>
        <button type="button" id="pill-internet-usage" onclick="switchInternetTab('usage')" style="padding:6px 14px;border:none;border-radius:7px;font-size:12px;font-weight:500;cursor:pointer;background:none;color:var(--text-muted);">Pengecekan Usage</button>
        <button type="button" id="pill-internet-quota-topup" onclick="switchInternetTab('quota-topup')" style="padding:6px 14px;border:none;border-radius:7px;font-size:12px;font-weight:500;cursor:pointer;background:none;color:var(--text-muted);">Pembelian Kuota</button>
        <button type="button" id="pill-internet-quota-reading" onclick="switchInternetTab('quota-reading')" style="padding:6px 14px;border:none;border-radius:7px;font-size:12px;font-weight:500;cursor:pointer;background:none;color:var(--text-muted);">Pengecekan Kuota</button>
    </div>
    @endif

    @if($jenis !== 'listrik')
    {{-- Table --}}
    <div id="internet-tab-bayar">
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Pembayaran {{ $jenisLabels[$jenis] }}</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">
                    Data tagihan {{ $jenisLabels[$jenis] }}.
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->role !== 'gm')
                <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Tagihan
                </button>
                @endif
                @if($jenis === 'ipl_ruko')
                <button type="button" onclick="openBulkIplModal()" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Generate 1 Tahun
                </button>
                @endif
            </div>
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-0 max-w-full sm:min-w-[200px] sm:max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-payment" placeholder="Cari..." oninput="filterTable()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <a href="{{ route('admin.export', ['type' => 'pembayaran', 'jenis' => $jenis, 'filter' => 'all']) }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Export</a>
                <div class="filter-dropdown-wrap" style="position:relative;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Status</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    @if($jenis === 'internet')
                    <button type="button" data-value="aktif" onclick="setFilter('aktif')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" data-value="jatuh_tempo" onclick="setFilter('jatuh_tempo')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Jatuh Tempo</button>
                    <button type="button" data-value="segera_habis" onclick="setFilter('segera_habis')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Segera Habis</button>
                    <button type="button" data-value="mati" onclick="setFilter('mati')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Mati</button>
                    @elseif($jenis === 'aset_digital')
                    <button type="button" data-value="aktif" onclick="setFilter('aktif')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" data-value="jatuh_tempo" onclick="setFilter('jatuh_tempo')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Jatuh Tempo</button>
                    <button type="button" data-value="segera_habis" onclick="setFilter('segera_habis')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Segera Habis</button>
                    <button type="button" data-value="mati" onclick="setFilter('mati')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Mati</button>
                    @elseif($jenis === 'ipl_ruko')
                    <button type="button" data-value="aktif" onclick="setFilter('aktif')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" data-value="jatuh_tempo" onclick="setFilter('jatuh_tempo')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Jatuh Tempo</button>
                    <button type="button" data-value="segera_habis" onclick="setFilter('segera_habis')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Segera Habis</button>
                    <button type="button" data-value="mati" onclick="setFilter('mati')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Mati</button>
                    <button type="button" data-value="menunggu" onclick="setFilter('menunggu')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Belum Aktif</button>
                    @else
                    <button type="button" data-value="jatuh_tempo" onclick="setFilter('jatuh_tempo')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Jatuh Tempo</button>
                    @endif
                    <button type="button" data-value="lunas" onclick="setFilter('lunas')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Lunas</button>
                    <button type="button" data-value="pending" onclick="setFilter('pending')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Menunggu</button>
                    <button type="button" data-value="rejected" onclick="setFilter('rejected')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Ditolak</button>
                </div>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[900px]" id="payment-table">
                <thead>
                    <tr>
                        <th>No</th>
                        @if($jenis === 'internet')
                            <th>Nama Internet</th>
                            <th class="hidden md:table-cell">Provider</th>
                            <th class="hidden md:table-cell">PIC</th>
                            <th class="hidden lg:table-cell">Jabatan</th>
                            <th class="hidden md:table-cell">Masa Tenggang</th>
                            <th style="color:var(--text-muted);font-size:0.65rem;">Hari</th>
                            <th class="hidden md:table-cell">Biaya</th>
                        @else
                            <th>{{ $jenis === 'aset_digital' ? 'Nama Aset' : 'Periode' }}</th>
                            @if($jenis === 'aset_digital')
                            <th class="hidden md:table-cell">Email</th>
                            <th class="hidden md:table-cell">Mulai</th>
                            <th class="hidden md:table-cell">Berakhir</th>
                            @endif
                            <th class="hidden md:table-cell">Tagihan</th>
                            <th>Jatuh Tempo</th>
                            @if(in_array($jenis, ['aset_digital', 'ipl_ruko']))
                            <th style="color:var(--text-muted);font-size:0.65rem;">Hari</th>
                            @endif
                            <th>Nominal</th>
                            @if($jenis === 'aset_digital')
                            <th>PIC</th>
                            <th class="hidden lg:table-cell">Jabatan</th>
                            <th class="hidden md:table-cell">Keterangan</th>
                            @endif
                        @endif
                        <th>Status</th>
                            <th class="hidden md:table-cell">Tgl Bayar</th>
                            <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="payment-tbody">
                    @forelse($items as $item)
                    @php
                        $itemId = $item->id;
                        if ($jenis === 'internet') {
                            $statusInternet = $item->status_internet;
                            $badgeClass = match($statusInternet) {
                                'lunas' => 'badge-green',
                                'pending' => 'badge-blue',
                                'rejected' => 'badge-red',
                                'aktif' => 'badge-green',
                                'jatuh_tempo' => 'badge-orange',
                                'segera_habis' => 'badge-yellow',
                                'mati' => 'badge-red',
                                default => 'badge-red',
                            };
                            $badgeLabel = match($statusInternet) {
                                'lunas' => 'Lunas',
                                'pending' => 'Menunggu',
                                'rejected' => 'Ditolak',
                                'aktif' => 'Aktif',
                                'jatuh_tempo' => 'Jatuh Tempo',
                                'segera_habis' => 'Segera Habis',
                                'mati' => 'Mati',
                                default => 'Nonaktif',
                            };
                            $dataStatus = $statusInternet;
                        } elseif ($jenis === 'aset_digital') {
                            $statusDigital = $item->status_digital;
                            $badgeClass = match($statusDigital) {
                                'lunas' => 'badge-green',
                                'pending' => 'badge-blue',
                                'rejected' => 'badge-red',
                                'aktif' => 'badge-green',
                                'jatuh_tempo' => 'badge-orange',
                                'segera_habis' => 'badge-yellow',
                                'mati' => 'badge-red',
                                default => 'badge-red',
                            };
                            $badgeLabel = match($statusDigital) {
                                'lunas' => 'Lunas',
                                'pending' => 'Menunggu',
                                'rejected' => 'Ditolak',
                                'aktif' => 'Aktif',
                                'jatuh_tempo' => 'Jatuh Tempo',
                                'segera_habis' => 'Segera Habis',
                                'mati' => 'Mati',
                                default => 'Nonaktif',
                            };
                            $dataStatus = $statusDigital;
                        } elseif ($jenis === 'ipl_ruko') {
                            $statusIpl = $item->status_ipl;
                            $badgeClass = match($statusIpl) {
                                'lunas' => 'badge-green',
                                'pending' => 'badge-blue',
                                'rejected' => 'badge-red',
                                'menunggu' => 'badge-gray',
                                'aktif' => 'badge-green',
                                'jatuh_tempo' => 'badge-orange',
                                'segera_habis' => 'badge-yellow',
                                'mati' => 'badge-red',
                                default => 'badge-red',
                            };
                            $badgeLabel = match($statusIpl) {
                                'lunas' => 'Lunas',
                                'pending' => 'Menunggu',
                                'rejected' => 'Ditolak',
                                'menunggu' => 'Belum Aktif',
                                'aktif' => 'Aktif',
                                'jatuh_tempo' => 'Jatuh Tempo',
                                'segera_habis' => 'Segera Habis',
                                'mati' => 'Mati',
                                default => 'Nonaktif',
                            };
                            $dataStatus = $statusIpl;
                        } else {
                            $dueDate = $item->jatuh_tempo;
                            $today = now()->startOfDay();
                            if ($item->status === 'lunas') {
                                $badgeClass = 'badge-green';
                                $badgeLabel = 'Lunas';
                            } elseif ($item->status === 'pending') {
                                $badgeClass = 'badge-blue';
                                $badgeLabel = 'Menunggu';
                            } elseif ($item->status === 'rejected') {
                                $badgeClass = 'badge-red';
                                $badgeLabel = 'Ditolak';
                            } elseif ($dueDate) {
                                $dueStart = $dueDate->copy()->startOfDay();
                                if ($dueStart->lt($today)) {
                                    $badgeClass = 'badge-red';
                                    $badgeLabel = 'Terlambat';
                                } elseif ($dueStart->lte($today->copy()->addDays(3))) {
                                    $sisa = $today->diffInDays($dueStart);
                                    $badgeClass = 'badge-yellow';
                                    $badgeLabel = $sisa === 0 ? 'Hari Ini' : 'H - ' . $sisa . ' Hari';
                                } else {
                                    $badgeClass = 'badge-yellow';
                                    $badgeLabel = 'Jatuh Tempo';
                                }
                            } else {
                                $badgeClass = 'badge-yellow';
                                $badgeLabel = 'Jatuh Tempo';
                            }
                            $dataStatus = $item->status;
                        }
                    @endphp
                    <tr data-status="{{ $dataStatus }}">
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        @if($jenis === 'internet')
                        <td style="color:var(--text-primary);font-weight:500;">{{ $item->nama_internet }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $item->provider }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $item->pic }}</td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);">{{ $item->jabatan }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $item->masa_tenggang?->format('d/m/Y') }}</td>
                        <td style="color:var(--text-muted);font-size:0.7rem;">{{ $item->hari_internet }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-primary);font-weight:600;">Rp {{ number_format($item->biaya, 0, ',', '.') }}</td>
                        @else
                        <td style="color:var(--text-primary);font-weight:500;">{{ $item->periode }}</td>
                        @if($jenis === 'aset_digital')
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $item->digitalAsset?->email ?? '-' }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $item->digitalAsset?->mulai?->format('d/m/Y') ?? '-' }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $item->digitalAsset?->berakhir?->format('d/m/Y') ?? '-' }}</td>
                        @endif
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ $item->tanggal_tagihan?->format('d/m/Y') }}</td>
                        <td style="color:var(--text-muted);">{{ $item->jatuh_tempo?->format('d/m/Y') }}</td>
                        @if($jenis === 'aset_digital')
                        <td style="color:var(--text-muted);font-size:0.7rem;">{{ $item->hari_digital }}</td>
                        @elseif($jenis === 'ipl_ruko')
                        <td style="color:var(--text-muted);font-size:0.7rem;">{{ $item->hari_ipl }}</td>
                        @endif
                        <td style="color:var(--text-primary);font-weight:600;">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                        @if($jenis === 'aset_digital')
                        <td style="color:var(--text-muted);">{{ $item->digitalAsset?->pic ?? '-' }}</td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);">{{ $item->digitalAsset?->jabatan ?? '-' }}</td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);max-width:150px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $item->digitalAsset?->keperluan ?? '-' }}">{{ $item->digitalAsset?->keperluan ?? '-' }}</td>
                        @endif
                        @endif
                        <td><span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);">{{ ($item->tanggal_bayar) ? $item->tanggal_bayar->format('d/m/Y') : '-' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail({{ $itemId }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $itemId }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $itemId }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail({{ $itemId }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                        <button type="button" onclick="openEditModal({{ $itemId }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.pembayaran.destroy', $itemId) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus data ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <input type="hidden" name="jenis" value="{{ $jenis }}">
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $jenis === 'internet' ? 11 : ($jenis === 'aset_digital' ? 15 : ($jenis === 'ipl_ruko' ? 10 : 8)) }}" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data {{ $jenisLabels[$jenis] }}.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div id="payment-pagination" class="px-5 py-3 flex items-center justify-between" style="border-top:1px solid var(--border-color);display:none;">
                <span id="payment-pagination-info" style="font-size:0.75rem;color:var(--text-muted);"></span>
                <div class="flex items-center gap-1" id="payment-pagination-controls"></div>
            </div>
        </div>
    </div>
    </div>
    @endif

    {{-- Pengecekan Usage Internet --}}
    @if($jenis === 'internet')
    <div id="internet-tab-usage" style="display:none;">
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Pengecekan Usage Internet</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">
                    Lakukan pengecekan usage internet per ruangan setiap hari.
                </div>
            </div>
            <div class="flex items-center gap-2">
                @if(auth()->user()->role !== 'gm')
                <button type="button" onclick="openInternetUsageModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Input Usage
                </button>
                @endif
            </div>
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-0 max-w-full sm:min-w-[200px] sm:max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-usage" placeholder="Cari ruangan / keterangan..." oninput="filterUsageTable()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-2">
                    <input type="hidden" name="jenis" value="internet">
                    <input type="month" name="internet_usage_date" value="{{ $internetUsageDate }}" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                </form>
                <a href="{{ route('admin.export', ['type' => 'internet-usage', 'internet_usage_date' => $internetUsageDate]) }}" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5" title="Export Usage Internet"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Export</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Ruangan</th>
                        <th>Hari</th>
                        <th>Tanggal</th>
                        <th>Penggunaan Wifi/Hari</th>
                        <th>Penggunaan Ethernet/Hari</th>
                        <th>Pengecek</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="usage-tbody">
                    @forelse($internetUsages as $i => $u)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $u->ruangan }}</td>
                        <td style="color:var(--text-muted);">{{ $u->hari }}</td>
                        <td style="color:var(--text-primary);">{{ $u->tanggal->format('d M Y') }}</td>
                        <td style="color:var(--text-muted);">{{ number_format($u->penggunaan_wifi, 2) }} GB</td>
                        <td style="color:var(--text-muted);">{{ number_format($u->penggunaan_ethernet, 2) }} GB</td>
                        <td style="color:var(--text-primary);">{{ $u->checker?->name ?? '-' }}</td>
                        <td style="color:var(--text-muted);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $u->keterangan ?: '-' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showInternetUsageDetail({{ $u->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, {{ $u->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-{{ $u->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showInternetUsageDetail({{ $u->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                        <form method="POST" action="{{ route('admin.pembayaran.internet-usage.destroy', $u->id) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus data usage ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data usage internet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    {{-- Pembelian Kuota Internet --}}
    <div id="internet-tab-quota-topup" style="display:none;">
    <div class="gaming-card" style="overflow:visible;">
        @if(isset($quotaAlert))
        @php
            $qaColor = match($quotaAlert['level'] ?? 'info') { 'danger' => '#ef4444', 'warning' => '#f59e0b', default => '#3b82f6' };
            $qaBg = match($quotaAlert['level'] ?? 'info') { 'danger' => 'rgba(239,68,68,0.05)', 'warning' => 'rgba(245,158,11,0.05)', default => 'rgba(59,130,246,0.05)' };
            $qaLabel = match($quotaAlert['level'] ?? 'info') { 'danger' => 'Kuota Hampir Habis', 'warning' => 'Perhatian Kuota', default => 'Info Kuota' };
        @endphp
        <div class="flex items-start gap-3 px-5 py-3.5" style="border-bottom:1px solid var(--border-color);background:{{ $qaBg }};">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:{{ $qaColor }};" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <div class="text-sm font-bold" style="color:{{ $qaColor }};">{{ $qaLabel }}</div>
                <div class="text-sm mt-1" style="color:var(--text-secondary);">{{ $quotaAlert['message'] }}</div>
            </div>
        </div>
        @endif
        <div class="px-5 py-4" style="border-bottom:1px solid var(--border-color);">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="margin-bottom:12px;">
                <div class="gaming-card p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(124,58,237,0.12);">
                        <svg class="w-5 h-5" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-xs font-semibold" style="color:var(--text-muted);">Top Up Terakhir</div>
                        <div class="text-lg font-gaming font-bold" style="color:var(--text-primary);">{{ $latestQuotaTopup ? number_format($latestQuotaTopup->amount_gb, 2) : '0' }} GB</div>
                        <div class="text-xs font-medium" style="color:var(--text-muted);">{{ $latestQuotaTopup && $latestQuotaTopup->nominal ? 'Rp '.number_format($latestQuotaTopup->nominal, 0) : '' }}</div>
                        <div class="text-xs" style="color:var(--text-muted);">{{ $latestQuotaTopup ? $latestQuotaTopup->payment_date->format('d M Y') : '-' }} · {{ $latestQuotaTopup?->creator?->name ?? '-' }}</div>
                    </div>
                </div>
                <div class="gaming-card p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(59,130,246,0.12);">
                        <svg class="w-5 h-5" style="color:#60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-semibold" style="color:var(--text-muted);">Terpakai</div>
                        <div class="text-lg font-gaming font-bold" style="color:var(--text-primary);">{{ number_format($quotaUsedGb, 2) }} GB</div>
                    </div>
                </div>
                <div class="gaming-card p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ ($quotaRemainingGb ?? 0) < 10 ? 'rgba(239,68,68,0.12)' : (($quotaRemainingGb ?? 0) < 30 ? 'rgba(245,158,11,0.12)' : 'rgba(16,185,129,0.12)') }};">
                        <svg class="w-5 h-5" style="color:{{ ($quotaRemainingGb ?? 0) < 10 ? '#ef4444' : (($quotaRemainingGb ?? 0) < 30 ? '#f59e0b' : '#34d399') }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-semibold" style="color:var(--text-muted);">Sisa Kuota</div>
                        <div class="text-lg font-gaming font-bold" style="color:{{ ($quotaRemainingGb ?? 0) < 10 ? '#ef4444' : (($quotaRemainingGb ?? 0) < 30 ? '#f59e0b' : 'var(--text-primary)') }};">
                            {{ number_format($quotaRemainingGb ?? 0, 2) }} GB
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Riwayat Pembelian Kuota</div>
                <div class="flex items-center gap-2 flex-wrap">
                    <div class="flex items-center gap-1" style="border:1px solid var(--border-color);border-radius:8px;padding:2px;background:var(--bg-card);">
                        <button type="button" onclick="setQuotaTopupRange('harian')" class="quota-topup-range-btn" data-range="harian" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($quotaTopupRange ?? 'bulanan') === 'harian' ? 'rgba(124,58,237,0.2)' : 'none' }};color:{{ ($quotaTopupRange ?? 'bulanan') === 'harian' ? '#a78bfa' : 'var(--text-muted)' }};">Harian</button>
                        <button type="button" onclick="setQuotaTopupRange('mingguan')" class="quota-topup-range-btn" data-range="mingguan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($quotaTopupRange ?? 'bulanan') === 'mingguan' ? 'rgba(124,58,237,0.2)' : 'none' }};color:{{ ($quotaTopupRange ?? 'bulanan') === 'mingguan' ? '#a78bfa' : 'var(--text-muted)' }};">Mingguan</button>
                        <button type="button" onclick="setQuotaTopupRange('bulanan')" class="quota-topup-range-btn" data-range="bulanan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($quotaTopupRange ?? 'bulanan') === 'bulanan' ? 'rgba(124,58,237,0.2)' : 'none' }};color:{{ ($quotaTopupRange ?? 'bulanan') === 'bulanan' ? '#a78bfa' : 'var(--text-muted)' }};">Bulanan</button>
                        <button type="button" onclick="setQuotaTopupRange('tahunan')" class="quota-topup-range-btn" data-range="tahunan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($quotaTopupRange ?? 'bulanan') === 'tahunan' ? 'rgba(124,58,237,0.2)' : 'none' }};color:{{ ($quotaTopupRange ?? 'bulanan') === 'tahunan' ? '#a78bfa' : 'var(--text-muted)' }};">Tahunan</button>
                    </div>
                    <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-2">
                        <input type="hidden" name="jenis" value="internet">
                        <input type="hidden" name="quota_topup_range" value="{{ $quotaTopupRange ?? 'bulanan' }}">
                        @if(($quotaTopupRange ?? 'bulanan') === 'tahunan')
                            <select name="quota_topup_year" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                                @foreach($internetAvailableYears as $year)
                                    <option value="{{ $year }}" {{ (string) $year === (string) ($quotaTopupYear ?? now()->year) ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        @else
                            <input type="month" name="quota_topup_month" value="{{ $quotaTopupMonth }}" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                        @endif
                    </form>
                    <a href="{{ route('admin.export', ['type' => 'internet-quota-topups', 'range' => $quotaTopupRange ?? 'bulanan', 'quota_topup_month' => $quotaTopupMonth, 'quota_topup_year' => $quotaTopupYear ?? now()->year]) }}" class="btn btn-secondary btn-sm" title="Export Riwayat Pembelian Kuota">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Export
                    </a>
                    @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                    <button type="button" onclick="openQuotaTopupModal()" class="btn btn-primary btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Top Up Baru
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Bayar</th>
                        <th>Internet</th>
                        <th>Periode</th>
                        <th>Jumlah GB</th>
                        <th>Nominal</th>
                        <th>Oleh</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotaTopupHistory as $i => $t)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td style="color:var(--text-primary);">{{ $t->payment_date->format('d M Y') }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $t->wifiPayment->nama_internet ?? '-' }}</td>
                        <td style="color:var(--text-muted);">{{ $t->period }}</td>
                        <td style="font-weight:600;color:var(--text-primary);">{{ number_format($t->amount_gb, 2) }} GB</td>
                        <td style="color:var(--text-primary);">Rp {{ number_format($t->nominal, 0) }}</td>
                        <td style="color:var(--text-primary);">{{ $t->creator?->name ?? '-' }}</td>
                        <td style="color:var(--text-muted);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $t->notes ?: 'Tidak ada catatan' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showQuotaTopupDetail({{ $t->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, 'qt-{{ $t->id }}')" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-qt-{{ $t->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showQuotaTopupDetail({{ $t->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Lihat Detail</button>
                                        @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                        <button type="button" onclick="openEditQuotaTopup({{ $t->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.pembayaran.internet-quota-topup.destroy', $t->id) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus data top up kuota ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada riwayat pembelian kuota.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    {{-- Pengecekan Kuota Internet --}}
    <div id="internet-tab-quota-reading" style="display:none;">
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between flex-wrap gap-3" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Pengecekan Kuota Internet</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">
                    Lakukan pengecekan sisa kuota internet secara berkala.
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex items-center gap-1" style="border:1px solid var(--border-color);border-radius:8px;padding:2px;background:var(--bg-card);">
                    <button type="button" onclick="setQuotaReadingRange('harian')" class="quota-reading-range-btn" data-range="harian" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($quotaReadingRange ?? 'bulanan') === 'harian' ? 'rgba(59,130,246,0.2)' : 'none' }};color:{{ ($quotaReadingRange ?? 'bulanan') === 'harian' ? '#60a5fa' : 'var(--text-muted)' }};">Harian</button>
                    <button type="button" onclick="setQuotaReadingRange('mingguan')" class="quota-reading-range-btn" data-range="mingguan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($quotaReadingRange ?? 'bulanan') === 'mingguan' ? 'rgba(59,130,246,0.2)' : 'none' }};color:{{ ($quotaReadingRange ?? 'bulanan') === 'mingguan' ? '#60a5fa' : 'var(--text-muted)' }};">Mingguan</button>
                    <button type="button" onclick="setQuotaReadingRange('bulanan')" class="quota-reading-range-btn" data-range="bulanan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($quotaReadingRange ?? 'bulanan') === 'bulanan' ? 'rgba(59,130,246,0.2)' : 'none' }};color:{{ ($quotaReadingRange ?? 'bulanan') === 'bulanan' ? '#60a5fa' : 'var(--text-muted)' }};">Bulanan</button>
                    <button type="button" onclick="setQuotaReadingRange('tahunan')" class="quota-reading-range-btn" data-range="tahunan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($quotaReadingRange ?? 'bulanan') === 'tahunan' ? 'rgba(59,130,246,0.2)' : 'none' }};color:{{ ($quotaReadingRange ?? 'bulanan') === 'tahunan' ? '#60a5fa' : 'var(--text-muted)' }};">Tahunan</button>
                </div>
                <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-2">
                    <input type="hidden" name="jenis" value="internet">
                    <input type="hidden" name="quota_reading_range" value="{{ $quotaReadingRange ?? 'bulanan' }}">
                    @if(($quotaReadingRange ?? 'bulanan') === 'tahunan')
                        <select name="quota_reading_year" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                            @foreach($internetAvailableYears as $year)
                                <option value="{{ $year }}" {{ (string) $year === (string) ($quotaReadingYear ?? now()->year) ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="month" name="quota_reading_month" value="{{ $quotaReadingMonth }}" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                    @endif
                </form>
                <a href="{{ route('admin.export', ['type' => 'internet-quota-readings', 'range' => $quotaReadingRange ?? 'bulanan', 'quota_reading_month' => $quotaReadingMonth, 'quota_reading_year' => $quotaReadingYear ?? now()->year]) }}" class="btn btn-secondary btn-sm" title="Export Pengecekan Kuota">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export
                </a>
                @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                <button type="button" onclick="openQuotaReadingModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Input Pengecekan
                </button>
                @endif
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Check</th>
                        <th>Internet</th>
                        <th>Sisa GB</th>
                        <th>Terpakai</th>
                        <th>Status</th>
                        <th>Pengecek</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotaReadings as $i => $r)
                    @php
                        $quotaStatusMap = ['habis' => ['#ef4444', 'Habis'], 'segera_habis' => ['#f97316', 'Segera Habis'], 'perhatian' => ['#3b82f6', 'Perhatian'], 'aman' => ['#10b981', 'Aman']];
                        $quotaStatusColor = $quotaStatusMap[$r->status][0] ?? '#10b981';
                        $quotaStatusLabel = $quotaStatusMap[$r->status][1] ?? 'Aman';
                    @endphp
                    <tr>
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td style="color:var(--text-primary);">{{ $r->checked_date->format('d M Y') }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $r->wifiPayment->nama_internet ?? '-' }}</td>
                        <td style="font-weight:600;color:var(--text-primary);">{{ number_format($r->remaining_gb, 2) }} GB</td>
                        <td style="color:var(--text-muted);">{{ $r->used_gb ? number_format($r->used_gb, 2) . ' GB' : '-' }}</td>
                        <td><span class="badge text-xs" style="background:{{ $quotaStatusColor === '#10b981' ? 'rgba(16,185,129,0.15)' : ($quotaStatusColor === '#3b82f6' ? 'rgba(59,130,246,0.15)' : ($quotaStatusColor === '#f97316' ? 'rgba(249,115,22,0.15)' : 'rgba(239,68,68,0.15)')) }};color:{{ $quotaStatusColor }};border:1px solid {{ $quotaStatusColor === '#10b981' ? 'rgba(16,185,129,0.3)' : ($quotaStatusColor === '#3b82f6' ? 'rgba(59,130,246,0.3)' : ($quotaStatusColor === '#f97316' ? 'rgba(249,115,22,0.3)' : 'rgba(239,68,68,0.3)')) }};">{{ $quotaStatusLabel }}</span></td>
                        <td style="color:var(--text-primary);">{{ $r->checker->name ?? '-' }}</td>
                        <td style="color:var(--text-muted);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r->notes ?: 'Tidak ada catatan' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showQuotaReadingDetail({{ $r->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, 'qr-{{ $r->id }}')" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-qr-{{ $r->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showQuotaReadingDetail({{ $r->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Lihat Detail</button>
                                        @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                        <button type="button" onclick="openEditQuotaReading({{ $r->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.pembayaran.internet-quota-reading.destroy', $r->id) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus data pengecekan kuota ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data pengecekan kuota internet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
    @endif

    {{-- Pill Switcher Listrik --}}
    @if($jenis === 'listrik')
    <div class="flex items-center gap-1" style="border:1px solid var(--border-color);border-radius:10px;padding:3px;background:var(--bg-card);width:fit-content;margin-bottom:12px;">
        <button type="button" id="pill-listrik-topup" onclick="switchListrikTab('topup')" style="padding:6px 14px;border:none;border-radius:7px;font-size:12px;font-weight:600;cursor:pointer;background:rgba(124,58,237,0.15);color:#a78bfa;">Riwayat Top Up</button>
        <button type="button" id="pill-listrik-reading" onclick="switchListrikTab('reading')" style="padding:6px 14px;border:none;border-radius:7px;font-size:12px;font-weight:500;cursor:pointer;background:none;color:var(--text-muted);">Pengecekan Token</button>
    </div>

    {{-- Baris Statistik Token (selalu tampil) --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" style="margin-bottom:12px;">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(124,58,237,0.12);">
                <svg class="w-5 h-5" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xs font-semibold" style="color:var(--text-muted);">Top Up Terakhir</div>
                <div class="text-lg font-gaming font-bold" style="color:var(--text-primary);">{{ $latestPayment ? number_format($latestPayment->amount_kwh, 0) : '7.000' }} KWH</div>
                <div class="text-xs font-medium" style="color:var(--text-muted);">{{ $latestPayment && $latestPayment->nominal ? 'Rp '.number_format($latestPayment->nominal, 0) : '' }}</div>
                <div class="text-xs" style="color:var(--text-muted);">{{ $latestPayment ? $latestPayment->payment_date->format('d M Y') : '-' }} · {{ $latestPayment?->creator?->name ?? '-' }}</div>
            </div>
            @if(auth()->user()->role !== 'gm')
            <button type="button" onclick="openTopupModal()" class="btn btn-primary btn-xs flex-shrink-0" style="font-size:11px;padding:4px 10px;">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Top Up
            </button>
            @endif
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(59,130,246,0.12);">
                <svg class="w-5 h-5" style="color:#60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xs font-semibold" style="color:var(--text-muted);">Terpakai</div>
                <div class="text-lg font-gaming font-bold" style="color:var(--text-primary);">{{ number_format($usedKwh, 1) }} KWH</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:{{ $latestReading && $latestReading->remaining_kwh < 500 ? 'rgba(239,68,68,0.12)' : ($latestReading && $latestReading->remaining_kwh < 1000 ? 'rgba(245,158,11,0.12)' : 'rgba(16,185,129,0.12)') }};">
                <svg class="w-5 h-5" style="color:{{ $latestReading && $latestReading->remaining_kwh < 500 ? '#ef4444' : ($latestReading && $latestReading->remaining_kwh < 1000 ? '#f59e0b' : '#34d399') }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xs font-semibold" style="color:var(--text-muted);">Sisa Token</div>
                <div class="text-lg font-gaming font-bold" style="color:{{ $latestReading && $latestReading->remaining_kwh < 500 ? '#ef4444' : ($latestReading && $latestReading->remaining_kwh < 1000 ? '#f59e0b' : 'var(--text-primary)') }};">
                    {{ $latestReading ? number_format($latestReading->remaining_kwh, 1) : '0' }} KWH
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Riwayat Top Up Token --}}
    @if($jenis === 'listrik')
    <div id="listrik-tab-topup">
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between flex-wrap gap-3" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Riwayat Top Up Token</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Riwayat pembelian/pengisian token listrik.</div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex items-center gap-1" style="border:1px solid var(--border-color);border-radius:8px;padding:2px;background:var(--bg-card);">
                    <button type="button" onclick="setTopupRange('harian')" class="topup-range-btn" data-range="harian" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($topupRange ?? 'bulanan') === 'harian' ? 'rgba(124,58,237,0.2)' : 'none' }};color:{{ ($topupRange ?? 'bulanan') === 'harian' ? '#a78bfa' : 'var(--text-muted)' }};">Harian</button>
                    <button type="button" onclick="setTopupRange('mingguan')" class="topup-range-btn" data-range="mingguan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($topupRange ?? 'bulanan') === 'mingguan' ? 'rgba(124,58,237,0.2)' : 'none' }};color:{{ ($topupRange ?? 'bulanan') === 'mingguan' ? '#a78bfa' : 'var(--text-muted)' }};">Mingguan</button>
                    <button type="button" onclick="setTopupRange('bulanan')" class="topup-range-btn" data-range="bulanan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($topupRange ?? 'bulanan') === 'bulanan' ? 'rgba(124,58,237,0.2)' : 'none' }};color:{{ ($topupRange ?? 'bulanan') === 'bulanan' ? '#a78bfa' : 'var(--text-muted)' }};">Bulanan</button>
                    <button type="button" onclick="setTopupRange('tahunan')" class="topup-range-btn" data-range="tahunan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($topupRange ?? 'bulanan') === 'tahunan' ? 'rgba(124,58,237,0.2)' : 'none' }};color:{{ ($topupRange ?? 'bulanan') === 'tahunan' ? '#a78bfa' : 'var(--text-muted)' }};">Tahunan</button>
                </div>
                <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-2">
                    <input type="hidden" name="jenis" value="listrik">
                    <input type="hidden" name="topup_range" value="{{ $topupRange }}">
                    <input type="hidden" name="token_month" value="{{ $tokenMonth }}">
                    <input type="hidden" name="reading_range" value="{{ $readingRange }}">
                    @if($topupRange === 'tahunan')
                        <select name="topup_year" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                            @foreach($listrikAvailableYears as $year)
                                <option value="{{ $year }}" {{ (string) $year === (string) $topupYear ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                            @if(empty($listrikAvailableYears) || !in_array(now()->year, $listrikAvailableYears ?? []))
                                <option value="{{ now()->year }}" {{ (string) now()->year === (string) $topupYear ? 'selected' : '' }}>{{ now()->year }}</option>
                            @endif
                        </select>
                    @else
                        <input type="month" name="topup_month" value="{{ $topupMonth }}" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                    @endif
                </form>
                <a href="{{ route('admin.export', ['type' => 'token-topups', 'range' => $topupRange ?? 'bulanan', 'topup_month' => $topupMonth, 'topup_year' => $topupYear ?? now()->year]) }}" class="btn btn-secondary btn-sm" title="Export Riwayat Top Up">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export
                </a>
                @if(auth()->user()->role !== 'gm')
                <button type="button" onclick="openTopupModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Top Up Baru
                </button>
                @endif
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Bayar</th>
                        <th>Periode</th>
                        <th>Jumlah KWH</th>
                        <th>Nominal</th>
                        <th>Oleh</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topupHistory as $i => $t)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td style="color:var(--text-primary);">{{ $t->payment_date->format('d M Y') }}</td>
                        <td style="color:var(--text-muted);">{{ $t->period }}</td>
                        <td style="font-weight:600;color:var(--text-primary);">{{ number_format($t->amount_kwh, 0) }} KWH</td>
                        <td style="color:var(--text-primary);">Rp {{ number_format($t->nominal, 0) }}</td>
                        <td style="color:var(--text-primary);">{{ $t->creator?->name ?? '-' }}</td>
                        <td style="color:var(--text-muted);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $t->notes ?: 'Tidak ada catatan' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showTopupDetail({{ $t->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, 'tp-{{ $t->id }}')" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-tp-{{ $t->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showTopupDetail({{ $t->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Lihat Detail</button>
                                        @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                        <button type="button" onclick="openEditTopup({{ $t->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="{{ route('admin.pembayaran.token-topup.destroy', $t->id) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus data top up ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada riwayat top up token.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    {{-- Pengecekan Token Listrik --}}
    <div id="listrik-tab-reading" style="display:none;">
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between flex-wrap gap-3" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Pengecekan Token Listrik</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">
                    Lakukan pengecekan sisa KWH token setiap minggu. Kapasitas token: {{ number_format($capacityKwh, 0) }} KWH/bulan.
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex items-center gap-1" style="border:1px solid var(--border-color);border-radius:8px;padding:2px;background:var(--bg-card);">
                    <button type="button" onclick="setReadingRange('harian')" class="reading-range-btn" data-range="harian" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($readingRange ?? 'bulanan') === 'harian' ? 'rgba(59,130,246,0.2)' : 'none' }};color:{{ ($readingRange ?? 'bulanan') === 'harian' ? '#60a5fa' : 'var(--text-muted)' }};">Harian</button>
                    <button type="button" onclick="setReadingRange('mingguan')" class="reading-range-btn" data-range="mingguan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($readingRange ?? 'bulanan') === 'mingguan' ? 'rgba(59,130,246,0.2)' : 'none' }};color:{{ ($readingRange ?? 'bulanan') === 'mingguan' ? '#60a5fa' : 'var(--text-muted)' }};">Mingguan</button>
                    <button type="button" onclick="setReadingRange('bulanan')" class="reading-range-btn" data-range="bulanan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($readingRange ?? 'bulanan') === 'bulanan' ? 'rgba(59,130,246,0.2)' : 'none' }};color:{{ ($readingRange ?? 'bulanan') === 'bulanan' ? '#60a5fa' : 'var(--text-muted)' }};">Bulanan</button>
                    <button type="button" onclick="setReadingRange('tahunan')" class="reading-range-btn" data-range="tahunan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:{{ ($readingRange ?? 'bulanan') === 'tahunan' ? 'rgba(59,130,246,0.2)' : 'none' }};color:{{ ($readingRange ?? 'bulanan') === 'tahunan' ? '#60a5fa' : 'var(--text-muted)' }};">Tahunan</button>
                </div>
                <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-2">
                    <input type="hidden" name="jenis" value="listrik">
                    <input type="hidden" name="topup_range" value="{{ $topupRange }}">
                    <input type="hidden" name="reading_range" value="{{ $readingRange }}">
                    @if($readingRange === 'tahunan')
                        <select name="reading_year" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                            @foreach($listrikAvailableYears as $year)
                                <option value="{{ $year }}" {{ (string) $year === (string) $readingYear ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                            @if(empty($listrikAvailableYears) || !in_array(now()->year, $listrikAvailableYears ?? []))
                                <option value="{{ now()->year }}" {{ (string) now()->year === (string) $readingYear ? 'selected' : '' }}>{{ now()->year }}</option>
                            @endif
                        </select>
                    @else
                        <input type="month" name="token_month" value="{{ $tokenMonth }}" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                    @endif
                </form>
                <a href="{{ route('admin.export', ['type' => 'token-readings', 'range' => $readingRange ?? 'bulanan', 'token_month' => $tokenMonth, 'reading_year' => $readingYear ?? now()->year]) }}" class="btn btn-secondary btn-sm" title="Export Pengecekan Token">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export
                </a>
                @if(auth()->user()->role !== 'gm')
                <button type="button" onclick="openTokenModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Input Pengecekan
                </button>
                @endif
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Check</th>
                        <th>Sisa KWH</th>
                        <th>Terpakai</th>
                        <th>Status</th>
                        <th>Pengecek</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tokenReadings as $i => $r)
                    @php
                        $statusMap = ['segera_isi' => ['#ef4444', 'Segera Isi Token'], 'warning' => ['#f97316', 'Warning'], 'perhatian' => ['#3b82f6', 'Perhatian'], 'aman' => ['#10b981', 'Aman']];
                        $statusColor = $statusMap[$r->status][0] ?? '#10b981';
                        $statusLabel = $statusMap[$r->status][1] ?? 'Aman';
                        $usedInReading = $capacityKwh - $r->remaining_kwh;
                    @endphp
                    <tr>
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td style="color:var(--text-primary);">{{ $r->checked_date->format('d M Y') }}</td>
                        <td style="font-weight:600;color:var(--text-primary);">{{ $r->remaining_kwh }} KWH</td>
                        <td style="color:var(--text-muted);">{{ number_format($usedInReading, 0) }} KWH</td>
                        <td><span class="badge text-xs" style="background:{{ $statusColor === '#10b981' ? 'rgba(16,185,129,0.15)' : ($statusColor === '#3b82f6' ? 'rgba(59,130,246,0.15)' : ($statusColor === '#f97316' ? 'rgba(249,115,22,0.15)' : 'rgba(239,68,68,0.15)')) }};color:{{ $statusColor }};border:1px solid {{ $statusColor === '#10b981' ? 'rgba(16,185,129,0.3)' : ($statusColor === '#3b82f6' ? 'rgba(59,130,246,0.3)' : ($statusColor === '#f97316' ? 'rgba(249,115,22,0.3)' : 'rgba(239,68,68,0.3)')) }};">{{ $statusLabel }}</span></td>
                        <td style="color:var(--text-primary);">{{ $r->checker->name }}</td>
                        <td style="color:var(--text-muted);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r->notes ?: 'Tidak ada catatan' }}</td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showTokenReadingDetail({{ $r->id }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, 'tr-{{ $r->id }}')" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-tr-{{ $r->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showTokenReadingDetail({{ $r->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Lihat Detail</button>
                                        @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                        <button type="button" onclick="openEditTokenReading({{ $r->id }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <a href="{{ route('admin.export', ['type' => 'token-readings']) }}" target="_blank" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;text-decoration:none;box-sizing:border-box;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Export</a>
                                        <form method="POST" action="{{ route('admin.pembayaran.token-reading.destroy', $r->id) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus data pengecekan ini?" style="margin:0;">
                                            @csrf @method('DELETE')
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada pengecekan token listrik.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    @endif

</div>

@if($jenis === 'listrik')
{{-- Token Reading Modal --}}
<div id="token-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="token-modal-title">Input Pengecekan Token</h3>
            <button type="button" onclick="closeTokenModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1">
            <form method="POST" id="token-form" action="{{ route('admin.pembayaran.token-reading.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="token-method" value="POST">
                <div class="space-y-4">
                    <div class="field-group">
                        <label class="gaming-label">Sisa KWH <span class="field-req">*</span></label>
                        <input type="number" name="remaining_kwh" id="f-remaining_kwh" required step="0.01" min="0" max="9999" placeholder="Contoh: 342.5" class="gaming-input">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Input sisa KWH yang tertera di meteran.</div>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Tanggal Pengecekan <span class="field-req">*</span></label>
                        <input type="date" name="checked_date" id="f-checked_date" required value="{{ date('Y-m-d') }}" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Pengecek <span class="field-req">*</span></label>
                        <select name="checked_by" id="f-checked_by" required class="gaming-input">
                            <option value="">Pilih pengecek</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ $u->id === auth()->id() ? 'selected' : '' }}>{{ $u->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Catatan</label>
                        <textarea name="notes" id="f-notes" rows="2" placeholder="Catatan (opsional)" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Bukti Pengecekan KWH</label>
                        <div style="display:flex;gap:8px;">
                            <button type="button" onclick="openKwhCamera()" class="px-3 py-2 rounded-xl text-xs font-medium transition" style="flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;background:rgba(108,92,255,0.12);color:#6c5cff;border:1px solid rgba(108,92,255,0.35);cursor:pointer;">📷 Ambil Foto</button>
                            <label for="f-token-bukti" class="px-3 py-2 rounded-xl text-xs font-medium transition" style="flex:1;display:inline-flex;align-items:center;justify-content:center;gap:6px;background:var(--bg-surface-2);color:var(--text-primary);border:1px solid var(--border-color);cursor:pointer;">📎 Upload Dokumen</label>
                            <input type="file" name="bukti_foto" id="f-token-bukti" accept="image/jpeg,image/png,application/pdf" style="display:none;" onchange="showTokenBuktiPreview(this.files[0])">
                        </div>
                        <div id="kwh-camera-panel" style="display:none;margin-top:10px;">
                            <video id="kwh-video" autoplay playsinline muted style="width:100%;max-height:240px;border-radius:12px;background:#000;display:block;object-fit:cover;"></video>
                            <div style="display:flex;gap:8px;margin-top:8px;">
                                <button type="button" onclick="snapKwhPhoto()" class="px-4 py-2 rounded-xl text-xs font-medium" style="flex:1;background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;">📸 Jepret</button>
                                <button type="button" onclick="stopKwhCamera()" class="px-4 py-2 rounded-xl text-xs font-medium" style="background:var(--bg-surface-2);color:var(--text-primary);border:1px solid var(--border-color);cursor:pointer;">Tutup Kamera</button>
                            </div>
                        </div>
                        <canvas id="kwh-canvas" style="display:none;"></canvas>
                        <div id="token-bukti-preview" style="display:none;margin-top:10px;">
                            <div style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:12px;border:1px solid var(--border-color);background:var(--bg-surface-2);">
                                <img id="token-bukti-thumb" src="" alt="" style="width:56px;height:56px;border-radius:8px;object-fit:cover;border:1px solid var(--border-color);display:none;">
                                <div id="token-bukti-fileicon" style="width:56px;height:56px;border-radius:8px;display:none;align-items:center;justify-content:center;font-size:24px;background:rgba(108,92,255,0.12);">📄</div>
                                <div style="flex:1;min-width:0;">
                                    <div id="token-bukti-name" class="text-xs font-semibold" style="color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"></div>
                                    <div id="token-bukti-existing" style="font-size:10px;color:var(--text-muted);margin-top:2px;display:none;">Bukti tersimpan — pilih file baru untuk mengganti.</div>
                                </div>
                                <a id="token-bukti-link" href="#" target="_blank" rel="noopener" style="font-size:11px;color:#6c5cff;text-decoration:none;display:none;">Lihat</a>
                                <button type="button" onclick="clearTokenBukti()" title="Hapus pilihan bukti" style="padding:4px 8px;border-radius:8px;border:none;background:none;color:#ef4444;cursor:pointer;font-size:14px;">✕</button>
                            </div>
                        </div>
                        <div style="font-size:11px;color:var(--text-muted);margin-top:6px;">Foto meteran KWH atau dokumen pendukung (JPG/PNG/PDF, maks 2MB). Opsional.</div>
                    </div>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;">
                    <button type="button" onclick="closeTokenModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                    <button type="submit" id="token-submit-btn" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Token Reading Detail Modal --}}
<div id="token-reading-detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:90vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Detail Pengecekan Token</h3>
            <button type="button" onclick="closeTokenReadingDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1" id="token-reading-detail-body"></div>
        <div class="px-6 py-4 flex-shrink-0" style="border-top:1px solid var(--border-color);display:flex;justify-content:flex-end;">
            <button type="button" onclick="closeTokenReadingDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
        </div>
    </div>
</div>

{{-- Top Up Token Modal --}}
<div id="topup-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:92vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="topup-modal-title">Top Up Token Listrik</h3>
            <button type="button" onclick="closeTopupModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-5 py-4 overflow-y-auto flex-1">
            <form method="POST" id="topup-form" action="{{ route('admin.pembayaran.token-topup.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="topup-method" value="POST">
                <div class="space-y-2.5">
                    <div class="field-group">
                        <label class="gaming-label">Jumlah KWH <span class="field-req">*</span></label>
                        <input type="number" name="amount_kwh" id="f-amount_kwh" required step="0.01" min="1" placeholder="Contoh: 7000" class="gaming-input">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">Jumlah KWH yang dibeli.</div>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Nominal (Rp) <span class="field-req">*</span></label>
                        <input type="number" name="nominal" id="f-nominal" required step="0.01" min="0" placeholder="Contoh: 1500000" class="gaming-input">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">Nominal harga token.</div>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Tanggal Bayar <span class="field-req">*</span></label>
                        <input type="date" name="payment_date" id="f-payment_date" required value="{{ date('Y-m-d') }}" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Catatan</label>
                        <textarea name="notes" id="f-topup-notes" rows="1" placeholder="Catatan (opsional)" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Bukti Pembayaran</label>
                        <input type="file" name="bukti_bayar" id="f-topup-bukti" accept="image/jpeg,image/png" class="gaming-input" style="padding:8px;">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:2px;" id="topup-bukti-hint">Foto/scan bukti pembayaran (JPG/PNG, maks 2MB). Opsional.</div>
                    </div>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:16px;">
                    <button type="button" onclick="closeTopupModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                    <button type="submit" id="topup-submit-btn" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Top Up Detail Modal --}}
<div id="topup-detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:90vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Detail Top Up Token</h3>
            <button type="button" onclick="closeTopupDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1" id="topup-detail-body"></div>
        <div class="px-6 py-4 flex-shrink-0" style="border-top:1px solid var(--border-color);display:flex;justify-content:flex-end;">
            <button type="button" onclick="closeTopupDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
        </div>
    </div>
</div>
@endif

{{-- Detail Modal --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[460px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="detail-title">Detail</h3>
            <button type="button" onclick="closeDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1" id="detail-body"></div>
        <div class="px-6 py-4 flex-shrink-0 flex items-center gap-2" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
            <button type="button" id="detail-bayar-btn" onclick="markAsLunas()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="display:none;background:#10b981;color:#fff;border:none;cursor:pointer;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">Bayar / Lunaskan</button>
            <button type="button" id="detail-edit-btn" onclick="editFromDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">Edit</button>
        </div>
    </div>
</div>

{{-- Form Modal --}}
<div id="payment-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[440px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="modal-title">Tambah Tagihan</h3>
            <button type="button" onclick="closePaymentModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="px-6 py-5 overflow-y-auto flex-1">
            <form id="payment-form" method="POST">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="form-id" value="">
                <input type="hidden" name="jenis" id="f-jenis" value="{{ $jenis }}">

                <div class="form-grid-2">
                    @if($jenis === 'internet')
                    <div class="field-group">
                        <label class="gaming-label">Nama Internet <span class="field-req">*</span></label>
                        <input type="text" name="nama_internet" id="f-nama_internet" required placeholder="Contoh: Wifi 1 (Kantor Utama)" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Provider <span class="field-req">*</span></label>
                        <select name="provider" id="f-provider" required class="gaming-input">
                            <option value="">Pilih provider</option>
                            <option value="Indosat">Indosat</option>
                            <option value="IndiHome">IndiHome</option>
                            <option value="First Media">First Media</option>
                            <option value="MyRepublic">MyRepublic</option>
                            <option value="Biznet">Biznet</option>
                            <option value="CBN">CBN</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">PIC <span class="field-req">*</span></label>
                        <input type="text" name="pic" id="f-pic" required placeholder="Nama penanggung jawab" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jabatan <span class="field-req">*</span></label>
                        <select name="jabatan" id="f-jabatan" required class="gaming-input gaming-select">
                            <option value="">Pilih Jabatan</option>
                            <option value="Chief Executive Officer (CEO)">Chief Executive Officer (CEO)</option>
                            <option value="General Manager (GM)">General Manager (GM)</option>
                            <option value="Head of Store">Head of Store</option>
                            <option value="Admin Master">Admin Master</option>
                            <option value="HR">HR</option>
                            <option value="Koordinator">Koordinator</option>
                            <option value="Karyawan">Karyawan</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Masa Tenggang <span class="field-req">*</span></label>
                        <input type="date" name="masa_tenggang" id="f-masa_tenggang" required class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Biaya <span class="field-req">*</span></label>
                        <input type="number" name="biaya" id="f-biaya" required placeholder="Contoh: Rp 300.000" class="gaming-input" min="0" step="0.01">
                    </div>
                    @else
                    <div class="field-group">
                        <label class="gaming-label">{{ $jenis === 'aset_digital' ? 'Nama Aset' : 'Periode' }} <span class="field-req">*</span></label>
                        <input type="text" name="periode" id="f-periode" required placeholder="{{ $jenis === 'aset_digital' ? 'Contoh: Adobe Photoshop' : 'Contoh: Januari 2026' }}" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Nominal <span class="field-req">*</span></label>
                        <input type="number" name="nominal" id="f-nominal" required placeholder="Contoh: Rp 300.000" class="gaming-input" min="0" step="0.01">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Tagihan <span class="field-req">*</span></label>
                        <input type="date" name="tanggal_tagihan" id="f-tanggal_tagihan" required class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jatuh Tempo <span class="field-req">*</span></label>
                        <input type="date" name="jatuh_tempo" id="f-jatuh_tempo" required class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">PIC <span class="field-req">*</span></label>
                        <input type="text" name="pic" id="f-pic" required placeholder="Nama penanggung jawab" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jabatan <span class="field-req">*</span></label>
                        <select name="jabatan" id="f-jabatan" required class="gaming-input gaming-select">
                            <option value="">Pilih Jabatan</option>
                            <option value="Chief Executive Officer (CEO)">Chief Executive Officer (CEO)</option>
                            <option value="General Manager (GM)">General Manager (GM)</option>
                            <option value="Head of Store">Head of Store</option>
                            <option value="Admin Master">Admin Master</option>
                            <option value="HR">HR</option>
                            <option value="Koordinator">Koordinator</option>
                            <option value="Karyawan">Karyawan</option>
                        </select>
                    </div>
                    @if($jenis === 'aset_digital')
                    <div class="field-group">
                        <label class="gaming-label">ID Aset Digital</label>
                        <select name="digital_asset_id" id="f-digital_asset_id" class="gaming-input gaming-select">
                            <option value="">Pilih Aset Digital</option>
                            @foreach($digitalAssets as $da)
                            <option value="{{ $da->id }}">{{ $da->nama_aset }} — {{ $da->pic }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    @endif
                    <div class="field-group">
                        <label class="gaming-label">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" id="f-tanggal_bayar" class="gaming-input">
                    </div>
                </div>

                <div class="form-footer">
                    <button type="button" onclick="closePaymentModal()" class="btn-form btn-form-batal">Batal</button>
                    <button type="submit" class="btn-form btn-form-simpan" id="form-submit-btn">Tambah</button>
                </div>
            </form>
        </div>

    </div>
</div>

{{-- Modal Bayar/Lunaskan --}}
<div id="bayar-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Bayar / Lunaskan</h3>
            <button type="button" onclick="closeBayarModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1">
            <div id="bayar-info" style="margin-bottom:16px;padding:12px;border-radius:10px;background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <div id="bayar-name" style="font-weight:600;font-size:14px;color:var(--text-primary);"></div>
                <div id="bayar-nominal" style="font-size:13px;color:var(--text-muted);margin-top:4px;"></div>
                <div id="bayar-due" style="font-size:13px;color:var(--text-muted);margin-top:2px;"></div>
            </div>
            <form id="bayar-form" method="POST" action="{{ url('admin/pembayaran') }}">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="jenis" value="{{ $jenis }}">
                <input type="hidden" name="id" id="bayar-id" value="">
                @if($jenis === 'internet')
                <input type="hidden" name="nama_internet" id="bayar-nama_internet">
                <input type="hidden" name="provider" id="bayar-provider">
                <input type="hidden" name="pic" id="bayar-pic">
                <input type="hidden" name="jabatan" id="bayar-jabatan">
                <input type="hidden" name="masa_tenggang" id="bayar-masa_tenggang">
                <input type="hidden" name="biaya" id="bayar-biaya">
                @else
                <input type="hidden" name="periode" id="bayar-periode">
                <input type="hidden" name="tanggal_tagihan" id="bayar-tanggal_tagihan">
                <input type="hidden" name="jatuh_tempo" id="bayar-jatuh_tempo">
                <input type="hidden" name="nominal" id="bayar-nominal_val">
                @endif
                <input type="hidden" name="status" id="bayar-status" value="lunas">
                <div class="space-y-4">
                    <div class="field-group">
                        <label class="gaming-label">Tanggal Bayar <span class="field-req">*</span></label>
                        <input type="date" name="tanggal_bayar" id="bayar-tanggal_bayar" required value="{{ date('Y-m-d') }}" class="gaming-input">
                    </div>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;">
                    <button type="button" onclick="closeBayarModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#10b981,#34d399);color:#fff;border:none;box-shadow:0 4px 15px rgba(16,185,129,0.3);cursor:pointer;">Lunaskan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Bulk IPL Modal --}}
<div id="bulk-ipl-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Generate Tagihan IPL 1 Tahun</h3>
            <button type="button" onclick="closeBulkIplModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1">
            <form method="POST" action="{{ route('admin.pembayaran.ipl-bulk') }}">
                @csrf
                <div class="space-y-4">
                    <div class="field-group">
                        <label class="gaming-label">Tahun <span class="field-req">*</span></label>
                        <input type="number" name="year" id="f-bulk-year" required min="2020" max="2035" value="{{ date('Y') }}" class="gaming-input">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Masukkan tahun tagihan yang akan digenerate (12 bulan).</div>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Nominal per Bulan (Rp) <span class="field-req">*</span></label>
                        <input type="number" name="nominal" id="f-bulk-nominal" required min="0" placeholder="Contoh: 500000" class="gaming-input">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Nominal tagihan untuk setiap bulan. Seragam untuk 12 bulan.</div>
                    </div>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;padding-top:16px;border-top:1px solid var(--border-color);">
                    <button type="button" onclick="closeBulkIplModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;" onclick="return showBulkIplConfirm(event)">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Bulk IPL Confirm Modal --}}
<div id="bulk-ipl-confirm-modal" style="display:none;position:fixed;inset:0;z-index:60;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[400px] rounded-3xl shadow-2xl flex flex-col" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Konfirmasi Generate</h3>
            <button type="button" onclick="closeBulkIplConfirm()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 text-center">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-4" style="background:rgba(108,92,255,0.1);border:1px solid rgba(108,92,255,0.2);">
                <svg class="w-7 h-7" style="color:#6c5cff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p style="color:var(--text-primary);font-weight:600;font-size:15px;margin-bottom:6px;">Generate 12 Tagihan IPL?</p>
            <p style="color:var(--text-muted);font-size:13px;margin-bottom:4px;">Tahun: <strong id="confirm-bulk-year" style="color:var(--text-primary);">-</strong></p>
            <p style="color:var(--text-muted);font-size:13px;margin-bottom:4px;">Nominal: <strong id="confirm-bulk-nominal" style="color:var(--text-primary);">-</strong></p>
            <p style="color:var(--text-muted);font-size:12px;margin-top:12px;">12 tagihan akan dibuat untuk setiap bulan di tahun tersebut.</p>
        </div>
        <div class="px-6 py-4 flex gap-3 justify-end" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeBulkIplConfirm()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;">Batal</button>
            <button type="button" onclick="submitBulkIpl()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#10b981,#34d399);color:#fff;border:none;box-shadow:0 4px 15px rgba(16,185,129,0.3);cursor:pointer;">Ya, Generate</button>
        </div>
    </div>
</div>

@if($jenis === 'internet')
    {{-- Internet Usage Modal --}}
    <div id="internet-usage-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
        <div class="w-full max-w-[480px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Input Usage Internet</h3>
                <button type="button" onclick="closeInternetUsageModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1">
                <form method="POST" action="{{ route('admin.pembayaran.internet-usage.store') }}">
                    @csrf
                    <div class="space-y-4">
                        <div class="field-group">
                            <label class="gaming-label">Ruangan <span class="field-req">*</span></label>
                            <select name="ruangan" required class="gaming-input">
                                <option value="">Pilih ruangan</option>
                                <option value="Johen MLBB">Johen MLBB</option>
                                <option value="Johen PUBG">Johen PUBG</option>
                                <option value="Johen Free Fire">Johen Free Fire</option>
                                <option value="Johen Roblox">Johen Roblox</option>
                                <option value="Johen Valorant">Johen Valorant</option>
                                <option value="Johen E-Football">Johen E-Football</option>
                                <option value="Monkey PUBG">Monkey PUBG</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="field-group">
                                <label class="gaming-label">Hari <span class="field-req">*</span></label>
                                <select name="hari" required class="gaming-input">
                                    <option value="">Pilih hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div class="field-group">
                                <label class="gaming-label">Tanggal <span class="field-req">*</span></label>
                                <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="gaming-input">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="field-group">
                                <label class="gaming-label">Penggunaan Wifi (GB) <span class="field-req">*</span></label>
                                <input type="number" name="penggunaan_wifi" required step="0.01" min="0" placeholder="0.00" class="gaming-input">
                            </div>
                            <div class="field-group">
                                <label class="gaming-label">Penggunaan Ethernet (GB) <span class="field-req">*</span></label>
                                <input type="number" name="penggunaan_ethernet" required step="0.01" min="0" placeholder="0.00" class="gaming-input">
                            </div>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Keterangan</label>
                            <textarea name="keterangan" rows="2" placeholder="Catatan (opsional)" class="gaming-input" style="resize:vertical;"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-3 pt-5 mt-5" style="border-top:1px solid var(--border-color);">
                        <button type="button" onclick="closeInternetUsageModal()" class="btn-form btn-form-batal">Batal</button>
                        <button type="submit" class="btn-form btn-form-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Quota Top Up Modal --}}
    <div id="quota-topup-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
        <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:92vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);" id="quota-topup-modal-title">Pembelian Kuota Internet</h3>
                <button type="button" onclick="closeQuotaTopupModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1">
                <form method="POST" id="quota-topup-form" action="{{ route('admin.pembayaran.internet-quota-topup.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="quota-topup-method" value="POST">
                    <div class="space-y-4">
                        <div class="field-group">
                            <label class="gaming-label">Internet <span class="field-req">*</span></label>
                            <select name="wifi_payment_id" id="f-qt-wifi_payment_id" required class="gaming-input">
                                <option value="">Pilih internet</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_internet }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Jumlah GB <span class="field-req">*</span></label>
                            <input type="number" name="amount_gb" id="f-qt-amount_gb" required step="0.01" min="0.01" placeholder="Contoh: 50" class="gaming-input">
                            <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">Jumlah kuota yang dibeli (GB).</div>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Nominal (Rp) <span class="field-req">*</span></label>
                            <input type="number" name="nominal" id="f-qt-nominal" required step="0.01" min="0" placeholder="Contoh: 100000" class="gaming-input">
                            <div style="font-size:11px;color:var(--text-muted);margin-top:2px;">Nominal harga kuota.</div>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Tanggal Bayar <span class="field-req">*</span></label>
                            <input type="date" name="payment_date" id="f-qt-payment_date" required value="{{ date('Y-m-d') }}" class="gaming-input">
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Catatan</label>
                            <textarea name="notes" id="f-qt-notes" rows="1" placeholder="Catatan (opsional)" class="gaming-input" style="resize:vertical;"></textarea>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Bukti Pembayaran</label>
                            <input type="file" name="bukti_bayar" id="f-qt-bukti" accept="image/jpeg,image/png" class="gaming-input" style="padding:8px;">
                            <div style="font-size:11px;color:var(--text-muted);margin-top:2px;" id="quota-topup-bukti-hint">Foto/scan bukti pembayaran (JPG/PNG, maks 2MB). Opsional.</div>
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:16px;">
                        <button type="button" onclick="closeQuotaTopupModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                        <button type="submit" id="quota-topup-submit-btn" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Quota Top Up Detail Modal --}}
    <div id="quota-topup-detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
        <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:90vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Detail Pembelian Kuota</h3>
                <button type="button" onclick="closeQuotaTopupDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1" id="quota-topup-detail-body"></div>
            <div class="px-6 py-4 flex-shrink-0" style="border-top:1px solid var(--border-color);display:flex;justify-content:flex-end;">
                <button type="button" onclick="closeQuotaTopupDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
            </div>
        </div>
    </div>

    {{-- Quota Reading Modal --}}
    <div id="quota-reading-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
        <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:92vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);" id="quota-reading-modal-title">Input Pengecekan Kuota</h3>
                <button type="button" onclick="closeQuotaReadingModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1">
                <form method="POST" id="quota-reading-form" action="{{ route('admin.pembayaran.internet-quota-reading.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" id="quota-reading-method" value="POST">
                    <div class="space-y-4">
                        <div class="field-group">
                            <label class="gaming-label">Internet <span class="field-req">*</span></label>
                            <select name="wifi_payment_id" id="f-qr-wifi_payment_id" required class="gaming-input">
                                <option value="">Pilih internet</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_internet }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Sisa Kuota (GB) <span class="field-req">*</span></label>
                            <input type="number" name="remaining_gb" id="f-qr-remaining_gb" required step="0.01" min="0" placeholder="Contoh: 25.50" class="gaming-input">
                            <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Input sisa kuota yang tersisa.</div>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Tanggal Pengecekan <span class="field-req">*</span></label>
                            <input type="date" name="checked_date" id="f-qr-checked_date" required value="{{ date('Y-m-d') }}" class="gaming-input">
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Pengecek <span class="field-req">*</span></label>
                            <select name="checked_by" id="f-qr-checked_by" required class="gaming-input">
                                <option value="">Pilih pengecek</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" {{ $u->id === auth()->id() ? 'selected' : '' }}>{{ $u->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Catatan</label>
                            <textarea name="notes" id="f-qr-notes" rows="2" placeholder="Catatan (opsional)" class="gaming-input" style="resize:vertical;"></textarea>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Bukti Pengecekan</label>
                            <input type="file" name="bukti_foto" id="f-qr-bukti" accept="image/jpeg,image/png,application/pdf" class="gaming-input" style="padding:8px;">
                            <div style="font-size:11px;color:var(--text-muted);margin-top:2px;" id="quota-reading-bukti-hint">Foto/dokumen pendukung (JPG/PNG/PDF, maks 2MB). Opsional.</div>
                        </div>
                    </div>
                    <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:16px;">
                        <button type="button" onclick="closeQuotaReadingModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                        <button type="submit" id="quota-reading-submit-btn" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Quota Reading Detail Modal --}}
    <div id="quota-reading-detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
        <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:90vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Detail Pengecekan Kuota</h3>
                <button type="button" onclick="closeQuotaReadingDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1" id="quota-reading-detail-body"></div>
            <div class="px-6 py-4 flex-shrink-0" style="border-top:1px solid var(--border-color);display:flex;justify-content:flex-end;">
                <button type="button" onclick="closeQuotaReadingDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
            </div>
        </div>
    </div>
@endif

<script>
window.__paymentScript = 0;
console.log('[PAYMENT] Script loaded', window.__paymentScript);
window.__paymentScript = 1;
const paymentData = @json($itemsJson);
const internetUsageData = @json($internetUsagesJson);
const topupData = @json($topupHistoryJson);
const tokenReadingData = @json($tokenReadingsJson);
const quotaTopupData = @json($quotaTopupHistoryJson ?? collect());
const quotaReadingData = @json($quotaReadingsJson ?? collect());
const internetWifiItems = @json($items->pluck('nama_internet', 'id'));
const currentJenis = '{{ $jenis }}';
const dueField = currentJenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
const jenisLabel = @json($jenisLabels[$jenis] ?? $jenis);
let detailId = null;

function showAlertPopup(type) {
    const overlay = document.getElementById('alert-overlay');
    const title = document.getElementById('alert-popup-title');
    const body = document.getElementById('alert-popup-body');
    const today = new Date(); today.setHours(0,0,0,0);
    const color = type === 'danger' ? '#ef4444' : '#f59e0b';
    const bgColor = type === 'danger' ? 'rgba(239,68,68,0.1)' : 'rgba(245,158,11,0.1)';
    const borderColor = type === 'danger' ? 'rgba(239,68,68,0.25)' : 'rgba(245,158,11,0.25)';
    const label = currentJenis === 'internet' ? 'Masa Tenggang' : 'Jatuh Tempo';

    const items = paymentData.filter(function(item) {
        if (currentJenis === 'internet') {
            if (item.status_internet === 'lunas' || item.status_internet === 'pending' || item.status_internet === 'rejected') return false;
            if (!item[dueField]) return false;
            const due = new Date(item[dueField]); due.setHours(0,0,0,0);
            if (type === 'danger') return due <= today;
            const in3 = new Date(today); in3.setDate(in3.getDate() + 3);
            return due > today && due <= in3;
        }
        if (!item[dueField]) return false;
        if (item.status !== 'jatuh_tempo') return false;
        const due = new Date(item[dueField]); due.setHours(0,0,0,0);
        if (type === 'danger') return due <= today;
        const in3 = new Date(today); in3.setDate(in3.getDate() + 3);
        return due > today && due <= in3;
    });

    title.textContent = type === 'danger' ? 'Tagihan Lewat Jatuh Tempo' : 'Tagihan Segera Jatuh Tempo';
    title.style.color = color;
    body.innerHTML = '';

    if (items.length === 0) {
        body.innerHTML = '<div style="text-align:center;padding:20px;color:var(--text-muted);">Tidak ada data.</div>';
    } else {
        items.forEach(function(item, idx) {
            const due = new Date(item[dueField]); due.setHours(0,0,0,0);
            const diffDays = Math.round((today - due) / (1000 * 60 * 60 * 24));
            let badgeText = '';
            if (type === 'danger') {
                badgeText = diffDays === 0 ? 'Hari Ini' : diffDays + ' Hari Lewat';
            } else {
                badgeText = diffDays + ' Hari Lagi';
            }
            const name = currentJenis === 'internet' ? (item.nama_internet + ' (' + item.provider + ')') : item.periode;
            const nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.nominal);

            var row = document.createElement('div');
            row.setAttribute('data-id', item.id);
            row.style.cssText = 'display:flex;align-items:center;justify-content:space-between;padding:12px 0;cursor:pointer;transition:background 0.15s;' + (idx < items.length - 1 ? 'border-bottom:1px solid var(--border-color);' : '');
            row.onmouseover = function() { this.style.background = 'rgba(255,255,255,0.02)'; };
            row.onmouseout = function() { this.style.background = 'none'; };
            row.onclick = function() { goToEdit(item.id); };

            row.innerHTML =
                '<div class="min-w-0" style="flex:1;">' +
                    '<div style="font-weight:600;font-size:13px;color:var(--text-primary);">' + name + '</div>' +
                    '<div style="font-size:12px;color:var(--text-muted);margin-top:2px;">' + label + ': ' + badgeText + ' &middot; ' + nominal + '</div>' +
                '</div>' +
                '<div style="display:flex;align-items:center;gap:6px;flex-shrink:0;margin-left:12px;">' +
                    '<span style="padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600;background:' + (type === 'danger' ? 'rgba(239,68,68,0.15)' : 'rgba(245,158,11,0.15)') + ';color:' + color + ';border:1px solid ' + (type === 'danger' ? 'rgba(239,68,68,0.3)' : 'rgba(245,158,11,0.3)') + ';">' + badgeText + '</span>' +
                    '<svg style="width:14px;height:14px;color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>' +
                '</div>';

            body.appendChild(row);
        });
    }
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function goToEdit(id) {
    closeAlertPopup();
    openBayarModal(id);
}

function openBayarModal(id) {
    const i = paymentData.find(function(x) { return x.id === id; });
    if (!i) return;

    document.getElementById('bayar-id').value = i.id;
    document.getElementById('bayar-form').action = '{{ url("admin/pembayaran") }}/' + i.id;

    const name = currentJenis === 'internet' ? (i.nama_internet + ' (' + i.provider + ')') : i.periode;
    const nominalVal = i.nominal || i.biaya || 0;
    const nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(nominalVal);
    const dueField = currentJenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
    const dueLabel = currentJenis === 'internet' ? 'Masa Tenggang' : 'Jatuh Tempo';
    const dueDate = i[dueField] ? new Date(i[dueField]).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';

    document.getElementById('bayar-name').textContent = name;
    document.getElementById('bayar-nominal').textContent = 'Nominal: ' + nominal;
    document.getElementById('bayar-due').textContent = dueLabel + ': ' + dueDate;

    if (currentJenis === 'internet') {
        document.getElementById('bayar-nama_internet').value = i.nama_internet;
        document.getElementById('bayar-provider').value = i.provider;
        document.getElementById('bayar-pic').value = i.pic;
        document.getElementById('bayar-jabatan').value = i.jabatan;
        document.getElementById('bayar-masa_tenggang').value = i.masa_tenggang;
        document.getElementById('bayar-biaya').value = i.biaya;
    } else {
        document.getElementById('bayar-periode').value = i.periode;
        document.getElementById('bayar-tanggal_tagihan').value = i.tanggal_tagihan;
        document.getElementById('bayar-jatuh_tempo').value = i.jatuh_tempo;
        document.getElementById('bayar-nominal_val').value = i.nominal;
    }

    document.getElementById('bayar-tanggal_bayar').value = new Date().toISOString().split('T')[0];
    document.getElementById('bayar-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeBayarModal() {
    document.getElementById('bayar-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('bayar-modal')?.addEventListener('click', function(e) { if (e.target === this) closeBayarModal(); });

function closeAlertPopup() {
    document.getElementById('alert-overlay').style.display = 'none';
    document.body.style.overflow = '';
}

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Tagihan';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('payment-form').action = '{{ route('admin.pembayaran.store') }}';
    document.getElementById('form-submit-btn').textContent = 'Tambah';
    document.getElementById('payment-form').querySelectorAll('input, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method') el.value = '';
    });
    showPaymentModal();
}

function showDetail(id) {
    detailId = id;
    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    @if($jenis === 'internet')
    document.getElementById('detail-title').textContent = i.nama_internet;
    @else
    document.getElementById('detail-title').textContent = i.periode;
    @endif

    const statusComputedMap = {
        'lunas': { label: 'Lunas', bg: '#ecfdf5', text: '#059669', border: '#a7f3d0' },
        'pending': { label: 'Menunggu', bg: '#eff6ff', text: '#3b82f6', border: '#bfdbfe' },
        'rejected': { label: 'Ditolak', bg: '#fef2f2', text: '#dc2626', border: '#fecaca' },
        'aktif': { label: 'Aktif', bg: '#ecfdf5', text: '#059669', border: '#a7f3d0' },
        'jatuh_tempo': { label: 'Jatuh Tempo', bg: '#fff7ed', text: '#c2410c', border: '#fed7aa' },
        'segera_habis': { label: 'Segera Habis', bg: '#fefce8', text: '#b45309', border: '#fde68a' },
        'mati': { label: 'Mati', bg: '#fef2f2', text: '#dc2626', border: '#fecaca' },
    };
    const fmt = (d) => d ? new Date(d).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '-';

    @if($jenis === 'internet')
    const s = statusComputedMap[i.status_internet] || statusComputedMap['mati'];
    const rows = [
        { label: 'Nama Internet', value: i.nama_internet },
        { label: 'Provider', value: i.provider },
        { label: 'PIC', value: i.pic },
        { label: 'Jabatan', value: i.jabatan },
        { label: 'Masa Tenggang', value: fmt(i.masa_tenggang) },
        { label: 'Hari', value: i.hari_internet || '-' },
        { label: 'Biaya', value: 'Rp ' + Number(i.biaya).toLocaleString('id-ID') },
        { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
    ];
    @elseif($jenis === 'aset_digital')
    const s = statusComputedMap[i.status_digital] || statusComputedMap['mati'];
    const rows = [
        { label: 'Nama Aset', value: i.periode },
        { label: 'Email', value: i.email || '-' },
        { label: 'Mulai', value: i.mulai || '-' },
        { label: 'Berakhir', value: i.berakhir || '-' },
        { label: 'PIC', value: i.pic || '-' },
        { label: 'Jabatan', value: i.jabatan || '-' },
        { label: 'Keterangan', value: i.keperluan || '-' },
        { label: 'Tagihan', value: fmt(i.tanggal_tagihan) },
        { label: 'Jatuh Tempo', value: fmt(i.jatuh_tempo) },
        { label: 'Hari', value: i.hari_digital || '-' },
        { label: 'Nominal', value: 'Rp ' + Number(i.nominal).toLocaleString('id-ID') },
        { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
    ];
    @elseif($jenis === 'ipl_ruko')
    const s = statusComputedMap[i.status_ipl] || statusComputedMap['mati'];
    const rows = [
        { label: 'Periode', value: i.periode },
        { label: 'Tagihan', value: fmt(i.tanggal_tagihan) },
        { label: 'Jatuh Tempo', value: fmt(i.jatuh_tempo) },
        { label: 'Hari', value: i.hari_ipl || '-' },
        { label: 'PIC', value: i.pic || '-' },
        { label: 'Jabatan', value: i.jabatan || '-' },
        { label: 'Nominal', value: 'Rp ' + Number(i.nominal).toLocaleString('id-ID') },
        { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
    ];
    @else
    const fmtDate = (d) => d ? new Date(d + 'T00:00:00') : null;
    const today = new Date(); today.setHours(0,0,0,0);
    const dueDate = fmtDate(i.jatuh_tempo);
    let computedLabel, computedBg, computedText, computedBorder;
    if (i.status === 'lunas') {
        computedLabel = 'Lunas'; computedBg = '#ecfdf5'; computedText = '#059669'; computedBorder = '#a7f3d0';
    } else if (i.status === 'pending') {
        computedLabel = 'Menunggu'; computedBg = '#eff6ff'; computedText = '#3b82f6'; computedBorder = '#bfdbfe';
    } else if (i.status === 'rejected') {
        computedLabel = 'Ditolak'; computedBg = '#fef2f2'; computedText = '#dc2626'; computedBorder = '#fecaca';
    } else if (dueDate && dueDate < today) {
        computedLabel = 'Terlambat'; computedBg = '#fef2f2'; computedText = '#dc2626'; computedBorder = '#fecaca';
    } else if (dueDate && dueDate <= new Date(today.getTime() + 3*86400000)) {
        const sisa = Math.round((dueDate - today) / 86400000);
        computedLabel = sisa === 0 ? 'Hari Ini' : 'H - ' + sisa + ' Hari';
        computedBg = '#fff7ed'; computedText = '#c2410c'; computedBorder = '#fed7aa';
    } else {
        computedLabel = 'Jatuh Tempo'; computedBg = '#fff7ed'; computedText = '#c2410c'; computedBorder = '#fed7aa';
    }
    const s = { label: computedLabel, bg: computedBg, text: computedText, border: computedBorder };
    const rows = [
        { label: 'Periode', value: i.periode },
        { label: 'Tagihan', value: fmt(i.tanggal_tagihan) },
        { label: 'Jatuh Tempo', value: fmt(i.jatuh_tempo) },
        { label: 'Nominal', value: 'Rp ' + Number(i.nominal).toLocaleString('id-ID') },
        { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
    ];
    @endif

    const bayarBtn = document.getElementById('detail-bayar-btn');
    if (i.status === 'jatuh_tempo' || i.status === 'pending') {
        bayarBtn.style.display = '';
    } else {
        bayarBtn.style.display = 'none';
    }

    document.getElementById('detail-body').innerHTML = `
        <div class="space-y-1">
            ${rows.map((r, idx) => `
                <div class="flex items-center justify-between py-2.5" ${idx < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                    <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
                    <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</p>
                </div>
            `).join('')}
            <div class="flex items-center justify-between py-2.5">
                <p class="text-sm" style="color:var(--text-muted);">Status</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${s.bg};color:${s.text};border:1px solid ${s.border};">${s.label}</span>
            </div>
        </div>
    `;
    document.getElementById('detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function markAsLunas() {
    const id = detailId;
    if (!id) return;
    if (!confirm('Tandai pembayaran ini sebagai Lunas?')) return;

    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');
    formData.append('jenis', currentJenis);
    formData.append('status', 'lunas');
    formData.append('tanggal_bayar', new Date().toISOString().split('T')[0]);

    @if($jenis === 'internet')
    formData.append('nama_internet', i.nama_internet);
    formData.append('provider', i.provider);
    formData.append('pic', i.pic);
    formData.append('jabatan', i.jabatan);
    formData.append('masa_tenggang', i.masa_tenggang);
    formData.append('biaya', i.biaya);
    @else
    formData.append('periode', i.periode);
    formData.append('tanggal_tagihan', i.tanggal_tagihan);
    formData.append('jatuh_tempo', i.jatuh_tempo);
    formData.append('nominal', i.nominal);
    @endif

    fetch('{{ url('admin/pembayaran') }}/' + id, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: formData,
    }).then(r => {
        if (r.ok) { location.reload(); }
        else { r.json().then(e => { alert('Gagal: ' + JSON.stringify(e.errors || e)); }); }
    }).catch(() => { location.reload(); });
}

function closeDetail() {
    detailId = null;
    document.getElementById('detail-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function showInternetUsageDetail(id) {
    const u = internetUsageData.find(x => x.id === id);
    if (!u) return;

    document.getElementById('detail-title').textContent = u.ruangan + ' - ' + u.hari;

    const fmt = (d) => d ? new Date(d + 'T00:00:00').toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '-';

    const rows = [
        { label: 'Ruangan', value: u.ruangan },
        { label: 'Hari', value: u.hari },
        { label: 'Tanggal', value: fmt(u.tanggal) },
        { label: 'Penggunaan Wifi', value: Number(u.penggunaan_wifi).toFixed(2) + ' GB' },
        { label: 'Penggunaan Ethernet', value: Number(u.penggunaan_ethernet).toFixed(2) + ' GB' },
        { label: 'Pengecek', value: u.checker || '-' },
        { label: 'Keterangan', value: u.keterangan || '-' },
    ];

    const body = document.getElementById('detail-body');
    body.innerHTML = '';
    rows.forEach(function(r, i) {
        const div = document.createElement('div');
        div.style.cssText = 'display:flex;justify-content:space-between;align-items:center;padding:10px 0;' + (i < rows.length - 1 ? 'border-bottom:1px solid var(--border-color);' : '');
        div.innerHTML = '<span style="color:var(--text-muted);font-size:13px;">' + r.label + '</span><span style="color:var(--text-primary);font-size:13px;font-weight:600;text-align:right;max-width:55%;">' + r.value + '</span>';
        body.appendChild(div);
    });

    document.getElementById('detail-bayar-btn').style.display = 'none';
    var editBtn = document.getElementById('detail-edit-btn');
    if (editBtn) editBtn.style.display = 'none';

    document.getElementById('detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function editFromDetail() {
    const id = detailId;
    closeDetail();
    if (id) openEditModal(id);
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

function toggleDropdown(btn, id) {
    const all = document.querySelectorAll('.dropdown-menu');
    all.forEach(el => { if (el.id !== 'dropdown-' + id) el.style.display = 'none'; });
    const menu = document.getElementById('dropdown-' + id);
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(el => el.style.display = 'none');
    }
});

function openEditModal(id) {
    closeDetail();
    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    document.getElementById('modal-title').textContent = 'Edit Tagihan';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = i.id;
    document.getElementById('payment-form').action = '{{ url('admin/pembayaran') }}/' + i.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan Perubahan';

    @if($jenis === 'internet')
    document.getElementById('f-nama_internet').value = i.nama_internet;
    document.getElementById('f-provider').value = i.provider;
    document.getElementById('f-pic').value = i.pic;
    document.getElementById('f-jabatan').value = i.jabatan;
    document.getElementById('f-masa_tenggang').value = i.masa_tenggang;
    document.getElementById('f-biaya').value = i.biaya;
    @else
    document.getElementById('f-periode').value = i.periode;
    document.getElementById('f-tanggal_tagihan').value = i.tanggal_tagihan;
    document.getElementById('f-jatuh_tempo').value = i.jatuh_tempo;
    document.getElementById('f-nominal').value = i.nominal;
    document.getElementById('f-pic').value = i.pic;
    document.getElementById('f-jabatan').value = i.jabatan;
    if (document.getElementById('f-digital_asset_id')) {
        document.getElementById('f-digital_asset_id').value = i.digital_asset_id || '';
    }
    @endif

    document.getElementById('f-tanggal_bayar').value = i.tanggal_bayar || '';

    showPaymentModal();
}

function showPaymentModal() { document.getElementById('payment-modal').style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function closePaymentModal() { document.getElementById('payment-modal').style.display = 'none'; document.body.style.overflow = ''; }

document.getElementById('payment-modal')?.addEventListener('click', function(e) { if (e.target === this) closePaymentModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeDetail(); closePaymentModal(); } });

let currentFilter = 'all';

function toggleFilterMenu(e) {
    e.stopPropagation();
    const menu = document.getElementById('filter-menu');
    document.querySelectorAll('.filter-menu').forEach(m => { if (m.id !== 'filter-menu') m.style.display = 'none'; });
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

function setFilter(value) {
    currentFilter = value;
    const label = document.querySelector(`.filter-menu button[data-value="${value}"]`).textContent;
    document.getElementById('filter-label').textContent = label;
    document.getElementById('filter-menu').style.display = 'none';
    filterTable();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

let paymentPage = 1;
const paymentPerPage = 10;

function filterTable() {
    const search = (document.getElementById('search-payment')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#payment-tbody tr:not(#empty-row)');
    let visibleCount = 0;
    rows.forEach(row => {
        const rowStatus = row.dataset.status;
        const text = row.textContent.toLowerCase();
        const matchStatus = currentFilter === 'all' || rowStatus === currentFilter;
        const matchSearch = !search || text.includes(search);
        const visible = matchStatus && matchSearch;
        row.dataset.filtered = visible ? '1' : '0';
        visibleCount++;
    });
    paymentPage = 1;
    renderPaymentPage();
}

function renderPaymentPage() {
    const rows = document.querySelectorAll('#payment-tbody tr:not(#empty-row)');
    const filtered = Array.from(rows).filter(r => r.dataset.filtered !== '0');
    const total = filtered.length;
    const totalPages = Math.ceil(total / paymentPerPage);
    const start = (paymentPage - 1) * paymentPerPage;
    const end = start + paymentPerPage;

    rows.forEach(row => row.style.display = 'none');
    filtered.forEach((row, i) => {
        row.style.display = (i >= start && i < end) ? '' : 'none';
    });

    const emptyRow = document.querySelector('#payment-tbody tr td[colspan]');
    if (emptyRow) {
        const parent = emptyRow.closest('tr');
        if (total === 0) parent.style.display = '';
        else parent.style.display = 'none';
    }

    const pag = document.getElementById('payment-pagination');
    const info = document.getElementById('payment-pagination-info');
    const controls = document.getElementById('payment-pagination-controls');

    if (total <= paymentPerPage) {
        pag.style.display = 'none';
        return;
    }

    pag.style.display = 'flex';
    info.textContent = 'Menampilkan ' + (start + 1) + '-' + Math.min(end, total) + ' dari ' + total + ' data';

    let btns = '';
    btns += '<button onclick="goPaymentPage(' + (paymentPage - 1) + ')" class="px-2.5 py-1 rounded-lg text-xs font-medium transition" style="background:var(--bg-surface-2);color:var(--text-primary);border:1px solid var(--border-color);cursor:pointer;' + (paymentPage <= 1 ? 'opacity:0.4;pointer-events:none;' : '') + '">&laquo;</button>';

    for (let p = 1; p <= totalPages; p++) {
        if (totalPages > 7 && p > 2 && p < totalPages - 1 && Math.abs(p - paymentPage) > 1) {
            if (btns.indexOf('...') === -1) btns += '<span style="color:var(--text-muted);font-size:0.7rem;padding:0 4px;">...</span>';
            continue;
        }
        const active = p === paymentPage;
        btns += '<button onclick="goPaymentPage(' + p + ')" class="px-2.5 py-1 rounded-lg text-xs font-medium transition" style="background:' + (active ? 'var(--color-accent)' : 'var(--bg-surface-2)') + ';color:' + (active ? '#fff' : 'var(--text-primary)') + ';border:1px solid ' + (active ? 'var(--color-accent)' : 'var(--border-color)') + ';cursor:pointer;">' + p + '</button>';
    }

    btns += '<button onclick="goPaymentPage(' + (paymentPage + 1) + ')" class="px-2.5 py-1 rounded-lg text-xs font-medium transition" style="background:var(--bg-surface-2);color:var(--text-primary);border:1px solid var(--border-color);cursor:pointer;' + (paymentPage >= totalPages ? 'opacity:0.4;pointer-events:none;' : '') + '">&raquo;</button>';

    controls.innerHTML = btns;
}

function goPaymentPage(p) {
    const rows = document.querySelectorAll('#payment-tbody tr:not(#empty-row)');
    const filtered = Array.from(rows).filter(r => r.dataset.filtered !== '0');
    const totalPages = Math.ceil(filtered.length / paymentPerPage);
    if (p < 1 || p > totalPages) return;
    paymentPage = p;
    renderPaymentPage();
}

document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('#payment-tbody tr:not(#empty-row)');
    rows.forEach(row => { if (!row.dataset.filtered) row.dataset.filtered = '1'; });
    renderPaymentPage();
});



let kwhCamStream = null;
let kwhExistingBukti = null;

function openKwhCamera() {
    if (!!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia)) {
        navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } }).then(stream => {
            kwhCamStream = stream;
            document.getElementById('kwh-video').srcObject = stream;
            document.getElementById('kwh-camera-panel').style.display = 'block';
        }).catch(() => {
            alert('Kamera tidak dapat diakses. Gunakan tombol Upload Dokumen.\n\nCatatan: fitur kamera memerlukan akses HTTPS.');
        });
    } else {
        alert('Browser tidak mendukung akses kamera. Gunakan tombol Upload Dokumen.');
    }
}

function snapKwhPhoto() {
    const video = document.getElementById('kwh-video');
    const canvas = document.getElementById('kwh-canvas');
    if (!video.videoWidth) return;
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext('2d').drawImage(video, 0, 0);
    canvas.toBlob(blob => {
        if (!blob) return;
        const file = new File([blob], 'bukti-kwh-' + Date.now() + '.jpg', { type: 'image/jpeg' });
        const dt = new DataTransfer();
        dt.items.add(file);
        document.getElementById('f-token-bukti').files = dt.files;
        showTokenBuktiPreview(file);
        stopKwhCamera();
    }, 'image/jpeg', 0.9);
}

function stopKwhCamera() {
    if (kwhCamStream) {
        kwhCamStream.getTracks().forEach(t => t.stop());
        kwhCamStream = null;
    }
    document.getElementById('kwh-camera-panel').style.display = 'none';
}

function showTokenBuktiPreview(file) {
    if (!file) return;
    const thumb = document.getElementById('token-bukti-thumb');
    const icon = document.getElementById('token-bukti-fileicon');
    document.getElementById('token-bukti-name').textContent = file.name;
    document.getElementById('token-bukti-existing').style.display = kwhExistingBukti ? 'block' : 'none';
    document.getElementById('token-bukti-link').style.display = 'none';
    if (file.type && file.type.startsWith('image/')) {
        thumb.src = URL.createObjectURL(file);
        thumb.style.display = 'block';
        icon.style.display = 'none';
    } else {
        thumb.style.display = 'none';
        icon.style.display = 'flex';
    }
    document.getElementById('token-bukti-preview').style.display = 'block';
}

function showTokenBuktiExisting(path) {
    kwhExistingBukti = path || null;
    const prev = document.getElementById('token-bukti-preview');
    const thumb = document.getElementById('token-bukti-thumb');
    const icon = document.getElementById('token-bukti-fileicon');
    const link = document.getElementById('token-bukti-link');
    if (!path) { prev.style.display = 'none'; return; }
    const url = '{{ url('files') }}/' + path;
    document.getElementById('token-bukti-name').textContent = path.split('/').pop();
    document.getElementById('token-bukti-existing').style.display = 'block';
    if (/\.(jpe?g|png)$/i.test(path)) {
        thumb.src = url;
        thumb.style.display = 'block';
        icon.style.display = 'none';
    } else {
        thumb.style.display = 'none';
        icon.style.display = 'flex';
    }
    link.href = url;
    link.style.display = 'inline';
    prev.style.display = 'block';
}

function clearTokenBukti() {
    document.getElementById('f-token-bukti').value = '';
    if (kwhExistingBukti) {
        showTokenBuktiExisting(kwhExistingBukti);
    } else {
        document.getElementById('token-bukti-preview').style.display = 'none';
    }
}

function resetTokenForm() {
    const form = document.getElementById('token-form');
    form.action = '{{ route('admin.pembayaran.token-reading.store') }}';
    document.getElementById('token-method').value = 'POST';
    document.getElementById('token-modal-title').textContent = 'Input Pengecekan Token';
    document.getElementById('token-submit-btn').textContent = 'Simpan';
    form.querySelectorAll('input, textarea, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method' && el.name !== 'checked_date') {
            el.value = '';
        }
    });
    document.getElementById('f-checked_date').value = '{{ date('Y-m-d') }}';
    const defChecked = document.getElementById('f-checked_by').querySelector('option[selected]');
    if (defChecked) document.getElementById('f-checked_by').value = defChecked.value;
    stopKwhCamera();
    kwhExistingBukti = null;
    document.getElementById('token-bukti-preview').style.display = 'none';
}

function openTokenModal() {
    resetTokenForm();
    document.getElementById('token-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-remaining_kwh').focus();
}

function closeTokenModal() {
    stopKwhCamera();
    document.getElementById('token-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function openEditTokenReading(id) {
    const r = tokenReadingData.find(x => x.id === id);
    if (!r) return;
    resetTokenForm();
    document.getElementById('token-modal-title').textContent = 'Edit Pengecekan Token';
    document.getElementById('token-submit-btn').textContent = 'Simpan Perubahan';
    document.getElementById('token-method').value = 'PUT';
    document.getElementById('token-form').action = '{{ route('admin.pembayaran.token-reading.update', ['id' => 0]) }}'.slice(0, -1) + id;
    document.getElementById('f-remaining_kwh').value = r.remaining_kwh;
    document.getElementById('f-checked_date').value = r.checked_date;
    document.getElementById('f-checked_by').value = r.checked_by;
    document.getElementById('f-notes').value = r.notes || '';
    showTokenBuktiExisting(r.bukti_foto);
    document.getElementById('token-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-remaining_kwh').focus();
}

const tokenReadingStatusMap = {
    segera_isi: { color: '#ef4444', bg: 'rgba(239,68,68,0.15)', border: 'rgba(239,68,68,0.3)', label: 'Segera Isi Token' },
    warning: { color: '#f97316', bg: 'rgba(249,115,22,0.15)', border: 'rgba(249,115,22,0.3)', label: 'Warning' },
    perhatian: { color: '#3b82f6', bg: 'rgba(59,130,246,0.15)', border: 'rgba(59,130,246,0.3)', label: 'Perhatian' },
    aman: { color: '#10b981', bg: 'rgba(16,185,129,0.15)', border: 'rgba(16,185,129,0.3)', label: 'Aman' },
};

function showTokenReadingDetail(id) {
    const r = tokenReadingData.find(x => x.id === id);
    if (!r) return;
    const fmtDate = new Date(r.checked_date + 'T00:00:00').toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    const st = tokenReadingStatusMap[r.status] || tokenReadingStatusMap.aman;
    let buktiValue = '-';
    if (r.bukti_foto) {
        const buktiUrl = '{{ url('files') }}/' + r.bukti_foto;
        buktiValue = /\.(jpe?g|png)$/i.test(r.bukti_foto)
            ? `<a href="${buktiUrl}" target="_blank" rel="noopener" title="Lihat bukti pengecekan KWH"><img src="${buktiUrl}" alt="Bukti KWH" style="max-width:140px;max-height:90px;border-radius:8px;object-fit:cover;border:1px solid var(--border-color);display:block;margin-left:auto;"></a>`
            : `<a href="${buktiUrl}" target="_blank" rel="noopener" style="color:#6c5cff;">Lihat Dokumen</a>`;
    }
    const rows = [
        { label: 'Tanggal Check', value: fmtDate },
        { label: 'Sisa KWH', value: Number(r.remaining_kwh).toLocaleString('id-ID') + ' KWH' },
        { label: 'Terpakai', value: Number(r.terpakai).toLocaleString('id-ID') + ' KWH' },
        { label: 'Pengecek', value: r.checker ? r.checker.name : '-' },
        { label: 'Catatan', value: r.notes || '-' },
        { label: 'Bukti', value: buktiValue },
    ];
    const statusBlock = `<div class="mt-3"><div class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);margin-bottom:6px;">Status</div>
        <span class="badge text-xs" style="background:${st.bg};color:${st.color};border:1px solid ${st.border};">${st.label}</span></div>`;
    document.getElementById('token-reading-detail-body').innerHTML = `
        <div class="space-y-0">
            ${rows.map((row, idx) => `
                <div class="flex items-center justify-between py-2.5" style="${idx < rows.length - 1 ? 'border-bottom:1px solid var(--border-color);' : ''}">
                    <span class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);">${row.label}</span>
                    <span class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${row.value}</span>
                </div>
            `).join('')}
        </div>
        ${statusBlock}
    `;
    document.getElementById('token-reading-detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeTokenReadingDetail() {
    document.getElementById('token-reading-detail-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function setTabPill(activeId, inactiveId) {
    const on = document.getElementById(activeId);
    const off = document.getElementById(inactiveId);
    if (!on || !off) return;
    on.style.background = 'rgba(124,58,237,0.15)';
    on.style.color = '#a78bfa';
    on.style.fontWeight = '600';
    off.style.background = 'none';
    off.style.color = 'var(--text-muted)';
    off.style.fontWeight = '500';
}

function switchListrikTab(tab) {
    const isTopup = tab === 'topup';
    document.getElementById('listrik-tab-topup').style.display = isTopup ? '' : 'none';
    document.getElementById('listrik-tab-reading').style.display = isTopup ? 'none' : '';
    setTabPill(isTopup ? 'pill-listrik-topup' : 'pill-listrik-reading', isTopup ? 'pill-listrik-reading' : 'pill-listrik-topup');
}

function switchInternetTab(tab) {
    const tabs = ['bayar', 'usage', 'quota-topup', 'quota-reading'];
    const tabIds = { 'bayar': 'internet-tab-bayar', 'usage': 'internet-tab-usage', 'quota-topup': 'internet-tab-quota-topup', 'quota-reading': 'internet-tab-quota-reading' };
    const pillIds = { 'bayar': 'pill-internet-bayar', 'usage': 'pill-internet-usage', 'quota-topup': 'pill-internet-quota-topup', 'quota-reading': 'pill-internet-quota-reading' };
    tabs.forEach(function(t) {
        const el = document.getElementById(tabIds[t]);
        const pill = document.getElementById(pillIds[t]);
        if (el) el.style.display = t === tab ? '' : 'none';
        if (pill) {
            pill.style.background = t === tab ? 'rgba(124,58,237,0.15)' : 'none';
            pill.style.color = t === tab ? '#a78bfa' : 'var(--text-muted)';
            pill.style.fontWeight = t === tab ? '600' : '500';
        }
    });
}

function filterUsageTable() {
    const q = (document.getElementById('search-usage')?.value || '').toLowerCase();
    document.querySelectorAll('#usage-tbody tr').forEach(tr => {
        if (tr.querySelector('td[colspan]')) return;
        tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

function openInternetUsageModal() {
    document.getElementById('internet-usage-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeInternetUsageModal() {
    document.getElementById('internet-usage-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('token-modal')?.addEventListener('click', function(e) { if (e.target === this) closeTokenModal(); });
document.getElementById('internet-usage-modal')?.addEventListener('click', function(e) { if (e.target === this) closeInternetUsageModal(); });
document.getElementById('token-reading-detail-modal')?.addEventListener('click', function(e) { if (e.target === this) closeTokenReadingDetail(); });
document.getElementById('topup-modal')?.addEventListener('click', function(e) { if (e.target === this) closeTopupModal(); });
document.getElementById('topup-detail-modal')?.addEventListener('click', function(e) { if (e.target === this) closeTopupDetail(); });
document.getElementById('quota-topup-modal')?.addEventListener('click', function(e) { if (e.target === this) closeQuotaTopupModal(); });
document.getElementById('quota-topup-detail-modal')?.addEventListener('click', function(e) { if (e.target === this) closeQuotaTopupDetail(); });
document.getElementById('quota-reading-modal')?.addEventListener('click', function(e) { if (e.target === this) closeQuotaReadingModal(); });
document.getElementById('quota-reading-detail-modal')?.addEventListener('click', function(e) { if (e.target === this) closeQuotaReadingDetail(); });

function resetTopupForm() {
    const form = document.getElementById('topup-form');
    form.action = '{{ route('admin.pembayaran.token-topup.store') }}';
    document.getElementById('topup-method').value = 'POST';
    document.getElementById('topup-modal-title').textContent = 'Top Up Token Listrik';
    document.getElementById('topup-submit-btn').textContent = 'Simpan';
    document.getElementById('topup-bukti-hint').textContent = 'Foto/scan bukti pembayaran (JPG/PNG, maks 2MB). Opsional.';
    form.querySelectorAll('input, textarea, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method' && el.name !== 'payment_date') {
            el.value = '';
        }
    });
    document.getElementById('f-payment_date').value = '{{ date('Y-m-d') }}';
}

function openTopupModal() {
    resetTopupForm();
    document.getElementById('topup-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-amount_kwh').focus();
}

function closeTopupModal() {
    document.getElementById('topup-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function showTopupDetail(id) {
    const t = topupData.find(x => x.id === id);
    if (!t) return;
    const fmtDate = new Date(t.payment_date + 'T00:00:00').toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    const nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(t.nominal);
    const rows = [
        { label: 'Tanggal Bayar', value: fmtDate },
        { label: 'Periode', value: t.period || '-' },
        { label: 'Jumlah KWH', value: Number(t.amount_kwh).toLocaleString('id-ID') + ' KWH' },
        { label: 'Nominal', value: nominal },
        { label: 'Oleh', value: t.creator ? t.creator.name : '-' },
        { label: 'Catatan', value: t.notes || '-' },
    ];
    const buktiBlock = t.bukti_bayar
        ? `<div class="mt-3"><div class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);margin-bottom:6px;">Bukti Pembayaran</div>
           <a href="{{ url('files') }}/${t.bukti_bayar}" target="_blank" rel="noopener">
               <img src="{{ url('files') }}/${t.bukti_bayar}" alt="Bukti" style="max-width:100%;max-height:220px;border-radius:10px;border:1px solid var(--border-color);object-fit:contain;display:block;">
           </a></div>`
        : `<div class="mt-3"><div class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);">Bukti Pembayaran</div>
           <div class="text-sm" style="color:var(--text-muted);">Tidak ada bukti</div></div>`;

    document.getElementById('topup-detail-body').innerHTML = `
        <div class="space-y-0">
            ${rows.map((r, idx) => `
                <div class="flex items-center justify-between py-2.5" style="${idx < rows.length - 1 ? 'border-bottom:1px solid var(--border-color);' : ''}">
                    <span class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);">${r.label}</span>
                    <span class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</span>
                </div>
            `).join('')}
        </div>
        ${buktiBlock}
    `;
    document.getElementById('topup-detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeTopupDetail() {
    document.getElementById('topup-detail-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function openEditTopup(id) {
    const t = topupData.find(x => x.id === id);
    if (!t) return;
    resetTopupForm();
    document.getElementById('topup-modal-title').textContent = 'Edit Top Up Token Listrik';
    document.getElementById('topup-submit-btn').textContent = 'Simpan Perubahan';
    document.getElementById('topup-bukti-hint').textContent = t.bukti_bayar ? 'Bukti saat ini tersedia. Kosongkan jika tidak mengganti.' : 'Belum ada bukti. Opsional.';
    document.getElementById('topup-method').value = 'PUT';
    document.getElementById('topup-form').action = '{{ route('admin.pembayaran.token-topup.update', ['id' => 0]) }}'.slice(0, -1) + id;
    document.getElementById('f-amount_kwh').value = t.amount_kwh;
    document.getElementById('f-nominal').value = t.nominal;
    document.getElementById('f-payment_date').value = String(t.payment_date).slice(0, 10);
    document.getElementById('f-topup-notes').value = t.notes || '';
    document.getElementById('f-topup-bukti').value = '';
    document.getElementById('topup-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-amount_kwh').focus();
}

function setTopupRange(range) {
    const params = new URLSearchParams(window.location.search);
    params.set('topup_range', range);
    params.delete('reading_range');
    window.location.search = params.toString();
}

function setReadingRange(range) {
    const params = new URLSearchParams(window.location.search);
    params.set('reading_range', range);
    params.delete('topup_range');
    window.location.search = params.toString();
}

function setQuotaTopupRange(range) {
    const params = new URLSearchParams(window.location.search);
    params.set('jenis', 'internet');
    params.set('quota_topup_range', range);
    params.delete('quota_reading_range');
    window.location.search = params.toString();
}

function setQuotaReadingRange(range) {
    const params = new URLSearchParams(window.location.search);
    params.set('jenis', 'internet');
    params.set('quota_reading_range', range);
    params.delete('quota_topup_range');
    window.location.search = params.toString();
}

function resetQuotaTopupForm() {
    const form = document.getElementById('quota-topup-form');
    form.action = '{{ route('admin.pembayaran.internet-quota-topup.store') }}';
    document.getElementById('quota-topup-method').value = 'POST';
    document.getElementById('quota-topup-modal-title').textContent = 'Pembelian Kuota Internet';
    document.getElementById('quota-topup-submit-btn').textContent = 'Simpan';
    document.getElementById('quota-topup-bukti-hint').textContent = 'Foto/scan bukti pembayaran (JPG/PNG, maks 2MB). Opsional.';
    form.querySelectorAll('input, textarea, select').forEach(function(el) {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method' && el.name !== 'payment_date') {
            el.value = '';
        }
    });
    document.getElementById('f-qt-payment_date').value = '{{ date('Y-m-d') }}';
}

function openQuotaTopupModal() {
    resetQuotaTopupForm();
    document.getElementById('quota-topup-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-qt-amount_gb').focus();
}

function closeQuotaTopupModal() {
    document.getElementById('quota-topup-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function openEditQuotaTopup(id) {
    const t = quotaTopupData.find(function(x) { return x.id === id; });
    if (!t) return;
    resetQuotaTopupForm();
    document.getElementById('quota-topup-modal-title').textContent = 'Edit Pembelian Kuota';
    document.getElementById('quota-topup-submit-btn').textContent = 'Simpan Perubahan';
    document.getElementById('quota-topup-bukti-hint').textContent = t.bukti_bayar ? 'Bukti saat ini tersedia. Kosongkan jika tidak mengganti.' : 'Belum ada bukti. Opsional.';
    document.getElementById('quota-topup-method').value = 'PUT';
    document.getElementById('quota-topup-form').action = '{{ route('admin.pembayaran.internet-quota-topup.update', ['id' => 0]) }}'.slice(0, -1) + id;
    document.getElementById('f-qt-wifi_payment_id').value = t.wifi_payment_id;
    document.getElementById('f-qt-amount_gb').value = t.amount_gb;
    document.getElementById('f-qt-nominal').value = t.nominal;
    document.getElementById('f-qt-payment_date').value = String(t.payment_date).slice(0, 10);
    document.getElementById('f-qt-notes').value = t.notes || '';
    document.getElementById('f-qt-bukti').value = '';
    document.getElementById('quota-topup-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-qt-amount_gb').focus();
}

function showQuotaTopupDetail(id) {
    var t = quotaTopupData.find(function(x) { return x.id === id; });
    if (!t) return;
    var fmtDate = new Date(t.payment_date + 'T00:00:00').toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    var nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(t.nominal);
    var wifiName = internetWifiItems[t.wifi_payment_id] || '-';
    var rows = [
        { label: 'Tanggal Bayar', value: fmtDate },
        { label: 'Internet', value: wifiName },
        { label: 'Periode', value: t.period || '-' },
        { label: 'Jumlah GB', value: Number(t.amount_gb).toLocaleString('id-ID', { minimumFractionDigits: 2 }) + ' GB' },
        { label: 'Nominal', value: nominal },
        { label: 'Oleh', value: t.creator ? t.creator.name : '-' },
        { label: 'Catatan', value: t.notes || '-' },
    ];
    var buktiBlock = t.bukti_bayar
        ? '<div class="mt-3"><div class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);margin-bottom:6px;">Bukti Pembayaran</div>' +
           '<a href="{{ url("files") }}/' + t.bukti_bayar + '" target="_blank" rel="noopener">' +
               '<img src="{{ url("files") }}/' + t.bukti_bayar + '" alt="Bukti" style="max-width:100%;max-height:220px;border-radius:10px;border:1px solid var(--border-color);object-fit:contain;display:block;">' +
           '</a></div>'
        : '<div class="mt-3"><div class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);">Bukti Pembayaran</div>' +
           '<div class="text-sm" style="color:var(--text-muted);">Tidak ada bukti</div></div>';

    document.getElementById('quota-topup-detail-body').innerHTML =
        '<div class="space-y-0">' +
            rows.map(function(r, idx) {
                return '<div class="flex items-center justify-between py-2.5" style="' + (idx < rows.length - 1 ? 'border-bottom:1px solid var(--border-color);' : '') + '">' +
                    '<span class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);">' + r.label + '</span>' +
                    '<span class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">' + r.value + '</span>' +
                '</div>';
            }).join('') +
        '</div>' + buktiBlock;
    document.getElementById('quota-topup-detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeQuotaTopupDetail() {
    document.getElementById('quota-topup-detail-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function resetQuotaReadingForm() {
    var form = document.getElementById('quota-reading-form');
    form.action = '{{ route('admin.pembayaran.internet-quota-reading.store') }}';
    document.getElementById('quota-reading-method').value = 'POST';
    document.getElementById('quota-reading-modal-title').textContent = 'Input Pengecekan Kuota';
    document.getElementById('quota-reading-submit-btn').textContent = 'Simpan';
    document.getElementById('quota-reading-bukti-hint').textContent = 'Foto/dokumen pendukung (JPG/PNG/PDF, maks 2MB). Opsional.';
    form.querySelectorAll('input, textarea, select').forEach(function(el) {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method' && el.name !== 'checked_date') {
            el.value = '';
        }
    });
    document.getElementById('f-qr-checked_date').value = '{{ date('Y-m-d') }}';
    document.getElementById('f-qr-checked_by').value = '{{ auth()->id() }}';
}

function openQuotaReadingModal() {
    resetQuotaReadingForm();
    document.getElementById('quota-reading-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-qr-remaining_gb').focus();
}

function closeQuotaReadingModal() {
    document.getElementById('quota-reading-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function openEditQuotaReading(id) {
    var r = quotaReadingData.find(function(x) { return x.id === id; });
    if (!r) return;
    resetQuotaReadingForm();
    document.getElementById('quota-reading-modal-title').textContent = 'Edit Pengecekan Kuota';
    document.getElementById('quota-reading-submit-btn').textContent = 'Simpan Perubahan';
    document.getElementById('quota-reading-bukti-hint').textContent = r.bukti_foto ? 'Bukti saat ini tersedia. Kosongkan jika tidak mengganti.' : 'Belum ada bukti. Opsional.';
    document.getElementById('quota-reading-method').value = 'PUT';
    document.getElementById('quota-reading-form').action = '{{ route('admin.pembayaran.internet-quota-reading.update', ['id' => 0]) }}'.slice(0, -1) + id;
    document.getElementById('f-qr-wifi_payment_id').value = r.wifi_payment_id;
    document.getElementById('f-qr-remaining_gb').value = r.remaining_gb;
    document.getElementById('f-qr-checked_date').value = String(r.checked_date).slice(0, 10);
    document.getElementById('f-qr-checked_by').value = r.checked_by;
    document.getElementById('f-qr-notes').value = r.notes || '';
    document.getElementById('f-qr-bukti').value = '';
    document.getElementById('quota-reading-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-qr-remaining_gb').focus();
}

function showQuotaReadingDetail(id) {
    var r = quotaReadingData.find(function(x) { return x.id === id; });
    if (!r) return;
    var fmtDate = new Date(r.checked_date + 'T00:00:00').toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    var statusMap = { 'habis': ['#ef4444', 'Habis'], 'segera_habis': ['#f97316', 'Segera Habis'], 'perhatian': ['#3b82f6', 'Perhatian'], 'aman': ['#10b981', 'Aman'] };
    var statusColor = (statusMap[r.status] || ['#10b981', 'Aman'])[0];
    var statusLabel = (statusMap[r.status] || ['#10b981', 'Aman'])[1];
    var wifiName = internetWifiItems[r.wifi_payment_id] || '-';
    var rows = [
        { label: 'Tanggal Check', value: fmtDate },
        { label: 'Internet', value: wifiName },
        { label: 'Sisa Kuota', value: Number(r.remaining_gb).toLocaleString('id-ID', { minimumFractionDigits: 2 }) + ' GB' },
        { label: 'Status', value: '<span class="badge text-xs" style="background:' + (statusColor === '#10b981' ? 'rgba(16,185,129,0.15)' : (statusColor === '#3b82f6' ? 'rgba(59,130,246,0.15)' : (statusColor === '#f97316' ? 'rgba(249,115,22,0.15)' : 'rgba(239,68,68,0.15)'))) + ';color:' + statusColor + ';border:1px solid ' + (statusColor === '#10b981' ? 'rgba(16,185,129,0.3)' : (statusColor === '#3b82f6' ? 'rgba(59,130,246,0.3)' : (statusColor === '#f97316' ? 'rgba(249,115,22,0.3)' : 'rgba(239,68,68,0.3)')) + ';">' + statusLabel + '</span>' },
        { label: 'Pengecek', value: r.checker ? r.checker.name : '-' },
        { label: 'Catatan', value: r.notes || '-' },
    ];
    var buktiBlock = r.bukti_foto
        ? '<div class="mt-3"><div class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);margin-bottom:6px;">Bukti Pengecekan</div>' +
           '<a href="{{ url("files") }}/' + r.bukti_foto + '" target="_blank" rel="noopener">' +
               '<img src="{{ url("files") }}/' + r.bukti_foto + '" alt="Bukti" style="max-width:100%;max-height:220px;border-radius:10px;border:1px solid var(--border-color);object-fit:contain;display:block;">' +
           '</a></div>'
        : '<div class="mt-3"><div class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);">Bukti Pengecekan</div>' +
           '<div class="text-sm" style="color:var(--text-muted);">Tidak ada bukti</div></div>';

    document.getElementById('quota-reading-detail-body').innerHTML =
        '<div class="space-y-0">' +
            rows.map(function(r, idx) {
                return '<div class="flex items-center justify-between py-2.5" style="' + (idx < rows.length - 1 ? 'border-bottom:1px solid var(--border-color);' : '') + '">' +
                    '<span class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);">' + r.label + '</span>' +
                    '<span class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">' + r.value + '</span>' +
                '</div>';
            }).join('') +
        '</div>' + buktiBlock;
    document.getElementById('quota-reading-detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeQuotaReadingDetail() {
    document.getElementById('quota-reading-detail-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function openBulkIplModal() {
    document.getElementById('bulk-ipl-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-bulk-nominal').focus();
}

function closeBulkIplModal() {
    document.getElementById('bulk-ipl-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function showBulkIplConfirm(e) {
    e.preventDefault();
    var year = document.getElementById('f-bulk-year').value;
    var nominal = document.getElementById('f-bulk-nominal').value;
    if (!year || !nominal) return false;
    document.getElementById('confirm-bulk-year').textContent = year;
    document.getElementById('confirm-bulk-nominal').textContent = 'Rp ' + Number(nominal).toLocaleString('id-ID') + ' / bulan';
    document.getElementById('bulk-ipl-confirm-modal').style.display = 'flex';
    return false;
}

function closeBulkIplConfirm() {
    document.getElementById('bulk-ipl-confirm-modal').style.display = 'none';
}

function submitBulkIpl() {
    document.getElementById('bulk-ipl-confirm-modal').style.display = 'none';
    closeBulkIplModal();
    document.querySelector('#bulk-ipl-modal form').submit();
}

document.getElementById('bulk-ipl-confirm-modal')?.addEventListener('click', function(e) { if (e.target === this) closeBulkIplConfirm(); });

document.getElementById('bulk-ipl-modal')?.addEventListener('click', function(e) { if (e.target === this) closeBulkIplModal(); });

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTokenModal();
        closeTopupModal();
        closeBulkIplConfirm();
        closeBulkIplModal();
        closeAlertPopup();
        closeBayarModal();
        closeQuotaTopupModal();
        closeQuotaTopupDetail();
        closeQuotaReadingModal();
        closeQuotaReadingDetail();
        document.body.style.overflow = '';
    }
});
</script>
@endsection

@push('styles')
<style>
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px 24px;
    margin-bottom: 16px;
}
@media (max-width: 640px) {
    .form-grid-2 { grid-template-columns: 1fr; }
}
.field-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.field-req { color: #f87171; }
.form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 16px;
    margin-top: 8px;
    border-top: 1px solid var(--border-color);
}
.btn-form {
    padding: 8px 22px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}
.btn-form-batal {
    background: transparent;
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.7);
}
.btn-form-batal:hover {
    border-color: rgba(255,255,255,0.3);
    color: #fff;
}
.btn-form-simpan {
    background: linear-gradient(135deg, #6c5cff, #8b7bff);
    color: #fff;
    box-shadow: 0 4px 15px rgba(108,92,255,0.3);
}
.btn-form-simpan:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(108,92,255,0.4);
}
</style>
@endpush

