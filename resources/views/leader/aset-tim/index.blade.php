@extends('layouts.app')
@section('title', 'Aset TIM Saya')
@section('page-title', 'Operasional > Aset TIM')
@section('page-subtitle', 'Daftar aset tim yang menjadi tanggung jawab saya')
@section('sidebar-menu') @include(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Aset TIM — Tanggung Jawab Saya</div>
            <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Aset tim yang ditugaskan kepada anda.</div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[600px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Tim</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assets as $a)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $a->nama_aset }}</td>
                        <td style="color:var(--text-muted);">{{ $a->tim ?? '-' }}</td>
                        <td style="color:var(--text-muted);">{{ $a->jumlah }}</td>
                        <td><span class="badge {{ $a->is_active ? 'badge-green' : 'badge-red' }}">{{ $a->is_active ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                        <td style="color:var(--text-muted);max-width:200px;">{{ $a->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada aset tim yang ditugaskan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
