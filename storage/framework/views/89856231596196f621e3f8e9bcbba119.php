<?php $__env->startSection('body-class', 'page-leader'); ?>
<?php $__env->startSection('title', 'Detail MOM'); ?>
<?php $__env->startSection('page-title', 'Minutes of Meeting'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 max-w-2xl space-y-4 animate-fade-in">
    <div class="gaming-card overflow-hidden">
        
        <div class="p-5" style="background:linear-gradient(135deg,var(--color-primary-dark),var(--color-accent));position:relative;">
            <div class="absolute inset-0 grid-pattern opacity-20"></div>
            <div class="relative flex items-start justify-between gap-3">
                <div>
                    <h2 class="font-gaming font-bold text-lg text-white"><?php echo e($mom->meeting->title); ?></h2>
                    <p class="text-sm mt-1" style="color:rgba(255,255,255,0.7);"><?php echo e($mom->meeting->meeting_date->format('d M Y')); ?> · <?php echo e($mom->meeting->room->name); ?></p>
                </div>
                <span class="badge <?php echo e($mom->status === 'sent' ? 'badge-green' : 'badge-yellow'); ?> flex-shrink-0">
                    <?php echo e($mom->status === 'sent' ? 'Terkirim' : 'Draft'); ?>

                </span>
            </div>
        </div>

        
        <div class="p-6 space-y-4">
            <?php $__currentLoopData = ['summary'=>'Ringkasan Pembahasan','decisions'=>'Keputusan','action_plan'=>'Action Plan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <p class="gaming-label"><?php echo e($label); ?></p>
                <p class="text-sm p-3 rounded-lg" style="color:var(--text-secondary);background:var(--bg-surface-2);border:1px solid var(--border-color);"><?php echo e($mom->$field); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div>
                <p class="gaming-label">Penanggung Jawab (PIC)</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($mom->pic); ?></p>
            </div>
            <?php if($mom->file_path): ?>
            <div>
                <p class="gaming-label">File Lampiran</p>
                <a href="<?php echo e(asset('storage/'.$mom->file_path)); ?>" target="_blank" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download File
                </a>
            </div>
            <?php endif; ?>
            <?php if($mom->sent_at): ?>
            <p class="text-xs" style="color:var(--text-muted);">Dikirim pada <?php echo e($mom->sent_at->format('d M Y H:i')); ?></p>
            <?php endif; ?>
        </div>

        <?php if($mom->status === 'draft'): ?>
        <div class="flex gap-3 px-6 pb-6 pt-2" style="border-top:1px solid var(--border-color);">
            <a href="<?php echo e(route('koordinator.mom.edit', $mom)); ?>" class="btn btn-secondary btn-sm">Edit MOM</a>
            <form method="POST" action="<?php echo e(route('koordinator.mom.send', $mom)); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                <button class="btn btn-success btn-sm">Kirim MOM</button>
            </form>
        </div>
        <?php endif; ?>
        <div class="flex gap-3 px-6 pb-6 pt-2" style="border-top:1px solid var(--border-color);">
            <a href="<?php echo e(route('mom.export', $mom->id)); ?>" class="btn btn-primary btn-sm inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export
            </a>
        </div>
    </div>

    <a href="<?php echo e(route('koordinator.meetings.show', $mom->meeting_id)); ?>" class="inline-flex items-center gap-1.5 text-sm" style="color:var(--text-muted);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali ke Meeting
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\leader\mom\show.blade.php ENDPATH**/ ?>