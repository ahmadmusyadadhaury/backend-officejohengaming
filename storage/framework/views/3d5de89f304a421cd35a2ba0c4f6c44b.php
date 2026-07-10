<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Edit Admin'); ?>
<?php $__env->startSection('page-title', 'Edit Akun Admin'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="<?php echo e(route('admin.admins.update', $admin)); ?>" class="space-y-4">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div>
                <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" value="<?php echo e(old('name', $admin->name)); ?>" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                <input type="text" name="username" value="<?php echo e(old('username', $admin->username)); ?>" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Role Admin <span style="color:#f87171;">*</span></label>
                <select name="role" required class="gaming-input gaming-select">
                    <option value="admin"         <?php echo e($admin->role === 'admin'         ? 'selected' : ''); ?>>Admin Master</option>
                    <option value="head_of_store" <?php echo e($admin->role === 'head_of_store' ? 'selected' : ''); ?>>Head of Store</option>
                    <option value="gm"            <?php echo e($admin->role === 'gm'            ? 'selected' : ''); ?>>General Manager (GM)</option>
                    <option value="ceo"           <?php echo e($admin->role === 'ceo'           ? 'selected' : ''); ?>>Chief Executive Officer (CEO)</option>
                    <option value="hr"            <?php echo e($admin->role === 'hr'            ? 'selected' : ''); ?>>HR (Human Resources)</option>
                    <option value="admin_ga"      <?php echo e($admin->role === 'admin_ga'      ? 'selected' : ''); ?>>Admin General Affairs</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" <?php echo e($admin->is_active ? 'checked' : ''); ?> style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                <label for="is_active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo e(route('admin.admins.index')); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\admins\edit.blade.php ENDPATH**/ ?>