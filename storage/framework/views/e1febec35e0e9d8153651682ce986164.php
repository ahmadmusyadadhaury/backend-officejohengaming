<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Meeting Mingguan'); ?>
<?php $__env->startSection('page-title', 'Meeting Mingguan'); ?>
<?php $__env->startSection('page-subtitle', 'Jadwal meeting rutin yang otomatis muncul di kalender'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-4 animate-fade-in">
    <?php $days = [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu']; ?>
    <div class="flex justify-end">
        <?php if(auth()->user()->role !== 'gm'): ?>
        <a href="<?php echo e(route('admin.weekly-meetings.create')); ?>" class="btn btn-primary btn-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Jadwal Mingguan
        </a>
        <?php endif; ?>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 stagger-children">
        <?php $__empty_1 = true; $__currentLoopData = $weeklies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekly): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="gaming-card p-4 animate-fade-in">
            <div class="flex items-start justify-between mb-3">
                <div class="min-w-0">
                    <h3 class="font-gaming font-semibold truncate" style="color:var(--text-primary);"><?php echo e($weekly->title); ?></h3>
                    <p class="text-xs mt-0.5" style="color:var(--color-neon-blue);"><?php echo e($weekly->room->name); ?></p>
                </div>
                <span class="badge <?php echo e($weekly->is_active ? 'badge-green' : 'badge-red'); ?> flex-shrink-0">
                    <?php echo e($weekly->is_active ? 'Aktif' : 'Nonaktif'); ?>

                </span>
            </div>
            <div class="space-y-2 mb-4">
                <div class="flex items-center gap-2 p-2 rounded-lg" style="background:var(--bg-surface-2);">
                    <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm" style="color:var(--text-primary);">Setiap <strong><?php echo e($days[$weekly->day_of_week] ?? '-'); ?></strong></span>
                </div>
                <div class="flex items-center gap-2 p-2 rounded-lg" style="background:var(--bg-surface-2);">
                    <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-neon-blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm" style="color:var(--text-primary);"><?php echo e(substr($weekly->start_time,0,5)); ?> – <?php echo e(substr($weekly->end_time,0,5)); ?></span>
                </div>
            </div>
            <?php if(auth()->user()->role !== 'gm'): ?>
            <div class="flex gap-2 pt-3" style="border-top:1px solid var(--border-color);">
                <a href="<?php echo e(route('admin.weekly-meetings.edit', $weekly)); ?>" class="btn btn-secondary btn-sm flex-1">Edit</a>
                <form method="POST" action="<?php echo e(route('admin.weekly-meetings.destroy', $weekly)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus jadwal ini?" class="flex-1">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button class="btn btn-danger btn-sm w-full">Hapus</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-span-3 gaming-card p-10 text-center">
            <svg class="w-12 h-12 mx-auto mb-3" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <p style="color:var(--text-muted);">Belum ada jadwal meeting mingguan.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\weekly\index.blade.php ENDPATH**/ ?>