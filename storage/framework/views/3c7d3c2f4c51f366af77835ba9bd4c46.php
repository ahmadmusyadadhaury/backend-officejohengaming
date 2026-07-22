<?php $__env->startSection('body-class', 'page-leader'); ?>
<?php $__env->startSection('title', 'Aset TIM Saya'); ?>
<?php $__env->startSection('page-title', 'Operasional > Aset TIM'); ?>
<?php $__env->startSection('page-subtitle', 'Daftar aset tim yang menjadi tanggung jawab saya'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-4 animate-fade-in">

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        <?php
            $atStatCards = [
                ['label' => 'Total Aset', 'count' => $assets->count(), 'color' => '#a78bfa', 'bg' => 'rgba(124,58,237,0.12)', 'icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z'],
                ['label' => 'Aktif', 'count' => $assets->where('is_active', true)->count(), 'color' => '#34d399', 'bg' => 'rgba(16,185,129,0.12)', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Tidak Aktif', 'count' => $assets->where('is_active', false)->count(), 'color' => '#f87171', 'bg' => 'rgba(239,68,68,0.12)', 'icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ];
        ?>
        <?php $__currentLoopData = $atStatCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="stat-card-compact">
            <div class="stat-icon-box" style="background:<?php echo e($card['bg']); ?>;">
                <svg style="color:<?php echo e($card['color']); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($card['icon']); ?>"/>
                </svg>
            </div>
            <div>
                <div class="stat-num" style="color:<?php echo e($card['color']); ?>;"><?php echo e($card['count']); ?></div>
                <div class="stat-label-text"><?php echo e($card['label']); ?></div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Aset TIM</div>
                <div style="font-size:0.7rem;margin-top:2px;color:var(--text-muted);">Daftar aset tim yang menjadi tanggung jawab anda.</div>
            </div>
            <button type="button" onclick="openAddModal()" class="btn btn-primary btn-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Aset TIM
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[800px]">
                <colgroup>
                    <col style="width:44px">
                    <col>
                    <col style="width:100px">
                    <col style="width:140px">
                    <col style="width:100px">
                    <col style="width:150px">
                </colgroup>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Aset</th>
                        <th>Jenis Aset</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-muted);"><?php echo e($loop->iteration); ?></td>
                        <td><span class="font-medium" style="color:var(--text-primary);"><?php echo e($a->nama_aset); ?></span></td>
                        <td><span class="badge badge-cyan">Aset TIM</span></td>
                        <td><span style="color:var(--text-secondary);"><?php echo e($a->keterangan ? Str::limit($a->keterangan, 40) : '-'); ?></span></td>
                        <td><span style="color:var(--text-secondary);"><?php echo e($a->jumlah); ?></span></td>
                        <td>
                            <div class="flex items-center gap-1">
                                <button onclick='openDetailModal(<?php echo json_encode($a, 15, 512) ?>)' class="btn btn-secondary btn-sm">Detail</button>
                                <button onclick='openEditModal(<?php echo json_encode($a, 15, 512) ?>)' class="btn btn-secondary btn-sm">Edit</button>
                                <form method="POST" action="<?php echo e(route('koordinator.aset-tim.destroy', $a)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus aset ini?">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" style="text-align:center;padding:2.5rem;color:var(--text-muted);font-size:0.9rem;">
                            <div class="flex flex-col items-center gap-2">
                                <svg class="w-10 h-10" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span>Belum ada aset tim yang ditugaskan.</span>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div id="addModal" class="modal-modern" onclick="if(event.target===this)closeAddModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Aset TIM</h3>
            <button onclick="closeAddModal()" class="modal-modern-close">&times;</button>
        </div>
        <form method="POST" action="<?php echo e(route('koordinator.aset-tim.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-modern-body">
                <div class="space-y-4">
                    <div>
                        <label class="gaming-label">Nama Aset <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="nama_aset" required class="gaming-input" placeholder="Nama aset">
                    </div>
                    <div>
                        <label class="gaming-label">Tim</label>
                        <input type="text" name="tim" class="gaming-input" placeholder="Nama tim">
                    </div>
                    <div>
                        <label class="gaming-label">Keterangan</label>
                        <textarea name="keterangan" class="gaming-input" rows="2" placeholder="Opsional"></textarea>
                    </div>
                    <div>
                        <label class="gaming-label">Jumlah</label>
                        <input type="number" name="jumlah" min="1" class="gaming-input" placeholder="1">
                    </div>
                </div>
            </div>
            <div class="modal-modern-footer">
                <button type="button" onclick="closeAddModal()" class="btn btn-secondary btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>


<div id="editModal" class="modal-modern" onclick="if(event.target===this)closeEditModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Aset TIM</h3>
            <button onclick="closeEditModal()" class="modal-modern-close">&times;</button>
        </div>
        <form method="POST" id="editForm">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="modal-modern-body">
                <div class="space-y-4">
                    <div>
                        <label class="gaming-label">Nama Aset <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="nama_aset" id="edit_nama_aset" required class="gaming-input">
                    </div>
                    <div>
                        <label class="gaming-label">Tim</label>
                        <input type="text" name="tim" id="edit_tim" class="gaming-input">
                    </div>
                    <div>
                        <label class="gaming-label">Keterangan</label>
                        <textarea name="keterangan" id="edit_keterangan" class="gaming-input" rows="2"></textarea>
                    </div>
                    <div>
                        <label class="gaming-label">Jumlah</label>
                        <input type="number" name="jumlah" id="edit_jumlah" min="1" class="gaming-input">
                    </div>
                    <div>
                        <label class="gaming-label">Status</label>
                        <select name="is_active" id="edit_is_active" class="gaming-input gaming-select">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-modern-footer">
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>


<div id="detailModal" class="modal-modern" onclick="if(event.target===this)closeDetailModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Detail Aset TIM</h3>
            <button onclick="closeDetailModal()" class="modal-modern-close">&times;</button>
        </div>
        <div class="modal-modern-body">
            <div class="space-y-3">
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Nama Aset</span>
                    <span class="text-xs font-medium" id="detail_nama_aset" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Jenis Aset</span>
                    <span class="badge badge-cyan" style="font-size:0.65rem;">Aset TIM</span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Tim</span>
                    <span class="text-xs" id="detail_tim" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Keterangan</span>
                    <span class="text-xs" id="detail_keterangan" style="color:var(--text-primary);text-align:right;max-width:60%;"></span>
                </div>
                <div class="flex justify-between py-2" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-xs" style="color:var(--text-muted);">Jumlah</span>
                    <span class="text-xs font-medium" id="detail_jumlah" style="color:var(--text-primary);"></span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-xs" style="color:var(--text-muted);">Status</span>
                    <span id="detail_status"></span>
                </div>
            </div>
        </div>
        <div class="modal-modern-footer">
            <button type="button" onclick="closeDetailModal()" class="btn btn-secondary btn-sm">Tutup</button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function openAddModal() {
    openModal('addModal');
}

function closeAddModal() {
    closeModal('addModal');
}

function openEditModal(asset) {
    document.getElementById('editForm').action = '<?php echo e(route("koordinator.aset-tim.update", ["asetTim" => "___ID___"])); ?>'.replace('___ID___', asset.id);
    document.getElementById('edit_nama_aset').value = asset.nama_aset;
    document.getElementById('edit_tim').value = asset.tim || '';
    document.getElementById('edit_keterangan').value = asset.keterangan || '';
    document.getElementById('edit_jumlah').value = asset.jumlah || '';
    document.getElementById('edit_is_active').value = asset.is_active ? '1' : '0';
    openModal('editModal');
}

function closeEditModal() {
    closeModal('editModal');
}

function openDetailModal(asset) {
    document.getElementById('detail_nama_aset').textContent = asset.nama_aset;
    document.getElementById('detail_tim').textContent = asset.tim || '-';
    document.getElementById('detail_keterangan').textContent = asset.keterangan || '-';
    document.getElementById('detail_jumlah').textContent = asset.jumlah || '-';
    var statusEl = document.getElementById('detail_status');
    if (asset.is_active) {
        statusEl.innerHTML = '<span class="badge badge-green" style="font-size:0.65rem;">Aktif</span>';
    } else {
        statusEl.innerHTML = '<span class="badge badge-red" style="font-size:0.65rem;">Tidak Aktif</span>';
    }
    openModal('detailModal');
}

function closeDetailModal() {
    closeModal('detailModal');
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views/leader/aset-tim/index.blade.php ENDPATH**/ ?>