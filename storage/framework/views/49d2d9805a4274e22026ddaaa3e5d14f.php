<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Sosial Media'); ?>
<?php $__env->startSection('page-title', 'Data Aset > Sosial Media'); ?>
<?php $__env->startSection('page-subtitle', 'Seluruh akun sosial media operasional perusahaan'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>

<?php
$badgeVariants = ['badge-primary', 'badge-blue', 'badge-green', 'badge-yellow', 'badge-cyan', 'badge-orange'];
?>

<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-5 animate-fade-in">

    
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);"><?php echo e($stats['total']); ?></div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-primary);">Total Akun</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#34d399;"><?php echo e($stats['aktif']); ?></div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Akun Aktif</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;"><?php echo e($stats['nonaktif']); ?></div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Akun Tidak Aktif</div>
            </div>
        </div>
    </div>

    
    <div class="gaming-card" style="overflow:hidden;">
        <div class="card-header">
            <div class="card-header-title">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                Data Sosial Media
            </div>
            <?php if(auth()->user()->role !== 'gm'): ?>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Sosial Media
            </button>
            <?php endif; ?>
        </div>

        
        <div class="filter-bar">
            <div class="search-wrap">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-sosmed" placeholder="Cari username, nama, atau platform" oninput="filterSosmed()"
                    class="gaming-input" style="padding-left:2rem;">
            </div>
            <div class="filter-dropdown-wrap" style="position:relative;margin-left:auto;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card, var(--bg-surface));color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Platform</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Platform</button>
                    <?php
                        $uniquePlatforms = $items->pluck('platform')->unique()->sort();
                    ?>
                    <?php $__currentLoopData = $uniquePlatforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button type="button" data-value="<?php echo e($platform); ?>" onclick="setFilter('<?php echo e($platform); ?>')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'"><?php echo e($platform); ?></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>

        
        <div class="table-responsive">
            <table class="gaming-table min-w-[900px]" id="sosmed-table">
                <thead>
                    <tr>
                        <th style="width:48px;">No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th style="width:100px;">Followers</th>
                        <th style="width:120px;">Platform</th>
                        <th style="width:90px;">Status</th>
                        <th class="hidden md:table-cell">Divisi</th>
                        <th class="hidden lg:table-cell">PIC</th>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <th style="width:130px;">Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="sosmed-tbody">
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $bClass = $badgeVariants[$loop->index % count($badgeVariants)]; ?>
                    <tr data-platform="<?php echo e($i->platform); ?>">
                        <td style="color:var(--text-muted);"><?php echo e($loop->iteration); ?></td>
                        <td><span style="color:var(--text-primary);font-weight:600;"><?php echo e($i->username); ?></span></td>
                        <td style="color:var(--text-muted);"><?php echo e($i->nama); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($i->followers ?? '—'); ?></td>
                        <td><span class="badge <?php echo e($bClass); ?>"><?php echo e($i->platform); ?></span></td>
                        <td><span class="badge <?php echo e($i->status === 'aktif' ? 'badge-green' : 'badge-red'); ?>"><?php echo e($i->status === 'aktif' ? 'Aktif' : 'Nonaktif'); ?></span></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e($i->divisi); ?></td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);"><?php echo e($i->pic); ?></td>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <div class="flex items-center gap-1.5">
                                <button type="button" onclick="showDetail(<?php echo e($i->id); ?>)" class="btn btn-secondary btn-sm" title="Lihat Detail" style="padding:4px 8px;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span class="hidden sm:inline">Detail</span>
                                </button>
                                <button type="button" onclick="openEditModal(<?php echo e($i->id); ?>)" class="btn btn-secondary btn-sm" title="Edit" style="padding:4px 8px;">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <span class="hidden sm:inline">Edit</span>
                                </button>
                                <form method="POST" action="<?php echo e(route('admin.sosial-media.destroy', $i)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun <?php echo e($i->username); ?>?" style="margin:0;display:inline-flex;">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus" style="padding:4px 8px;">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr id="empty-row">
                        <td colspan="8" style="text-align:center;padding:2.5rem 1rem;color:var(--text-muted);">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-8 h-8" style="opacity:0.35;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                </svg>
                                <span>Belum ada data Sosial Media.</span>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>


<div id="detail-modal" class="modal-modern">
    <div class="modal-modern-panel sm" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="detail-title">Detail Sosial Media</h3>
            <button type="button" onclick="closeDetail()" class="modal-modern-close">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-modern-body" id="detail-body"></div>
        <div class="modal-modern-footer">
            <button type="button" onclick="closeDetail()" class="btn btn-secondary btn-sm">Tutup</button>
        </div>
    </div>
</div>


