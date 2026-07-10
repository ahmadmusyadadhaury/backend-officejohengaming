<?php $__env->startSection('title', 'Undangan Meeting'); ?>
<?php $__env->startSection('page-title', 'Undangan Meeting'); ?>
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
    <?php
        $sb = match($inv->meeting->status) {
            'approved'    => 'badge-blue',
            'confirmed'   => 'badge-primary',
            'in_progress' => 'badge-primary',
            'cancelled'   => 'badge-red',
            'rejected'    => 'badge-red',
            default       => 'badge-gray',
        };
    ?>
    <a href="<?php echo e(route('invitation.show', $inv)); ?>"
        class="gaming-card p-5 flex items-start justify-between gap-3 animate-fade-in"
        style="display:flex;border-left:3px solid <?php echo e(!$inv->is_read ? 'var(--color-accent)' : 'transparent'); ?>;">
        <div class="min-w-0">
            <div class="flex items-center gap-2 mb-1">
                <?php if(!$inv->is_read): ?>
                    <span class="w-2 h-2 rounded-full flex-shrink-0 animate-glow-pulse" style="background:var(--color-accent);"></span>
                <?php endif; ?>
                <p class="font-gaming font-semibold truncate" style="color:var(--text-primary);"><?php echo e($inv->meeting->title); ?></p>
            </div>
            <p class="text-sm" style="color:var(--text-muted);"><?php echo e($inv->meeting->team->name); ?> · <?php echo e($inv->meeting->room->name); ?></p>
            <p class="text-sm" style="color:var(--text-muted);"><?php echo e($inv->meeting->meeting_date->isoFormat('ddd, D MMM Y')); ?> · <?php echo e(substr($inv->meeting->start_time,0,5)); ?> – <?php echo e(substr($inv->meeting->end_time,0,5)); ?></p>
        </div>
        <span class="badge <?php echo e($sb); ?> flex-shrink-0"><?php echo e(ucfirst($inv->meeting->status)); ?></span>
    </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="gaming-card p-10 text-center">
        <svg class="w-12 h-12 mx-auto mb-3" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        <p style="color:var(--text-muted);">Tidak ada undangan meeting aktif.</p>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\invitations\index.blade.php ENDPATH**/ ?>