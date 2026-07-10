<?php $__env->startSection('title', 'Ruang Meeting'); ?>
<?php $__env->startSection('page-title', 'Ruang Meeting'); ?>
<?php $__env->startSection('page-subtitle', 'Pilih ruangan untuk booking'); ?>
<?php $__env->startSection('sidebar-menu'); ?>
    <?php if(auth()->user()->hasFullAccess()): ?>
        <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php elseif(auth()->user()->role === 'koordinator'): ?>
        <?php echo $__env->make('partials.sidebar-leader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('partials.sidebar-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 animate-fade-in">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 stagger-children">
        <?php $__empty_1 = true; $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="gaming-card p-5 animate-fade-in">
            <div class="flex items-start justify-between mb-3">
                <div class="min-w-0">
                    <h3 class="font-gaming font-semibold truncate" style="color:var(--text-primary);"><?php echo e($room->name); ?></h3>
                    <?php if($room->location): ?>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted);">📍 <?php echo e($room->location); ?></p>
                    <?php endif; ?>
                </div>
                <span class="badge badge-green flex-shrink-0">Aktif</span>
            </div>
            <div class="flex items-center gap-2 mb-3 p-2 rounded-lg" style="background:var(--bg-surface-2);">
                <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-sm font-medium" style="color:var(--text-primary);"><?php echo e($room->capacity); ?> orang</span>
            </div>
            <?php if($room->description): ?>
                <p class="text-xs mb-3 line-clamp-2" style="color:var(--text-muted);"><?php echo e($room->description); ?></p>
            <?php endif; ?>
            <a href="<?php echo e(route('rooms.show', $room)); ?>" class="btn btn-primary btn-sm w-full">Lihat Detail</a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-3 gaming-card p-10 text-center">
            <p style="color:var(--text-muted);">Belum ada ruangan tersedia.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\rooms\index.blade.php ENDPATH**/ ?>