<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Tambah Akun'); ?>
<?php $__env->startSection('page-title', 'Tambah Akun Baru'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="<?php echo e(route('admin.users.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="gaming-label">Nama Lengkap <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Username <span style="color:#f87171;">*</span></label>
                <input type="text" name="username" value="<?php echo e(old('username')); ?>" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Password <span style="color:#f87171;">*</span></label>
                <input type="password" name="password" required class="gaming-input">
            </div>
            <div>
                <label class="gaming-label">Role <span style="color:#f87171;">*</span></label>
                <select name="role" id="role" required onchange="toggleTeam(this.value)" class="gaming-input gaming-select">
                    <option value="">Pilih Role</option>
                    <option value="koordinator" <?php echo e(old('role') === 'koordinator' ? 'selected' : ''); ?>>Koordinator</option>
                    <option value="user" <?php echo e(old('role') === 'user' ? 'selected' : ''); ?>>Karyawan</option>
                    <option value="admin_ga" <?php echo e(old('role') === 'admin_ga' ? 'selected' : ''); ?>>Admin General Affairs</option>
                </select>
            </div>
            <div id="team-field" class="<?php echo e(in_array(old('role'), ['koordinator','user']) ? '' : 'hidden'); ?>">
                <label class="gaming-label">Tim <span style="color:#f87171;">*</span></label>
                <select name="team_id" class="gaming-input gaming-select">
                    <option value="">Pilih Tim</option>
                    <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($team->id); ?>" <?php echo e(old('team_id') == $team->id ? 'selected' : ''); ?>><?php echo e($team->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn btn-primary">Buat Akun</button>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\users\create.blade.php ENDPATH**/ ?>