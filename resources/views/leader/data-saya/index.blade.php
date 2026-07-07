@extends('layouts.app')
@section('title', 'Data Saya')
@section('page-title', 'Data Saya')
@section('page-subtitle', 'Ringkasan aset yang menjadi tanggung jawab saya')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(124,58,237,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);">{{ $asetDaya->count() }}</div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Aset Daya</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);">Aset daya yang ditugaskan</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(16,185,129,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);">{{ $asetTim->count() }}</div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Aset TIM</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);">Aset tim yang ditugaskan</div>
            </div>
        </div>
    </div>

    {{-- Tabel Aset Daya --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Aset Daya</div>
            <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Aset daya yang menjadi tanggung jawab saya.</div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[500px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Daya</th>
                        <th>Unit</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asetDaya as $a)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $a->nama_aset }}</td>
                        <td style="color:var(--text-muted);">{{ $a->daya ?? '-' }}</td>
                        <td style="color:var(--text-muted);">{{ $a->unit ?? '-' }}</td>
                        <td><span class="badge {{ $a->is_active ? 'badge-green' : 'badge-red' }}">{{ $a->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;padding:1.5rem;color:var(--text-muted);">Belum ada aset daya yang ditugaskan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tabel Aset TIM --}}
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Aset TIM</div>
            <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Aset tim yang menjadi tanggung jawab saya.</div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[500px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Tim</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asetTim as $a)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $a->nama_aset }}</td>
                        <td style="color:var(--text-muted);">{{ $a->tim ?? '-' }}</td>
                        <td style="color:var(--text-muted);">{{ $a->jumlah }}</td>
                        <td><span class="badge {{ $a->is_active ? 'badge-green' : 'badge-red' }}">{{ $a->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;padding:1.5rem;color:var(--text-muted);">Belum ada aset tim yang ditugaskan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="gaming-card p-5 text-center">
        <p style="color:var(--text-muted);font-size:13px;">
            Untuk pembayaran tagihan, silakan buka menu 
            <a href="{{ route('payment-approval.tagihan') }}" style="color:#6c5cff;font-weight:600;text-decoration:underline;">Tagihan</a>.
        </p>
    </div>
</div>
@endsection
