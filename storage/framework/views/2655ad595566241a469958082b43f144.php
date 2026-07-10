<?php $__env->startSection('title', 'Detail Booking'); ?>
<?php $__env->startSection('page-title', 'Detail Booking'); ?>
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
<div class="pt-2 max-w-2xl animate-fade-in space-y-4">

    <div class="gaming-card overflow-hidden">
        
        <div class="p-5 relative" style="background:linear-gradient(135deg,var(--color-primary-dark),var(--color-accent));">
            <div class="absolute inset-0 grid-pattern opacity-20"></div>
            <div class="relative flex items-start justify-between gap-3">
                <div>
                    <h2 class="font-gaming font-bold text-xl text-white"><?php echo e($booking->title); ?></h2>
                    <p class="text-sm mt-1" style="color:rgba(255,255,255,0.7);"><?php echo e($booking->room->name); ?></p>
                </div>
                <?php
                    $sc = match($booking->status) {
                        'approved'  => 'badge-green',
                        'pending'   => 'badge-yellow',
                        'cancelled' => 'badge-red',
                        default     => 'badge-gray',
                    };
                ?>
                <span class="badge <?php echo e($sc); ?> flex-shrink-0"><?php echo e(ucfirst($booking->status)); ?></span>
            </div>
        </div>

        
        <div class="p-5">
            <div class="grid grid-cols-2 gap-3 mb-4">
                <div class="gaming-card-flat p-3">
                    <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu Mulai</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($booking->start_time->format('d M Y H:i')); ?></p>
                </div>
                <div class="gaming-card-flat p-3">
                    <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu Selesai</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($booking->end_time->format('d M Y H:i')); ?></p>
                </div>
                <div class="gaming-card-flat p-3">
                    <p class="text-xs mb-1" style="color:var(--text-muted);">Kapasitas</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($booking->room->capacity); ?> orang</p>
                </div>
                <?php if($booking->room->location): ?>
                <div class="gaming-card-flat p-3">
                    <p class="text-xs mb-1" style="color:var(--text-muted);">Lokasi</p>
                    <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($booking->room->location); ?></p>
                </div>
                <?php endif; ?>
            </div>
            <?php if($booking->description): ?>
            <div class="p-3 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Deskripsi</p>
                <p class="text-sm" style="color:var(--text-secondary);"><?php echo e($booking->description); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <a href="<?php echo e(route('bookings.index')); ?>" class="inline-flex items-center gap-1.5 text-sm" style="color:var(--text-muted);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Booking Saya
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\bookings\show.blade.php ENDPATH**/ ?>