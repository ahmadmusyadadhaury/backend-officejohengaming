<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Edit Akun'); ?>
<?php $__env->startSection('page-title', 'Edit Akun'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>" class="space-y-4">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Nama Lengkap <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required class="gaming-input">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Username <span style="color:#f87171;">*</span></label>
                <input type="text" name="username" value="<?php echo e(old('username', $user->username)); ?>" required class="gaming-input">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Password Baru <span style="color:var(--text-muted);font-weight:400;">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="gaming-input">
            </div>
            <div>
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Role</label>
                <select name="role" id="role" onchange="toggleTeam(this.value)" class="gaming-input gaming-select">
                    <option value="koordinator" <?php echo e($user->role === 'koordinator' ? 'selected' : ''); ?>>Koordinator</option>
                    <option value="user" <?php echo e($user->role === 'user' ? 'selected' : ''); ?>>Karyawan</option>
                    <option value="admin_ga" <?php echo e($user->role === 'admin_ga' ? 'selected' : ''); ?>>Admin General Affairs</option>
                </select>
            </div>
            <div id="team-field" class="<?php echo e(in_array($user->role, ['koordinator','user']) ? '' : 'hidden'); ?>">
                <label class="block text-xs font-semibold mb-1.5" style="color:var(--text-secondary);letter-spacing:0.06em;text-transform:uppercase;">Tim</label>
                <select name="team_id" class="gaming-input gaming-select">
                    <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($team->id); ?>" <?php echo e($user->team_id == $team->id ? 'selected' : ''); ?>><?php echo e($team->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" <?php echo e($user->is_active ? 'checked' : ''); ?>

                    style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                <label for="is_active" style="font-size:0.85rem;color:var(--text-secondary);cursor:pointer;">Akun Aktif</label>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    function toggleTeam(role) {
        document.getElementById('team-field').classList.toggle('hidden', !['koordinator','user'].includes(role));
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\users\edit.blade.php ENDPATH**/ ?>