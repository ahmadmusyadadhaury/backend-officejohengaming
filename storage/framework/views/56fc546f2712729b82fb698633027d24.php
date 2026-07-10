<?php $__env->startSection('title', 'Detail Permintaan Override'); ?>
<?php $__env->startSection('page-title', 'Detail Permintaan Override'); ?>
<?php $__env->startSection('sidebar-menu'); ?>
    <?php if(auth()->user()->role === 'admin' || in_array(auth()->user()->role, \App\Models\User::FULL_ACCESS_ROLES)): ?>
        <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php elseif(in_array(auth()->user()->role, ['koordinator'])): ?>
        <?php echo $__env->make('partials.sidebar-leader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('partials.sidebar-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 max-w-3xl space-y-4 animate-fade-in">

    <?php if(session('success')): ?>
    <div class="p-4 rounded-xl text-sm font-semibold" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#34d399;">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    
    <?php
        $statusBadge = match($override->status) {
            'pending' => 'badge-yellow',
            'accepted' => 'badge-green',
            'rejected' => 'badge-red',
            default => 'badge-gray'
        };
        $statusLabel = match($override->status) {
            'pending' => 'Menunggu',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
        };
    ?>

    <div class="gaming-card p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="font-gaming font-bold text-xl" style="color:var(--text-primary);">Permintaan Override</h2>
                <p class="text-sm mt-1" style="color:var(--text-muted);">
                    Diajukan oleh: <strong style="color:var(--color-accent-light);"><?php echo e($override->requesterMeeting->requester->name); ?></strong>
                    (Tim <?php echo e($override->requesterMeeting->team->name); ?>)
                </p>
            </div>
            <span class="badge <?php echo e($statusBadge); ?> flex-shrink-0"><?php echo e($statusLabel); ?></span>
        </div>
    </div>

    
    <div class="gaming-card p-6" style="border-color:rgba(239,68,68,0.2);">
        <h3 class="font-gaming font-semibold mb-3" style="color:#f87171;letter-spacing:0.05em;">BOOKING YANG AKAN DIGANTIKAN</h3>
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="font-semibold" style="color:var(--text-primary);"><?php echo e($override->targetMeeting->title); ?></p>
                <p class="text-sm mt-1" style="color:var(--text-muted);">
                    Oleh: <?php echo e($override->targetMeeting->requester->name); ?> · Tim <?php echo e($override->targetMeeting->team->name); ?>

                </p>
            </div>
            <?php $ts = match($override->targetMeeting->status) {'approved'=>'badge-blue','confirmed'=>'badge-primary','cancelled'=>'badge-gray','in_progress'=>'badge-primary','completed'=>'badge-green',default=>'badge-gray'}; ?>
            <span class="badge <?php echo e($ts); ?> flex-shrink-0"><?php echo e(ucfirst($override->targetMeeting->status)); ?></span>
        </div>
        <div class="grid grid-cols-3 gap-3 mt-3 pt-3" style="border-top:1px solid var(--border-color);">
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Tanggal</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($override->targetMeeting->meeting_date->format('d M Y')); ?></p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e(substr($override->targetMeeting->start_time,0,5)); ?> – <?php echo e(substr($override->targetMeeting->end_time,0,5)); ?></p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Ruangan</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($override->targetMeeting->room->name); ?></p>
            </div>
        </div>
    </div>

    
    <div class="gaming-card p-6" style="border-color:rgba(59,130,246,0.2);">
        <h3 class="font-gaming font-semibold mb-3" style="color:#60a5fa;letter-spacing:0.05em;">BOOKING PENGGANTI</h3>
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="font-semibold" style="color:var(--text-primary);"><?php echo e($override->requesterMeeting->title); ?></p>
                <p class="text-sm mt-1" style="color:var(--text-muted);">
                    Oleh: <?php echo e($override->requesterMeeting->requester->name); ?> · Tim <?php echo e($override->requesterMeeting->team->name); ?>

                </p>
            </div>
            <?php $rs = match($override->requesterMeeting->status) {'pending'=>'badge-yellow','approved'=>'badge-blue','rejected'=>'badge-red',default=>'badge-gray'}; ?>
            <span class="badge <?php echo e($rs); ?> flex-shrink-0"><?php echo e(ucfirst($override->requesterMeeting->status)); ?></span>
        </div>
        <div class="grid grid-cols-3 gap-3 mt-3 pt-3" style="border-top:1px solid var(--border-color);">
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Tanggal</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($override->requesterMeeting->meeting_date->format('d M Y')); ?></p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e(substr($override->requesterMeeting->start_time,0,5)); ?> – <?php echo e(substr($override->requesterMeeting->end_time,0,5)); ?></p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Ruangan</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($override->requesterMeeting->room->name); ?></p>
            </div>
        </div>
    </div>

    
    <div class="gaming-card p-6">
        <h3 class="font-gaming font-semibold mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">ALASAN OVERRIDE</h3>
        <div class="p-4 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
            <p class="text-sm" style="color:var(--text-secondary);"><?php echo e($override->reason); ?></p>
        </div>
    </div>

    
    <?php if($canRespond): ?>
    <div class="gaming-card p-6" style="border-color:rgba(245,158,11,0.3);background:rgba(245,158,11,0.05);">
        <h3 class="font-gaming font-semibold mb-3" style="color:#f59e0b;letter-spacing:0.05em;">TINDAKAN</h3>
        <p class="text-sm mb-4" style="color:var(--text-secondary);">
            Kamu memiliki booking di slot waktu ini. Jika kamu menyetujui override, booking kamu akan dibatalkan dan digantikan oleh pemohon.
        </p>
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="<?php echo e(route('override.accept', $override)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Setujui override? Booking kamu akan dibatalkan.">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <button class="btn btn-success">✓ Setujui Override</button>
            </form>
            <form method="POST" action="<?php echo e(route('override.reject', $override)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Tolak override?">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <button class="btn btn-danger">✗ Tolak Override</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <a href="<?php echo e(url()->previous()); ?>" class="inline-flex items-center gap-1.5 text-sm" style="color:var(--text-muted);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\override\show.blade.php ENDPATH**/ ?>