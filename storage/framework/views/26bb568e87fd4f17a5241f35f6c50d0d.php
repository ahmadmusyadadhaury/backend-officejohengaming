<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Edit Ruangan'); ?>
<?php $__env->startSection('page-title', 'Edit Ruangan'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 max-w-lg animate-fade-in">
    <div class="gaming-card p-6">
        <form method="POST" action="<?php echo e(route('admin.rooms.update', $room)); ?>" class="space-y-4">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
            <div>
                <label class="gaming-label">Nama Ruangan <span style="color:#f87171;">*</span></label>
                <input type="text" name="name" value="<?php echo e(old('name', $room->name)); ?>" required class="gaming-input">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="gaming-label">Kapasitas <span style="color:#f87171;">*</span></label>
                    <input type="number" name="capacity" value="<?php echo e(old('capacity', $room->capacity)); ?>" required min="1" class="gaming-input">
                </div>
                <div>
                    <label class="gaming-label">Lokasi <span style="color:#f87171;">*</span></label>
                    <input type="text" name="location" value="<?php echo e(old('location', $room->location)); ?>" required class="gaming-input">
                </div>
            </div>
            <div>
                <label class="gaming-label">Fasilitas <span style="color:var(--text-muted);font-weight:400;">(satu per baris)</span></label>
                <textarea name="facilities" rows="4" class="gaming-input" style="resize:vertical;"><?php echo e(old('facilities', $room->facilities ? implode("\n", $room->facilities) : '')); ?></textarea>
            </div>
            <div>
                <label class="gaming-label">Deskripsi</label>
                <textarea name="description" rows="2" class="gaming-input" style="resize:vertical;"><?php echo e(old('description', $room->description)); ?></textarea>
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" <?php echo e($room->is_active ? 'checked' : ''); ?> style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                <label for="is_active" style="font-size:0.875rem;color:var(--text-secondary);cursor:pointer;">Ruangan Aktif</label>
            </div>
            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="<?php echo e(route('admin.rooms.index')); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\rooms\edit.blade.php ENDPATH**/ ?>