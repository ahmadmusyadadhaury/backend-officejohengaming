<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Persetujuan Pembayaran'); ?>
<?php $__env->startSection('page-title', 'Persetujuan Pembayaran'); ?>
<?php $__env->startSection('page-subtitle', 'Pengajuan pembayaran yang menunggu persetujuan'); ?>

<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-4 animate-fade-in">
    <?php if($requests->isEmpty()): ?>
    <div class="gaming-card p-8 text-center">
        <svg class="w-16 h-16 mx-auto mb-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p style="color:var(--text-secondary);font-size:14px;">Tidak ada pengajuan yang menunggu persetujuan.</p>
    </div>
    <?php else: ?>
    <div class="gaming-card" style="overflow:hidden;">
        <div class="card-header">
            <div>
                <div class="card-header-title">Persetujuan Pembayaran</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Pengajuan pembayaran yang menunggu persetujuan</div>
            </div>
        </div>
        <div class="filter-bar">
            <div class="search-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-approval" placeholder="Cari..." oninput="filterTable()"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <a href="<?php echo e(route('admin.payment-approvals.export')); ?>" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>Export</a>
                <?php if(auth()->user()->role === 'admin'): ?>
                <button type="button" onclick="confirmResetData()" class="btn btn-sm inline-flex items-center gap-1.5" style="color:#ef4444;border:1px solid rgba(239,68,68,0.3);background:rgba(239,68,68,0.08);">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Reset Data
                </button>
                <form id="reset-data-form" method="POST" action="<?php echo e(route('admin.payment-approvals.reset')); ?>" style="display:none;"><?php echo csrf_field(); ?></form>
                <?php endif; ?>
                <div class="filter-dropdown-wrap" style="position:relative;">
                    <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                        style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                        <span id="filter-label">Semua Jenis</span>
                        <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="filter-menu" class="filter-menu" style="display:none;position:fixed;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);">
                        <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Jenis</button>
                        <button type="button" data-value="internet" onclick="setFilter('internet')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Internet</button>
                        <button type="button" data-value="listrik" onclick="setFilter('listrik')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Listrik</button>
                        <button type="button" data-value="aset_digital" onclick="setFilter('aset_digital')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aset Digital</button>
                        <button type="button" data-value="ipl_ruko" onclick="setFilter('ipl_ruko')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">IPL Ruko</button>
                        <button type="button" data-value="pajak_kendaraan" onclick="setFilter('pajak_kendaraan')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Pajak Kendaraan</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table" style="width:100%;min-width:900px;">
                <colgroup>
                    <col style="width:40px">
                    <col style="width:80px">
                    <col style="width:100px">
                    <col style="width:70px">
                    <col style="width:260px">
                    <col style="width:110px">
                    <col style="width:75px">
                    <col style="width:50px">
                    <col style="width:115px">
                </colgroup>
                <thead>
                    <tr>
                        <th style="width:40px">No</th>
                        <th style="width:80px">Tanggal</th>
                        <th style="width:100px">Pengaju</th>
                        <th style="width:70px">Jenis</th>
                        <th style="width:260px">Detail</th>
                        <th style="width:110px">Nominal</th>
                        <th style="width:75px">Tgl Bayar</th>
                        <th style="width:50px">Bukti</th>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <th style="width:115px">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="approval-tbody">
                    <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data-jenis="<?php echo e($r['jenis']); ?>">
                        <td style="color:var(--text-muted);"><?php echo e($i + 1); ?></td>
                        <td style="font-size:12px;color:var(--text-secondary);"><?php echo e($r['created_at']); ?></td>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($r['requester_name']); ?></td>
                        <td><span class="text-xs font-semibold" style="color:var(--text-secondary);"><?php echo e($r['jenis_label']); ?></span></td>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($r['detail']); ?></td>
                        <td style="color:var(--text-primary);white-space:nowrap;">Rp <?php echo e(number_format($r['nominal'], 0, ',', '.')); ?></td>
                        <td style="font-size:13px;color:var(--text-secondary);"><?php echo e($r['tanggal_bayar']); ?></td>
                        <td>
                            <?php if($r['bukti_url']): ?>
                            <a href="<?php echo e($r['bukti_url']); ?>" target="_blank" class="btn btn-secondary btn-sm" style="padding:4px 10px;font-size:11px;">Lihat</a>
                            <?php else: ?>
                            <span class="text-xs" style="color:var(--text-muted);">-</span>
                            <?php endif; ?>
                        </td>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <?php if($isApprover): ?>
                            <div class="flex gap-2">
                                <button type="button" onclick="approve(<?php echo e($r['id']); ?>, '<?php echo e($r['jenis']); ?>')" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:#10b981;color:#fff;border:none;cursor:pointer;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">Setujui</button>
                                <button type="button" onclick="openReject(<?php echo e($r['id']); ?>, '<?php echo e($r['jenis']); ?>')" class="px-4 py-1.5 rounded-lg text-xs font-semibold transition" style="background:#ef4444;color:#fff;border:none;cursor:pointer;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">Tolak</button>
                            </div>
                            <?php else: ?>
                            <span class="text-xs" style="color:var(--text-muted);">-</span>
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>