<div id="sosmed-modal" class="modal-modern">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="modal-title">Tambah Sosial Media</h3>
            <button type="button" onclick="closeModal('sosmed-modal')" class="modal-modern-close">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="modal-modern-body">
            <form id="sosmed-form" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="form-id" value="">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-4">
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">Username <span class="field-req">*</span></label>
                        <input type="text" name="username" id="f-username" required placeholder="Masukan username" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">Nama <span class="field-req">*</span></label>
                        <input type="text" name="nama" id="f-nama" required placeholder="Masukan nama akun" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">Followers</label>
                        <input type="text" name="followers" id="f-followers" placeholder="Masukan jumlah followers" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">Platform <span class="field-req">*</span></label>
                        <input type="text" name="platform" id="f-platform" required placeholder="Contoh: Instagram, TikTok" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">Divisi <span class="field-req">*</span></label>
                        <input type="text" name="divisi" id="f-divisi" required placeholder="Masukan divisi" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">PIC <span class="field-req">*</span></label>
                        <input type="text" name="pic" id="f-pic" required placeholder="Masukan nama PIC" class="gaming-input">
                    </div>
                    <div class="flex flex-col gap-1.5">
                        <label class="gaming-label">Status</label>
                        <select name="status" id="f-status" class="gaming-input">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1.5 sm:col-span-2">
                        <label class="gaming-label">Keterangan</label>
                        <textarea name="ket" id="f-ket" placeholder="Masukan keterangan" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-modern-footer">
            <button type="button" onclick="closeModal('sosmed-modal')" class="btn btn-secondary">Batal</button>
            <button type="submit" class="btn btn-primary" id="form-submit-btn" form="sosmed-form">Simpan</button>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.field-req { color: #f87171; }

.modal-modern-body .gaming-input {
    padding: 0.55rem 0.75rem;
    font-size: 0.8rem;
}
.modal-modern-body .gaming-label {
    margin-bottom: 0;
    font-size: 0.65rem;
}

.stat-card-compact .stat-label-text {
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--text-secondary);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const sosmedData = <?php echo json_encode($itemsJson, 15, 512) ?>;

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Sosial Media';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('sosmed-form').action = '<?php echo e(route('admin.sosial-media.store')); ?>';
    document.getElementById('form-submit-btn').textContent = 'Simpan';
    document.getElementById('sosmed-form').querySelectorAll('input, textarea, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method') {
            el.value = '';
        }
    });
    openModal('sosmed-modal');
}

function showDetail(id) {
    const i = sosmedData.find(item => item.id === id);
    if (!i) return;
    document.getElementById('detail-title').textContent = i.username;

    const rows = [
        { label: 'Username', value: i.username },
        { label: 'Nama', value: i.nama },
        { label: 'Followers', value: i.followers || '-' },
        { label: 'Platform', value: i.platform },
        { label: 'Divisi', value: i.divisi },
        { label: 'PIC', value: i.pic },
        { label: 'Status', value: i.status === 'aktif' ? 'Aktif' : 'Tidak Aktif' },
        { label: 'Keterangan', value: i.ket || '-' },
    ];

    document.getElementById('detail-body').innerHTML = `
        <div class="space-y-0">
            ${rows.map((r, idx) => `
                <div class="flex items-center justify-between py-2.5 ${idx < rows.length - 1 ? 'border-b' : ''}" style="${idx < rows.length - 1 ? 'border-bottom:1px solid var(--border-color);' : ''}">
                    <span class="text-xs font-medium uppercase tracking-wider" style="color:var(--text-muted);">${r.label}</span>
                    <span class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</span>
                </div>
            `).join('')}
        </div>
    `;
    openModal('detail-modal');
}

function closeDetail() {
    closeModal('detail-modal');
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

function openEditModal(id) {
    closeDetail();
    const i = sosmedData.find(item => item.id === id);
    if (!i) return;

    document.getElementById('modal-title').textContent = 'Edit Sosial Media';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = i.id;
    document.getElementById('sosmed-form').action = '<?php echo e(url('admin/sosial-media')); ?>/' + i.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan Perubahan';

    document.getElementById('f-username').value = i.username;
    document.getElementById('f-nama').value = i.nama;
    document.getElementById('f-followers').value = i.followers || '';
    document.getElementById('f-platform').value = i.platform;
    document.getElementById('f-divisi').value = i.divisi;
    document.getElementById('f-pic').value = i.pic;
    document.getElementById('f-status').value = i.status;
    document.getElementById('f-ket').value = i.ket || '';

    openModal('sosmed-modal');
}

document.getElementById('sosmed-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal('sosmed-modal');
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeDetail(); closeModal('sosmed-modal'); }
});

let currentFilter = 'all';

function toggleFilterMenu(e) {
    e.stopPropagation();
    const menu = document.getElementById('filter-menu');
    const btn = e.currentTarget;
    document.querySelectorAll('.filter-menu').forEach(m => { if (m.id !== 'filter-menu') m.style.display = 'none'; });
    if (menu.style.display === 'none' || !menu.style.display) {
        const rect = btn.getBoundingClientRect();
        menu.style.position = 'fixed';
        menu.style.top = (rect.bottom + 4) + 'px';
        menu.style.right = (window.innerWidth - rect.right) + 'px';
        menu.style.left = 'auto';
        menu.style.bottom = 'auto';
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
    filterSosmed();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

function filterSosmed() {
    const search = (document.getElementById('search-sosmed')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#sosmed-tbody tr:not(#empty-row)');
    rows.forEach(row => {
        const rowPlatform = row.dataset.platform;
        const text = row.textContent.toLowerCase();
        const matchStatus = currentFilter === 'all' || rowPlatform === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchStatus && matchSearch ? '' : 'none';
    });
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\sosial-media\index.blade.php ENDPATH**/ ?>