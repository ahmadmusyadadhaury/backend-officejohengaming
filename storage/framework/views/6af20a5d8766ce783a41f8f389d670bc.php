<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Aset TIM'); ?>
<?php $__env->startSection('page-title', 'Data Aset > Aset TIM'); ?>
<?php $__env->startSection('page-subtitle', 'Daftar aset tim dan divisi perusahaan'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(124,58,237,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3h14a2 2 0 012 2v4a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2zM3 13h18v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);"><?php echo e($stats['total']); ?></div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-primary);">Total Aset TIM</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);"></div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(16,185,129,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#34d399;"><?php echo e($stats['aktif']); ?></div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Aset Aktif</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);"></div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(239,68,68,0.15);">
                <svg class="w-[18px] h-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;"><?php echo e($stats['nonaktif']); ?></div>
                <div class="text-[11px] font-medium mt-0.5" style="color:var(--text-secondary);">Aset Tidak Aktif</div>
                <div class="text-[11px] mt-0.5 leading-tight" style="color:var(--text-muted);"></div>
            </div>
        </div>
    </div>

    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Data Aset TIM</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Aset per tim/divisi perusahaan.</div>
            </div>
            <?php if(auth()->user()->role !== 'gm'): ?>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aset TIM
            </button>
            <?php endif; ?>
        </div>
        <?php if($allTim->count() > 0): ?>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-2" style="border-bottom:1px solid var(--border-color);">
            <a href="<?php echo e(route('admin.aset-tim.index')); ?>" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold transition" style="background:<?php echo e(!$activeTim ? 'var(--color-accent)' : 'var(--bg-surface-2)'); ?>;color:<?php echo e(!$activeTim ? '#fff' : 'var(--text-secondary)'); ?>;border:1px solid <?php echo e(!$activeTim ? 'var(--color-accent)' : 'var(--border-color)'); ?>;text-decoration:none;">Semua</a>
            <?php $__currentLoopData = $allTim; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('admin.aset-tim.index', ['tim' => $t])); ?>" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold transition" style="background:<?php echo e($activeTim === $t ? 'var(--color-accent)' : 'var(--bg-surface-2)'); ?>;color:<?php echo e($activeTim === $t ? '#fff' : 'var(--text-secondary)'); ?>;border:1px solid <?php echo e($activeTim === $t ? 'var(--color-accent)' : 'var(--border-color)'); ?>;text-decoration:none;"><?php echo e($t); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
        <div class="px-6 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-aset" placeholder="Cari..." oninput="filterTable()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[700px]" id="aset-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Tim</th>
                        <th>Jumlah</th>
                        <th>Penanggung Jawab</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <?php if(auth()->user()->role !== 'gm'): ?><th>Aksi</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody id="aset-tbody">
                    <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-muted);"><?php echo e($loop->iteration); ?></td>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($a->nama_aset); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($a->tim ?? '-'); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($a->jumlah); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($a->penanggungJawab?->name ?? '-'); ?></td>
                        <td><span class="badge <?php echo e($a->is_active ? 'badge-green' : 'badge-red'); ?>"><?php echo e($a->is_active ? 'Aktif' : 'Tidak Aktif'); ?></span></td>
                        <td style="max-width:150px;color:var(--text-muted);"><?php echo e($a->keterangan ?? '-'); ?></td>
                        <?php if(auth()->user()->role !== 'gm'): ?><td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail(<?php echo e($a->id); ?>)" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, <?php echo e($a->id); ?>)" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-<?php echo e($a->id); ?>" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail(<?php echo e($a->id); ?>)" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal(<?php echo e($a->id); ?>)" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="<?php echo e(route('admin.aset-tim.destroy', $a)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus aset tim ini?" style="margin:0;">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <input type="hidden" name="tim" value="<?php echo e($activeTim ?? ''); ?>">
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:6px 10px;border:none;background:none;font-size:12px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td><?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data aset tim.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="detail-modal" class="modal-modern" onclick="if(event.target===this)closeDetail()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="detail-title">Detail Aset TIM</h3>
            <button type="button" onclick="closeDetail()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body" id="detail-body"></div>
        <div class="modal-modern-footer">
            <button type="button" onclick="closeDetail()" class="btn btn-secondary">Tutup</button>
        </div>
    </div>
</div>


<div id="aset-modal" class="modal-modern" onclick="if(event.target===this)closeModal('aset-modal')">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3 id="modal-title">Tambah Aset TIM</h3>
            <button type="button" onclick="closeModal('aset-modal')" class="modal-modern-close">&times;</button>
        </div>
        <form id="aset-form" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" id="form-method" value="POST">
            <input type="hidden" name="id" id="form-id" value="">
            <input type="hidden" name="tim" id="form-tim-preserve" value="<?php echo e($activeTim ?? ''); ?>">
            <div class="modal-modern-body">
                <div class="form-grid-2">
                    <div class="field-group">
                        <label class="gaming-label">Nama Aset <span class="field-req">*</span></label>
                        <input type="text" name="nama_aset" id="f-nama_aset" required placeholder="Masukan nama aset" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Tim</label>
                        <input type="text" name="tim" id="f-tim" placeholder="Nama tim/divisi" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jumlah</label>
                        <input type="number" name="jumlah" id="f-jumlah" value="1" min="1" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Penanggung Jawab</label>
                        <select name="penanggung_jawab" id="f-penanggung_jawab" class="gaming-input gaming-select">
                            <option value="">— Pilih Koordinator —</option>
                            <?php $__currentLoopData = \App\Models\User::where('role', 'koordinator')->orWhere('role', 'admin_ga')->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($u->id); ?>"><?php echo e($u->name); ?> (<?php echo e($u->username); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">PIC</label>
                        <input type="text" name="pic" id="f-pic" placeholder="Nama PIC" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jabatan</label>
                        <input type="text" name="jabatan" id="f-jabatan" placeholder="Jabatan PIC" class="gaming-input">
                    </div>
                    <div class="field-group" style="grid-column:1/-1;">
                        <label class="gaming-label">Keterangan</label>
                        <textarea name="keterangan" id="f-keterangan" placeholder="Keterangan" rows="2" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                </div>

            <div class="modal-modern-footer gap-2">
                <button type="button" onclick="closeModal('aset-modal')" class="btn btn-secondary">Batal</button>
                <button type="submit" class="btn btn-primary" id="form-submit-btn">Tambah</button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
.form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 24px; margin-bottom: 16px; }
@media (max-width: 640px) { .form-grid-2 { grid-template-columns: 1fr; } }
.field-group { display: flex; flex-direction: column; gap: 6px; }
.field-req { color: #f87171; }
.form-footer { display: flex; justify-content: flex-end; gap: 10px; padding-top: 16px; margin-top: 8px; border-top: 1px solid var(--border-color); }
.btn-form { padding: 8px 22px; border-radius: 10px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.btn-form-batal { color: var(--text-primary); border: 1px solid var(--border-color); background: var(--bg-surface); }
.btn-form-simpan { background: linear-gradient(135deg,#6c5cff,#8b7bff); color: #fff; border: none; box-shadow: 0 4px 15px rgba(108,92,255,0.3); }
.btn-form-simpan:hover { transform: translateY(-1px); }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
const assets = <?php echo json_encode($assetsJson, 15, 512) ?>;

const activeTim = <?php echo json_encode($activeTim, 15, 512) ?>;

function getTimParam() {
    return activeTim ? '?tim=' + encodeURIComponent(activeTim) : '';
}

function filterTable() {
    const q = (document.getElementById('search-aset')?.value || '').toLowerCase();
    document.querySelectorAll('#aset-tbody tr').forEach(row => {
        row.style.display = !q || row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
}

function toggleDropdown(btn, id) {
    const menu = document.getElementById('dropdown-' + id);
    document.querySelectorAll('.dropdown-menu').forEach(m => { if (m.id !== 'dropdown-' + id) m.style.display = 'none'; });
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(m => m.style.display = 'none');
    }
});

function closeModal(id) { document.getElementById(id).style.display = 'none'; document.body.style.overflow = ''; }
document.querySelectorAll('[id$="-modal"]').forEach(m => {
    m.addEventListener('click', function(e) { if (e.target === this) { this.style.display = 'none'; document.body.style.overflow = ''; } });
});

function showDetail(id) {
    const a = assets.find(x => x.id === id);
    if (!a) return;
    document.getElementById('detail-title').textContent = 'Detail Aset TIM';
    document.getElementById('detail-body').innerHTML = `
        <div class="detail-grid">
            <div class="detail-item"><span class="detail-label">Nama Aset</span><span class="detail-value">${a.nama_aset}</span></div>
            <div class="detail-item"><span class="detail-label">Tim</span><span class="detail-value">${a.tim || '-'}</span></div>
            <div class="detail-item"><span class="detail-label">Jumlah</span><span class="detail-value">${a.jumlah}</span></div>
            <div class="detail-item"><span class="detail-label">Penanggung Jawab</span><span class="detail-value">${a.penanggung_jawab_nama}</span></div>
            <div class="detail-item"><span class="detail-label">PIC</span><span class="detail-value">${a.pic || '-'}</span></div>
            <div class="detail-item"><span class="detail-label">Jabatan</span><span class="detail-value">${a.jabatan || '-'}</span></div>
            <div class="detail-item"><span class="detail-label">Status</span><span class="detail-value">${a.is_active ? 'Aktif' : 'Tidak Aktif'}</span></div>
            <div class="detail-item" style="grid-column:1/-1;"><span class="detail-label">Keterangan</span><span class="detail-value">${a.keterangan || '-'}</span></div>
        </div>`;
    document.getElementById('detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeDetail() { document.getElementById('detail-modal').style.display = 'none'; document.body.style.overflow = ''; }

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Aset TIM';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('form-submit-btn').textContent = 'Tambah';
    document.getElementById('aset-form').action = '<?php echo e(route("admin.aset-tim.index")); ?>' + getTimParam();
    document.getElementById('f-nama_aset').value = '';
    document.getElementById('f-tim').value = '';
    document.getElementById('f-jumlah').value = '1';
    document.getElementById('f-penanggung_jawab').value = '';
    document.getElementById('f-pic').value = '';
    document.getElementById('f-jabatan').value = '';
    document.getElementById('f-keterangan').value = '';
    document.getElementById('aset-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function openEditModal(id) {
    const a = assets.find(x => x.id === id);
    if (!a) return;
    document.getElementById('modal-title').textContent = 'Edit Aset TIM';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = a.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan';
    document.getElementById('aset-form').action = '<?php echo e(url("admin/aset-tim")); ?>/' + a.id + getTimParam();
    document.getElementById('f-nama_aset').value = a.nama_aset;
    document.getElementById('f-tim').value = a.tim || '';
    document.getElementById('f-jumlah').value = a.jumlah || '1';
    document.getElementById('f-penanggung_jawab').value = a.penanggung_jawab || '';
    document.getElementById('f-pic').value = a.pic || '';
    document.getElementById('f-jabatan').value = a.jabatan || '';
    document.getElementById('f-keterangan').value = a.keterangan || '';
    document.getElementById('aset-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views/admin/aset-tim/index.blade.php ENDPATH**/ ?>