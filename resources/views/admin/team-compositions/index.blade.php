@extends('layouts.app')
@section('body-class', 'page-admin')
@section('title', 'Komposisi Tim')
@section('page-title', 'Overview > Komposisi Tim')
@section('page-subtitle', 'Atur jumlah per posisi dalam organisasi')
@section('sidebar-menu') @include('partials.sidebar-admin') @endsection
@section('content')
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Komposisi Tim</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Atur jumlah per posisi dalam organisasi</div>
            </div>
        </div>

        <div class="px-6 py-5">
            {{-- Summary Cards --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-2.5 md:gap-3 mb-6">
                @php
                    $roleCards = [
                        ['key' => 'ceo', 'label' => 'CEO', 'color' => '#fbbf24', 'bg' => 'rgba(251,191,36,0.12)', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['key' => 'gm', 'label' => 'General Manager', 'color' => '#a78bfa', 'bg' => 'rgba(167,139,250,0.12)', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                        ['key' => 'head_of_store', 'label' => 'Head of Store', 'color' => '#34d399', 'bg' => 'rgba(52,211,153,0.12)', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['key' => 'hr', 'label' => 'HR', 'color' => '#fb923c', 'bg' => 'rgba(251,146,60,0.12)', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        ['key' => 'koordinator', 'label' => 'Koordinator', 'color' => '#38bdf8', 'bg' => 'rgba(56,189,248,0.12)', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                        ['key' => 'total_team', 'label' => 'Total Tim', 'color' => '#c084fc', 'bg' => 'rgba(192,132,252,0.12)', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['key' => 'karyawan', 'label' => 'Karyawan', 'color' => '#f87171', 'bg' => 'rgba(248,113,113,0.12)', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
                    ];
                @endphp
                @foreach($roleCards as $card)
                    @php $comp = $compositions->firstWhere('role', $card['key']); @endphp
                    <div class="stat-card-compact flex-col items-center text-center py-3" style="border-color:{{ $card['color'] }}20;">
                        <div class="stat-icon-box mb-1.5" style="background:{{ $card['bg'] }};box-shadow:0 0 12px {{ $card['color'] }}20;">
                            <svg class="w-4 h-4" style="color:{{ $card['color'] }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                            </svg>
                        </div>
                        <div class="stat-num" style="color:{{ $card['color'] }};">{{ $comp->max_count ?? 0 }}</div>
                        <div class="stat-label-text">{{ $card['label'] }}</div>
                    </div>
                @endforeach
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="gaming-table w-full">
                    <thead>
                        <tr>
                            <th style="width:8%;">No</th>
                            <th style="width:40%;">Posisi</th>
                            <th style="width:20%;">Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($compositions as $comp)
                        <tr>
                            <td style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                            <td style="color:var(--text-primary);font-weight:500;">{{ $comp->label }}</td>
                            <td>
                                <span class="badge badge-cyan">{{ $comp->max_count }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-1">
                                    <button type="button" onclick="showDetail({{ json_encode(['id'=>$comp->id,'label'=>$comp->label,'max_count'=>$comp->max_count]) }})" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat Detail
                                    </button>
                                    <div class="dropdown-wrap" style="position:relative;">
                                        <button type="button" onclick="toggleDropdown(this, {{ $comp->id }})" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                        <div id="dropdown-{{ $comp->id }}" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                            <button type="button" onclick="showDetail({{ json_encode(['id'=>$comp->id,'label'=>$comp->label,'max_count'=>$comp->max_count]) }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                            @if(auth()->user()->role !== 'gm' && auth()->user()->role !== 'ceo')
                                            <button type="button" onclick="openEditModal({{ json_encode(['id'=>$comp->id,'label'=>$comp->label,'max_count'=>$comp->max_count]) }})" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                            <form method="POST" action="{{ route('admin.team-compositions.destroy', $comp) }}" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus komposisi {{ $comp->label }} ini?" style="margin:0;">
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
                        <tr><td colspan="4" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data komposisi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Detail Modal --}}
<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[460px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="detail-title">Detail Komposisi Tim</h3>
            <button type="button" onclick="closeDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1" id="detail-body"></div>
        <div class="px-6 py-4 flex-shrink-0 flex justify-between items-center" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div id="edit-modal" class="modal-modern" onclick="if(event.target===this)closeEditModal()">
    <div class="modal-modern-panel sm" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Komposisi Tim</h3>
            <button type="button" onclick="closeEditModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-form" method="POST">
            @csrf @method('PUT')
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Posisi</label>
                    <input type="text" id="edit-label" disabled class="gaming-input" style="background:var(--bg-surface-2);opacity:0.8;">
                </div>
                <div>
                    <label class="gaming-label">Jumlah <span style="color:#f87171;">*</span></label>
                    <input type="number" name="max_count" id="edit-max-count" required min="0" class="gaming-input">
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleDropdown(btn, id) {
    document.querySelectorAll('.dropdown-menu').forEach(function(el) {
        if (el.id !== 'dropdown-' + id) el.style.display = 'none';
    });
    const menu = document.getElementById('dropdown-' + id);
    if (menu) menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(function(el) { el.style.display = 'none'; });
    }
});

function renderDetail(rows) {
    const html = rows.map(function(r, i) {
        const border = i < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : '';
        return `<div class="flex items-center justify-between py-2.5" ${border}>
            <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
            <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</p>
        </div>`;
    }).join('');
    document.getElementById('detail-body').innerHTML = '<div class="space-y-1">' + html + '</div>';
    openModal('detail-modal');
}

function showDetail(data) {
    document.getElementById('detail-title').textContent = 'Detail Komposisi Tim';
    renderDetail([
        { label: 'Posisi', value: data.label },
        { label: 'Jumlah', value: data.max_count },
    ]);
}

function closeDetail() { closeModal('detail-modal'); }
document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

function openEditModal(data) {
    document.getElementById('edit-form').action = '/admin/team-compositions/' + data.id;
    document.getElementById('edit-label').value = data.label;
    document.getElementById('edit-max-count').value = data.max_count;
    openModal('edit-modal');
}
function closeEditModal() { closeModal('edit-modal'); }
document.getElementById('edit-modal')?.addEventListener('click', function(e) { if (e.target === this) closeEditModal(); });

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDetail();
        closeEditModal();
    }
});
</script>
@push('styles')
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
@endpush
@endsection
