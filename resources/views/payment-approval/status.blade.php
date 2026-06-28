@extends('layouts.app')
@section('title', 'Status Pengajuan')
@section('page-title', 'Status Pengajuan Pembayaran')
@section('page-subtitle', 'Riwayat pengajuan pembayaran kamu')

@section('sidebar-menu')
    @php $role = auth()->user()->role; @endphp
    @include($role === 'koordinator' ? 'partials.sidebar-leader' : ($role === 'hr' ? 'partials.sidebar-admin' : 'partials.sidebar-user'))
@endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">
    <div class="flex justify-between items-center">
        <div></div>
        <a href="{{ route('payment-approval.create') }}" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Ajukan Baru
        </a>
    </div>

    @if($requests->isEmpty())
    <div class="gaming-card p-8 text-center">
        <svg class="w-16 h-16 mx-auto mb-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        <p style="color:var(--text-secondary);font-size:14px;">Belum ada pengajuan pembayaran.</p>
        <a href="{{ route('payment-approval.create') }}" class="btn btn-primary btn-sm mt-4 inline-flex items-center gap-1.5">Ajukan Pembayaran</a>
    </div>
    @else
    <div class="gaming-card">
        <div class="table-responsive">
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Detail</th>
                        <th>Nominal</th>
                        <th>Tgl Bayar</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $i => $r)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td><span class="text-xs font-semibold" style="color:var(--text-secondary);">{{ $r['jenis_label'] }}</span></td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $r['detail'] }}</td>
                        <td style="color:var(--text-primary);">Rp {{ number_format($r['nominal'], 0, ',', '.') }}</td>
                        <td style="color:var(--text-secondary);font-size:13px;">{{ $r['tanggal_bayar'] }}</td>
                        <td>
                            @if($r['status'] === 'lunas')
                                <span class="badge badge-green">Disetujui</span>
                            @elseif($r['status'] === 'pending')
                                <span class="badge badge-yellow">Menunggu</span>
                            @elseif($r['status'] === 'rejected')
                                <span class="badge badge-red">Ditolak</span>
                            @else
                                <span class="badge badge-yellow">{{ ucfirst($r['status']) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($r['bukti_url'])
                            <a href="{{ $r['bukti_url'] }}" target="_blank" class="text-xs font-semibold" style="color:#6c5cff;">Lihat</a>
                            @else
                            <span class="text-xs" style="color:var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td style="font-size:12px;color:var(--text-secondary);">
                            @if($r['status'] === 'lunas')
                                {{ $r['approver_name'] ?? '-' }}<br><span style="font-size:11px;">{{ $r['approved_at'] }}</span>
                            @elseif($r['status'] === 'rejected' && $r['notes'])
                                <span style="color:#ef4444;">{{ $r['notes'] }}</span>
                            @else
                                <span style="color:var(--text-muted);">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
