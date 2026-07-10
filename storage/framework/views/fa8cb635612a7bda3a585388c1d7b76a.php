<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Kelola Booking'); ?>
<?php $__env->startSection('page-title', 'Overview > Kelola Booking'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola pemesanan ruangan dan fasilitas'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 animate-fade-in">
    <div class="gaming-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="gaming-table min-w-[700px]">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Ruangan</th>
                        <th>User</th>
                        <th>Mulai</th>
                        <th>Selesai</th>
                        <th>Status</th>
<?php if(auth()->user()->role !== 'gm'): ?><th>Aksi</th><?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($booking->title); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($booking->room->name); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($booking->user->name); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($booking->start_time->format('d M Y H:i')); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($booking->end_time->format('H:i')); ?></td>
                        <td>
                            <?php
                                $sc = match($booking->status) {
                                    'approved'  => 'badge-green',
                                    'pending'   => 'badge-yellow',
                                    'cancelled' => 'badge-red',
                                    default     => 'badge-gray',
                                };
                            ?>
                            <span class="badge <?php echo e($sc); ?>"><?php echo e(ucfirst($booking->status)); ?></span>
                        </td>
<?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <form method="POST" action="<?php echo e(route('admin.bookings.destroy', $booking)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus booking ini?">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
<?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada booking.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(isset($bookings) && method_exists($bookings, 'links')): ?>
        <div class="px-5 py-3" style="border-top:1px solid var(--border-color);"><?php echo e($bookings->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->startPush('styles'); ?>
<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\bookings\index.blade.php ENDPATH**/ ?>