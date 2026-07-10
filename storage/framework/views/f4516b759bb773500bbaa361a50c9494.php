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
<div class="pt-2 max-w-2xl animate-fade-in">

    
    <?php if(in_array($meeting->status, ['cancelled', 'rejected'])): ?>
    <div class="mb-4 p-4 rounded-xl flex items-center gap-3" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#f87171;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="text-sm font-semibold" style="color:#f87171;">
                Meeting ini telah <?php echo e($meeting->status === 'cancelled' ? 'dibatalkan' : 'ditolak'); ?>

            </p>
            <?php if($meeting->reject_reason): ?>
                <p class="text-xs mt-0.5" style="color:#fca5a5;">Alasan: <?php echo e($meeting->reject_reason); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="gaming-card overflow-hidden">
        
        <div class="p-6 relative" style="background:linear-gradient(135deg,var(--color-primary-dark),var(--color-accent));">
            <div class="absolute inset-0 grid-pattern opacity-20"></div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4" style="color:rgba(255,255,255,0.6);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span style="color:rgba(255,255,255,0.6);font-size:0.8rem;">Undangan Meeting</span>
                </div>
                <h2 class="font-gaming font-bold text-xl text-white"><?php echo e($meeting->title); ?></h2>
                <p class="text-sm mt-1" style="color:rgba(255,255,255,0.7);">
                    Dari: <?php echo e($meeting->requester->name); ?> · <span style="color:var(--color-neon-blue);"><?php echo e($meeting->team->name); ?></span>
                    <?php if($meeting->teams->count()): ?>
                        <?php $__currentLoopData = $meeting->teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> + <?php echo e($t->name); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        
        <div class="grid grid-cols-3 gap-3 p-4" style="background:var(--bg-surface-2);border-bottom:1px solid var(--border-color);">
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Tanggal</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($meeting->meeting_date->isoFormat('ddd, D MMM Y')); ?></p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e(substr($meeting->start_time,0,5)); ?> – <?php echo e(substr($meeting->end_time,0,5)); ?></p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Ruangan</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($meeting->room->name); ?></p>
            </div>
        </div>

        
        <div class="p-6 space-y-4">
            <?php $__currentLoopData = ['why'=>'WHY — Kenapa meeting ini diadakan?','what'=>'WHAT — Apa yang akan dibahas?','how_expected'=>'HOW — Hasil yang diharapkan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($meeting->$field): ?>
            <div>
                <p class="gaming-label"><?php echo e($label); ?></p>
                <p class="text-sm p-3 rounded-lg" style="color:var(--text-secondary);background:var(--bg-surface-2);border:1px solid var(--border-color);"><?php echo e($meeting->$field); ?></p>
            </div>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <?php if($meeting->file_path): ?>
        <div class="px-6 pb-5">
            <p class="gaming-label">File Lampiran</p>
            <a href="<?php echo e(asset('storage/'.$meeting->file_path)); ?>" target="_blank" class="btn btn-secondary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Lihat / Download File
            </a>
        </div>
        <?php endif; ?>

        
        <div class="px-6 py-4 flex items-center justify-between" style="border-top:1px solid var(--border-color);background:var(--bg-surface-2);">
            <p class="text-xs" style="color:var(--text-muted);">
                <?php if($invitation->read_at): ?> Dibaca <?php echo e($invitation->read_at->format('d M Y H:i')); ?> <?php endif; ?>
            </p>
            <?php
                $sb = match($meeting->status) {
                    'approved'=>'badge-blue','confirmed'=>'badge-primary',
                    'in_progress'=>'badge-primary','completed'=>'badge-green',
                    'cancelled'=>'badge-red','rejected'=>'badge-red',default=>'badge-gray'
                };
            ?>
            <span class="badge <?php echo e($sb); ?>"><?php echo e(ucfirst($meeting->status)); ?></span>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\invitations\show.blade.php ENDPATH**/ ?>