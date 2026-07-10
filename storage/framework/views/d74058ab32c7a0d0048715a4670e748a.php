<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Kelola Admin'); ?>
<?php $__env->startSection('page-title', 'Overview > Kelola Admin'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola admin dengan akses PENUH ke seluruh menu sistem.'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card" style="overflow:visible;">
        <form method="GET" action="<?php echo e(route('admin.admins.index')); ?>" id="filter-form">
        <input type="hidden" name="status" id="status-input" value="<?php echo e(request('status')); ?>">
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Kelola Admin</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Kelola admin dengan akses PENUH ke seluruh menu sistem.</div>
            </div>
<?php if(auth()->user()->role !== 'gm'): ?>
            <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Admin
            </button>
<?php endif; ?>
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-[200px] max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari..."
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="filter-dropdown-wrap" style="position:relative;margin-left:auto;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label"><?php echo e(request('status') === 'active' ? 'Aktif' : (request('status') === 'inactive' ? 'Nonaktif' : 'Semua Status')); ?></span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="" onclick="setFilter('')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <button type="button" data-value="active" onclick="setFilter('active')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" data-value="inactive" onclick="setFilter('inactive')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Nonaktif</button>
                </div>
            </div>
        </div>
        </form>
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[600px]">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Status</th>
<?php if(auth()->user()->role !== 'gm'): ?><th>Aksi</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-muted);"><?php echo e($admins->firstItem() + $loop->index); ?></td>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($admin->name); ?></td>
                        <td><code style="font-size:0.75rem;color:var(--color-neon-blue);background:rgba(0,212,255,0.08);padding:2px 6px;border-radius:4px;"><?php echo e($admin->username); ?></code></td>
                        <td>
                            <?php
                                $roleClass = match($admin->role) {
                                    'admin'         => 'badge-primary',
                                    'head_of_store' => 'badge-blue',
                                    'gm'            => 'badge-cyan',
                                    'ceo'           => 'badge-primary',
                                    'hr'            => 'badge-green',
                                    default         => 'badge-gray',
                                };
                            ?>
                            <span class="badge <?php echo e($roleClass); ?>"><?php echo e($admin->role_label); ?></span>
                        </td>
                        <td>
                            <span class="badge <?php echo e($admin->is_active ? 'badge-green' : 'badge-red'); ?>">
                                <?php echo e($admin->is_active ? 'Aktif' : 'Nonaktif'); ?>

                            </span>
                        </td>
<?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <?php if($admin->id !== auth()->id()): ?>
                                <div class="flex gap-2">
                                    <button type="button" onclick="openEditModal(<?php echo e(json_encode(['id'=>$admin->id,'name'=>$admin->name,'username'=>$admin->username,'role'=>$admin->role,'is_active'=>$admin->is_active])); ?>)" class="btn btn-secondary btn-sm">Edit</button>
                                    <form method="POST" action="<?php echo e(route('admin.admins.destroy', $admin)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus akun admin ini?">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="badge badge-gray">Akun kamu</span>
                            <?php endif; ?>
                        </td>
<?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" style="text-align:center;padding:2rem;color:var(--text-muted);">Tidak ada akun admin ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);"><?php echo e($admins->links()); ?></div>
    </div>
</div>


<div id="edit-modal" class="modal-modern" onclick="if(event.target===this)closeEditModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Edit Akun Admin</h3>
            <button type="button" onclick="closeEditModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="edit-form" method="POST">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" id="edit-name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" id="edit-username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Role Admin <span style="color:#f87171;">*</span></label>
                    <select name="role" id="edit-role" required class="gaming-input gaming-select">
                        <option value="admin">Admin Master</option>
                        <option value="head_of_store">Head of Store</option>
                        <option value="gm">General Manager (GM)</option>
                        <option value="ceo">Chief Executive Officer (CEO)</option>
                        <option value="hr">HR (Human Resources)</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" id="edit-is-active" value="1" style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="edit-is-active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>


<div id="create-modal" class="modal-modern" onclick="if(event.target===this)closeCreateModal()">
    <div class="modal-modern-panel md" onclick="event.stopPropagation()">
        <div class="modal-modern-header">
            <h3>Tambah Akun Admin</h3>
            <button type="button" onclick="closeCreateModal()" class="modal-modern-close">&times;</button>
        </div>
        <form id="create-form" method="POST" action="<?php echo e(route('admin.admins.store')); ?>">
            <?php echo csrf_field(); ?>
            <div class="modal-modern-body space-y-4">
                <div>
                    <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                    <input type="text" name="username" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Password <span style="color:#f87171;">*</span></label>
                    <input type="password" name="password" required class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Role Admin <span style="color:#f87171;">*</span></label>
                    <select name="role" required class="gaming-input gaming-select">
                        <option value="">Pilih Role</option>
                        <option value="admin">Admin Master</option>
                        <option value="head_of_store">Head of Store</option>
                        <option value="gm">General Manager (GM)</option>
                        <option value="ceo">Chief Executive Officer (CEO)</option>
                        <option value="hr">HR (Human Resources)</option>
                    </select>
                </div>
            </div>
            <div class="modal-modern-footer gap-2">
                <button type="submit" class="btn btn-primary">Buat Akun</button>
                <button type="button" onclick="closeCreateModal()" class="btn btn-secondary">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleFilterMenu(e) {
    e.stopPropagation();
    var menu = document.getElementById('filter-menu');
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}
function setFilter(value) {
    document.getElementById('status-input').value = value;
    document.getElementById('filter-menu').style.display = 'none';
    document.getElementById('filter-form').submit();
}
document.addEventListener('click', function(e) {
    var menu = document.getElementById('filter-menu');
    if (menu && !e.target.closest('.filter-dropdown-wrap')) {
        menu.style.display = 'none';
    }
});

function openEditModal(data) {
    document.getElementById('edit-form').action = '/admin/admins/' + data.id;
    document.getElementById('edit-name').value = data.name;
    document.getElementById('edit-username').value = data.username;
    document.getElementById('edit-role').value = data.role;
    document.getElementById('edit-is-active').checked = data.is_active == 1;
    openModal('edit-modal');
}
function closeEditModal() {
    closeModal('edit-modal');
}
document.getElementById('edit-modal').addEventListener('click', function(e) { if (e.target === this) closeEditModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeEditModal(); closeCreateModal(); } });

function openCreateModal() {
    document.getElementById('create-form').reset();
    openModal('create-modal');
}
function closeCreateModal() {
    closeModal('create-modal');
}
document.getElementById('create-modal').addEventListener('click', function(e) { if (e.target === this) closeCreateModal(); });
</script>
<?php $__env->startPush('styles'); ?>
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\admins\index.blade.php ENDPATH**/ ?>