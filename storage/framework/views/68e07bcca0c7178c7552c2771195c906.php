<?php $__env->startSection('title', 'Undangan Meeting Mingguan'); ?>
<?php $__env->startSection('page-title', 'Meeting Mingguan'); ?>
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
<div class="pt-2 space-y-3 animate-fade-in stagger-children">
    <?php $__empty_1 = true; $__currentLoopData = $invitations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <a href="<?php echo e(route('weekly.show', $inv)); ?>"
        class="gaming-card p-5 flex items-start justify-between gap-3 animate-fade-in"
        style="display:flex;border-left:3px solid <?php echo e(!$inv->is_read ? 'var(--color-neon-blue)' : 'transparent'); ?>;">
        <div class="min-w-0">
            <div class="flex items-center gap-2 mb-1">
                <?php if(!$inv->is_read): ?>
                    <span class="w-2 h-2 rounded-full flex-shrink-0 animate-glow-pulse" style="background:var(--color-neon-blue);"></span>
                <?php endif; ?>
                <p class="font-gaming font-semibold truncate" style="color:var(--text-primary);">🔁 <?php echo e($inv->session->weeklyMeeting->title); ?></p>
            </div>
            <p class="text-sm" style="color:var(--text-muted);"><?php echo e($inv->session->weeklyMeeting->room->name); ?></p>
            <p class="text-sm" style="color:var(--text-muted);">
                <?php echo e($inv->session->session_date->isoFormat('ddd, D MMM Y')); ?>

                · <?php echo e(substr($inv->session->start_time,0,5)); ?> – <?php echo e(substr($inv->session->end_time,0,5)); ?>

            </p>
        </div>
        <?php
            $sc = match($inv->session->status) {
                'active'    => 'badge-green',
                'extended'  => 'badge-yellow',
                'completed' => 'badge-gray',
                default     => 'badge-cyan',
            };
        ?>
        <span class="badge <?php echo e($sc); ?> flex-shrink-0"><?php echo e(ucfirst($inv->session->status)); ?></span>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="gaming-card p-10 text-center">
        <svg class="w-12 h-12 mx-auto mb-3" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        <p style="color:var(--text-muted);">Tidak ada undangan meeting mingguan aktif.</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\weekly\index.blade.php ENDPATH**/ ?>