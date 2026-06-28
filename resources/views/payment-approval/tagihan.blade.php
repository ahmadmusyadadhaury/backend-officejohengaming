@extends('layouts.app')
@section('title', 'Tagihan')
@section('page-title', 'Tagihan Pembayaran')
@section('page-subtitle', 'Daftar tagihan yang perlu dibayar')

@section('sidebar-menu')
    @php $role = auth()->user()->role; @endphp
    @include($role === 'koordinator' ? 'partials.sidebar-leader' : ($role === 'hr' ? 'partials.sidebar-admin' : 'partials.sidebar-user'))
@endsection

@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    @if($tagihan->isEmpty())
    <div class="gaming-card p-8 text-center">
        <svg class="w-16 h-16 mx-auto mb-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p style="color:var(--text-secondary);font-size:14px;">Tidak ada tagihan yang perlu dibayar.</p>
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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tagihan as $i => $r)
                    <tr>
                        <td style="color:var(--text-muted);">{{ $i + 1 }}</td>
                        <td><span class="text-xs font-semibold" style="color:var(--text-secondary);">{{ $r['jenis_label'] }}</span></td>
                        <td style="color:var(--text-primary);font-weight:500;">{{ $r['detail'] }}</td>
                        <td style="color:var(--text-primary);">Rp {{ number_format($r['nominal'], 0, ',', '.') }}</td>
                        <td>
                            <button type="button" onclick="openBayar({{ $r['id'] }}, '{{ $r['jenis'] }}', '{{ $r['detail'] }}', {{ $r['nominal'] }})" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">Bayar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

{{-- Modal Bayar --}}
<div id="bayar-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Bayar Tagihan</h3>
            <button type="button" onclick="closeBayar()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5">
            <div style="margin-bottom:16px;padding:12px;border-radius:10px;background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <div id="bayar-detail" style="font-weight:600;font-size:14px;color:var(--text-primary);"></div>
                <div id="bayar-nominal" style="font-size:13px;color:var(--text-muted);margin-top:4px;"></div>
            </div>
            <form id="bayar-form" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jenis" id="bayar-jenis">
                <div class="field-group mb-4">
                    <label class="gaming-label">PIC <span class="field-req">*</span></label>
                    <input type="text" name="pic" required class="gaming-input" value="{{ auth()->user()->name }}" placeholder="Nama PIC">
                </div>
                <div class="field-group mb-4">
                    <label class="gaming-label">Jabatan <span class="field-req">*</span></label>
                    <select name="jabatan" required class="gaming-input">
                        <option value="">— Pilih Jabatan —</option>
                        @foreach($jabatanList as $j)
                        <option value="{{ $j }}">{{ $j }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field-group mb-4">
                    <label class="gaming-label">Tanggal Bayar <span class="field-req">*</span></label>
                    <input type="date" name="tanggal_bayar" required class="gaming-input" value="{{ date('Y-m-d') }}">
                </div>
                <div class="field-group mb-4">
                    <label class="gaming-label">Upload Bukti Bayar <span class="field-req">*</span></label>
                    <input type="file" name="bukti_bayar" accept="image/jpeg,image/png" required class="gaming-input" style="padding:8px;">
                    <p class="text-xs mt-1" style="color:var(--text-muted);">Format: JPEG/PNG, maks 2MB</p>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;">
                    <button type="button" onclick="closeBayar()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#10b981,#34d399);color:#fff;border:none;box-shadow:0 4px 15px rgba(16,185,129,0.3);cursor:pointer;">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.field-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.field-req { color: #f87171; }
.gaming-input { width: 100%; }
</style>
@endpush

@push('scripts')
<script>
function openBayar(id, jenis, detail, nominal) {
    document.getElementById('bayar-detail').textContent = detail;
    document.getElementById('bayar-nominal').textContent = 'Rp ' + Number(nominal).toLocaleString('id-ID');
    document.getElementById('bayar-jenis').value = jenis;
    document.getElementById('bayar-form').action = '{{ url('payment-approval/tagihan') }}/' + id + '/bayar';
    document.getElementById('bayar-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeBayar() {
    document.getElementById('bayar-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('bayar-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeBayar();
});
</script>
@endpush
