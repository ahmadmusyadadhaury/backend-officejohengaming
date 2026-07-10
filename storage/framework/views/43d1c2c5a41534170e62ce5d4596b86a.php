<?php $__env->startSection('title', 'Booking Saya'); ?>
<?php $__env->startSection('page-title', 'Booking Saya'); ?>
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
    <?php if($bookings->count() > 0): ?>
    <div class="space-y-3 stagger-children">
        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $sc = match($booking->status) {
                'approved'  => 'badge-green',
                'pending'   => 'badge-yellow',
                'cancelled' => 'badge-red',
                default     => 'badge-gray',
            };
        ?>
        <div class="gaming-card p-5 animate-fade-in">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <h3 class="font-gaming font-semibold" style="color:var(--text-primary);"><?php echo e($booking->title); ?></h3>
                    <p class="text-sm mt-0.5" style="color:var(--text-muted);"><?php echo e($booking->room->name); ?></p>
                    <p class="text-sm" style="color:var(--text-muted);">
                        <?php echo e($booking->start_time->format('d M Y H:i')); ?> – <?php echo e($booking->end_time->format('H:i')); ?>

                    </p>
                    <?php if($booking->description): ?>
                        <p class="text-sm mt-1" style="color:var(--text-muted);"><?php echo e($booking->description); ?></p>
                    <?php endif; ?>
                    <span class="badge <?php echo e($sc); ?> mt-2 inline-flex"><?php echo e(ucfirst($booking->status)); ?></span>
                </div>
                <div class="flex gap-2 flex-shrink-0">
                    <a href="<?php echo e(route('bookings.show', $booking)); ?>" class="btn btn-secondary btn-sm">Detail</a>
                    <?php if($booking->status !== 'cancelled'): ?>
                    <form method="POST" action="<?php echo e(route('bookings.destroy', $booking)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Batalkan booking ini?">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger btn-sm">Batal</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php else: ?>
    <div class="gaming-card p-10 text-center">
        <svg class="w-12 h-12 mx-auto mb-3" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
        </svg>
        <p class="mb-4" style="color:var(--text-muted);">Belum ada booking.</p>
        <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-primary btn-sm">Lihat Ruangan</a>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\bookings\index.blade.php ENDPATH**/ ?>