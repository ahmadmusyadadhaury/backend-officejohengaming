@extends('layouts.app')
@section('title', 'Persetujuan Pembayaran')
@section('page-title', 'Persetujuan Pembayaran')
@section('page-subtitle', 'Pengajuan pembayaran yang menunggu persetujuan')

@section('sidebar-menu') @include('partials.sidebar-admin') @endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">
    @if($requests->isEmpty())
    <div class="gaming-card p-8 text-center">
        <svg class="w-16 h-16 mx-auto mb-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p style="color:var(--text-secondary);font-size:14px;">Tidak ada pengajuan yang menunggu persetujuan.</p>
    </div>
    @else
    <div class="gaming-card">
        <div class="table-responsive">
            <table class="gaming-table min-w-[800px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Pengaju</th>
                        <th>Jenis</th>
                        <th>Detail</th>
                        <th>Nominal</th>
                        <th>Tgl Bayar</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $i => $r)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td style="font-size:12px;color:var(--text-secondary);">{{ $r['created_at'] }}</td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $r['requester_name'] }}</td>
                        <td><span class="text-xs font-semibold" style="color:var(--text-secondary);">{{ $r['jenis_label'] }}</span></td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $r['detail'] }}</td>
                        <td style="color:var(--text-primary);">Rp {{ number_format($r['nominal'], 0, ',', '.') }}</td>
                        <td style="font-size:13px;color:var(--text-secondary);">{{ $r['tanggal_bayar'] }}</td>
                        <td>
                            @if($r['bukti_url'])
                            <a href="{{ $r['bukti_url'] }}" target="_blank" class="btn btn-secondary btn-sm" style="padding:4px 10px;font-size:11px;">Lihat</a>
                            @else
                            <span class="text-xs" style="color:var(--text-muted);">-</span>
                            @endif
                        </td>
                        <td>
                            @if($isApprover)
                            <div class="flex gap-2">
                                <button type="button" onclick="approve({{ $r['id'] }}, '{{ $r['jenis'] }}')" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:#10b981;color:#fff;border:none;cursor:pointer;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">Setujui</button>
                                <button type="button" onclick="openReject({{ $r['id'] }}, '{{ $r['jenis'] }}')" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:#ef4444;color:#fff;border:none;cursor:pointer;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Tolak</button>
                            </div>
                            @else
                            <span class="text-xs" style="color:var(--text-muted);">-</span>
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

{{-- Modal Reject --}}
<div id="reject-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Tolak Pengajuan</h3>
            <button type="button" onclick="closeReject()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5">
            <div class="field-group mb-4">
                <label class="gaming-label">Alasan Ditolak <span class="field-req">*</span></label>
                <textarea id="reject-notes" rows="4" class="gaming-input" placeholder="Tuliskan alasan penolakan..." style="resize:vertical;min-height:100px;"></textarea>
            </div>
            <div style="display:flex;gap:8px;justify-content:flex-end;">
                <button type="button" onclick="closeReject()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;">Batal</button>
                <button type="button" onclick="reject()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:#ef4444;color:#fff;border:none;cursor:pointer;">Tolak</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let rejectId = null;
let rejectJenis = null;

function approve(id, jenis) {
    if (!confirm('Setujui pembayaran ini?')) return;

    const form = new FormData();
    form.append('_token', '{{ csrf_token() }}');
    form.append('jenis', jenis);

    fetch('{{ url('admin/payment-approvals') }}/' + id + '/approve', {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: form,
    }).then(r => {
        if (r.ok) { location.reload(); }
        else { r.json().then(e => { alert('Gagal: ' + (e.error || JSON.stringify(e))); }); }
    }).catch(() => { location.reload(); });
}

function openReject(id, jenis) {
    rejectId = id;
    rejectJenis = jenis;
    document.getElementById('reject-notes').value = '';
    document.getElementById('reject-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeReject() {
    rejectId = null;
    rejectJenis = null;
    document.getElementById('reject-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function reject() {
    const notes = document.getElementById('reject-notes').value.trim();
    if (!notes) { alert('Alasan penolakan harus diisi.'); return; }

    const form = new FormData();
    form.append('_token', '{{ csrf_token() }}');
    form.append('jenis', rejectJenis);
    form.append('notes', notes);

    fetch('{{ url('admin/payment-approvals') }}/' + rejectId + '/reject', {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: form,
    }).then(r => {
        if (r.ok) { location.reload(); }
        else { r.json().then(e => { alert('Gagal: ' + (e.error || JSON.stringify(e))); }); }
    }).catch(() => { location.reload(); });
}

document.getElementById('reject-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeReject();
});
</script>
@endpush
