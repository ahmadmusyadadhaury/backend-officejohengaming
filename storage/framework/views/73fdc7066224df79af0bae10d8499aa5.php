<?php $__env->startSection('title', 'Meeting Mingguan'); ?>
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
<div class="pt-2 max-w-3xl space-y-4 animate-fade-in">

    
    <div class="gaming-card overflow-hidden">
        <div class="p-6 relative" style="background:linear-gradient(135deg,#0e7490,var(--color-primary-dark));">
            <div class="absolute inset-0 grid-pattern opacity-20"></div>
            <div class="relative">
                <div class="flex items-center gap-2 mb-2 flex-wrap">
                    <span style="color:rgba(255,255,255,0.6);font-size:0.8rem;">🔁 Meeting Mingguan</span>
                    <?php
                        $statusClass = match($session->status) {
                            'active'    => 'badge-green',
                            'extended'  => 'badge-yellow',
                            'completed' => 'badge-gray',
                            default     => 'badge-gray',
                        };
                    ?>
                    <span id="session-status-badge" class="badge <?php echo e($statusClass); ?>"><?php echo e(ucfirst($session->status)); ?></span>
                    <span id="rt-label" class="badge badge-cyan" style="display:none;"></span>
                </div>
                <h2 class="font-gaming font-bold text-xl text-white"><?php echo e($session->weeklyMeeting->title); ?></h2>
                <div class="flex flex-wrap gap-4 mt-2" style="color:rgba(255,255,255,0.7);font-size:0.85rem;">
                    <span>📅 <?php echo e($session->session_date->isoFormat('dddd, D MMMM Y')); ?></span>
                    <span id="time-display">🕐 <?php echo e(substr($session->start_time,0,5)); ?> – <?php echo e(substr($session->end_time,0,5)); ?>

                        <?php if($session->actual_end_time && $session->status === 'completed'): ?>
                            <span style="color:#34d399;">(Selesai <?php echo e(substr($session->actual_end_time,0,5)); ?>)</span>
                        <?php endif; ?>
                    </span>
                    <span>🏢 <?php echo e($session->weeklyMeeting->room->name); ?></span>
                </div>
            </div>
        </div>
    </div>

    
    <?php if($session->isActive() && in_array(auth()->user()->role, ['koordinator','head_of_store','gm','admin','hr','ceo'])): ?>
    <div class="gaming-card p-5">
        <p class="font-gaming font-semibold text-sm mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">KELOLA MEETING</p>
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="<?php echo e(route('weekly.extend', $session)); ?>" class="flex items-center gap-2">
                <?php echo csrf_field(); ?>
                <select name="extend_minutes" class="gaming-input gaming-select" style="width:auto;">
                    <option value="15">+15 menit</option>
                    <option value="30">+30 menit</option>
                    <option value="45">+45 menit</option>
                    <option value="60">+60 menit</option>
                    <option value="90">+90 menit</option>
                    <option value="120">+120 menit</option>
                </select>
                <button class="btn btn-sm" style="background:linear-gradient(135deg,#f59e0b,#fbbf24);color:white;">Perpanjang</button>
            </form>
            <form method="POST" action="<?php echo e(route('weekly.complete', $session)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Selesaikan meeting mingguan sekarang?">
                <?php echo csrf_field(); ?>
                <button class="btn btn-success btn-sm">✓ Selesaikan Meeting</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if($session->isActive() && in_array(auth()->user()->role, ['koordinator','head_of_store','gm','admin','hr','ceo'])): ?>
    <div class="gaming-card p-6">
        <p class="font-gaming font-semibold text-sm mb-4" style="color:var(--text-primary);letter-spacing:0.05em;">TAMBAH AGENDA / PRESENTASI</p>
        <form method="POST" action="<?php echo e(route('weekly.contribute', $session)); ?>" enctype="multipart/form-data" class="space-y-3">
            <?php echo csrf_field(); ?>
            <div>
                <label class="gaming-label">Apa yang akan dibahas <span style="color:#f87171;">*</span></label>
                <textarea name="what_to_discuss" rows="3" required placeholder="Tuliskan topik atau agenda yang ingin kamu bahas..." class="gaming-input" style="resize:vertical;"><?php echo e(old('what_to_discuss')); ?></textarea>
            </div>
            <div>
                <label class="gaming-label">Upload File <span style="color:var(--text-muted);font-weight:400;">(Opsional)</span></label>
                <input type="file" name="file" accept=".pdf,.doc,.docx,.ppt,.pptx" class="gaming-input" style="padding:0.5rem;">
                <p class="text-xs mt-1" style="color:var(--text-muted);">Format: PDF, DOC, DOCX, PPT, PPTX. Maks 10MB.</p>
            </div>
            <button type="submit" class="btn btn-sm" style="background:linear-gradient(135deg,#0891b2,#0e7490);color:white;">Tambahkan</button>
        </form>
    </div>
    <?php endif; ?>

    
    <div class="gaming-card overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">AGENDA & KONTRIBUSI</h3>
            <span class="badge badge-cyan"><?php echo e($session->contributions->count()); ?> kontribusi</span>
        </div>
        <div id="contributions-list" class="divide-y" style="border-color:var(--border-color);">
            <?php $__empty_1 = true; $__currentLoopData = $session->contributions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contrib): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="px-5 py-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0 font-gaming font-bold text-sm"
                        style="background:linear-gradient(135deg,#0891b2,var(--color-primary));color:white;">
                        <?php echo e(strtoupper(substr($contrib->user->name, 0, 1))); ?>

                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($contrib->user->name); ?></p>
                            <span class="badge badge-cyan" style="font-size:0.6rem;"><?php echo e($contrib->user->role_label); ?></span>
                            <?php if($contrib->user->team): ?>
                                <span class="badge badge-blue" style="font-size:0.6rem;"><?php echo e($contrib->user->team->name); ?></span>
                            <?php endif; ?>
                            <span class="text-xs" style="color:var(--text-muted);"><?php echo e($contrib->created_at->format('H:i')); ?></span>
                        </div>
                        <p class="text-sm p-3 rounded-lg" style="color:var(--text-secondary);background:var(--bg-surface-2);border:1px solid var(--border-color);"><?php echo e($contrib->what_to_discuss); ?></p>
                        <?php if($contrib->file_path): ?>
                        <a href="<?php echo e(asset('storage/'.$contrib->file_path)); ?>" target="_blank" class="inline-flex items-center gap-1.5 mt-2 text-xs" style="color:var(--color-neon-blue);">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Lihat / Download File
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="px-5 py-8 text-center">
                <p class="text-sm" style="color:var(--text-muted);">Belum ada yang menambahkan agenda.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if($session->status === 'completed'): ?>
    <div class="p-4 rounded-xl flex items-center gap-3" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-sm font-semibold" style="color:#34d399;">Meeting mingguan telah selesai.</p>
    </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    let currentStatus = '<?php echo e($session->status); ?>';
    const sessionId = <?php echo e($session->id); ?>;

    function refreshWeekly() {
        fetch('<?php echo e(route("realtime.weekly")); ?>')
            .then(r => r.json())
            .then(data => {
                const s = data.find(d => d.id === sessionId);
                if (!s) return;
                const rtEl = document.getElementById('rt-label');
                if (rtEl) {
                    rtEl.textContent = s.rt_label;
                    rtEl.style.display = s.rt_label ? '' : 'none';
                }
                if (s.status === 'completed' && currentStatus !== 'completed') {
                    window.location.reload();
                }
                currentStatus = s.status;
            }).catch(() => {});
    }

    setInterval(refreshWeekly, 30000);
    refreshWeekly();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\weekly\show.blade.php ENDPATH**/ ?>