<div id="approve-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[380px] rounded-2xl shadow-2xl flex flex-col p-6" style="background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex flex-col items-center text-center mb-5">
            <div class="w-12 h-12 rounded-full flex items-center justify-center mb-3" style="background:rgba(16,185,129,0.15);">
                <svg class="w-6 h-6" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-base font-semibold" style="color:var(--text-primary);">Setujui Pembayaran</p>
            <p class="text-sm mt-1" style="color:var(--text-muted);">Yakin ingin menyetujui pembayaran ini?</p>
        </div>
        <div class="flex gap-3">
            <button type="button" onclick="closeApprove()" class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold transition" style="background:var(--bg-surface-2);color:var(--text-primary);border:none;cursor:pointer;" onmouseover="this.style.background='var(--border-color)'" onmouseout="this.style.background='var(--bg-surface-2)'">Batal</button>
            <button type="button" onclick="executeApprove()" class="flex-1 px-4 py-2.5 rounded-xl text-sm font-semibold transition" style="background:#10b981;color:#fff;border:none;cursor:pointer;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">Ya, Setujui</button>
        </div>
    </div>
</div>


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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
let currentFilter = 'all';
let approveId = null;
let approveJenis = null;
let rejectId = null;
let rejectJenis = null;

function toggleFilterMenu(e) {
    e.stopPropagation();
    const menu = document.getElementById('filter-menu');
    document.querySelectorAll('.filter-menu').forEach(m => { if (m.id !== 'filter-menu') m.style.display = 'none'; });
    if (menu.style.display !== 'block') {
        const btn = e.currentTarget;
        const rect = btn.getBoundingClientRect();
        menu.style.position = 'fixed';
        menu.style.top = (rect.bottom + 4) + 'px';
        menu.style.right = (window.innerWidth - rect.right) + 'px';
        menu.style.display = 'block';
    } else {
        menu.style.display = 'none';
    }
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

function filterTable() {
    const search = (document.getElementById('search-approval')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#approval-tbody tr');
    rows.forEach(row => {
        const rowJenis = row.dataset.jenis;
        const text = row.textContent.toLowerCase();
        const matchFilter = currentFilter === 'all' || rowJenis === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchFilter && matchSearch ? '' : 'none';
    });
}

function showToast(message, type) {
    const isSuccess = type === 'success';
    const bg = isSuccess ? '#10b981' : '#ef4444';
    const existing = document.querySelector('.payment-toast');
    if (existing) existing.remove();
    const toast = document.createElement('div');
    toast.className = 'payment-toast';
    toast.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;padding:14px 22px;border-radius:12px;font-size:14px;font-weight:500;color:#fff;background:' + bg + ';border:1px solid ' + (isSuccess ? 'rgba(16,185,129,0.4)' : 'rgba(239,68,68,0.4)') + ';box-shadow:0 8px 32px rgba(0,0,0,0.25);display:flex;align-items:center;gap:10px;transform:translateX(120%);transition:transform 0.35s cubic-bezier(0.34,1.56,0.64,1);max-width:400px;';
    toast.innerHTML = (isSuccess
        ? '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>'
        : '<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>')
        + '<span>' + message + '</span>';
    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.style.transform = 'translateX(0)');
    setTimeout(() => { toast.style.transform = 'translateX(120%)'; setTimeout(() => toast.remove(), 350); }, 4000);
}

function approve(id, jenis) {
    approveId = id;
    approveJenis = jenis;
    openModal('approve-modal');
}

function closeApprove() {
    approveId = null;
    approveJenis = null;
    closeModal('approve-modal');
}

function executeApprove() {
    const id = approveId;
    const jenis = approveJenis;
    closeApprove();

    const form = new FormData();
    form.append('_token', '<?php echo e(csrf_token()); ?>');
    form.append('jenis', jenis);

    fetch('<?php echo e(url('admin/payment-approvals')); ?>/' + id + '/approve', {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: form,
    }).then(r => {
        if (r.ok) {
            showSuccessModal('Pembayaran berhasil disetujui.');
            setTimeout(() => location.reload(), 1500);
        } else {
            r.json().then(e => {
                showToast(e.error || 'Gagal menyetujui pembayaran', 'error');
            });
        }
    }).catch(() => {
        location.reload();
    });
}

function openReject(id, jenis) {
    rejectId = id;
    rejectJenis = jenis;
    document.getElementById('reject-notes').value = '';
    openModal('reject-modal');
}

function closeReject() {
    rejectId = null;
    rejectJenis = null;
    closeModal('reject-modal');
}

function reject() {
    const notes = document.getElementById('reject-notes').value.trim();
    if (!notes) {
        showToast('Alasan penolakan harus diisi.', 'error');
        return;
    }

    const id = rejectId;
    const jenis = rejectJenis;
    closeReject();

    const form = new FormData();
    form.append('_token', '<?php echo e(csrf_token()); ?>');
    form.append('jenis', jenis);
    form.append('notes', notes);

    fetch('<?php echo e(url('admin/payment-approvals')); ?>/' + id + '/reject', {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: form,
    }).then(r => {
        if (r.ok) {
            showSuccessModal('Pembayaran berhasil ditolak.');
            setTimeout(() => location.reload(), 1500);
        } else {
            r.json().then(e => {
                showToast(e.error || 'Gagal menolak pembayaran', 'error');
            });
        }
    }).catch(() => {
        location.reload();
    });
}

document.getElementById('approve-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeApprove();
});
document.getElementById('reject-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeReject();
});

function confirmResetData() {
    showConfirmModal(
        'Reset semua data persetujuan ke status awal?',
        function() {
            document.getElementById('reset-data-form').submit();
        },
        { confirmText: 'Ya, Reset', confirmColor: '#ef4444' }
    );
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views/admin/payment-approvals/index.blade.php ENDPATH**/ ?>