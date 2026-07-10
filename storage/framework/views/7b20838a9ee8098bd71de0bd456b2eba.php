<?php $__env->startSection('title', 'Ajukan Override Booking'); ?>
<?php $__env->startSection('page-title', 'Ajukan Override Booking'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 max-w-3xl animate-fade-in">
    <div class="gaming-card p-6 mb-4" style="border-color:rgba(245,158,11,0.4);background:rgba(245,158,11,0.05);">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-lg" style="background:rgba(245,158,11,0.2);color:#f59e0b;">⚠️</div>
            <div>
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);">Konflik Jadwal Terdeteksi</h3>
                <p class="text-sm mt-1" style="color:var(--text-secondary);">
                    Ruangan <strong style="color:var(--text-primary);"><?php echo e($conflict->room->name); ?></strong> sudah dibooking oleh
                    <strong style="color:var(--color-accent-light);"><?php echo e($conflict->requester->name); ?></strong>
                    (Tim <strong><?php echo e($conflict->team->name); ?></strong>)
                    pada <strong><?php echo e(\Carbon\Carbon::parse($data['meeting_date'])->format('d M Y')); ?></strong>
                    pukul <strong><?php echo e(substr($conflict->start_time,0,5)); ?> – <?php echo e(substr($conflict->end_time,0,5)); ?></strong>.
                </p>
                <p class="text-sm mt-2 font-semibold" style="color:#f59e0b;">Kamu bisa mengajukan override dengan memberikan alasan yang jelas.</p>
            </div>
        </div>
    </div>

    <div class="gaming-card p-6">
        <h3 class="font-gaming font-semibold mb-4" style="color:var(--text-primary);letter-spacing:0.05em;">MEETING KAMU</h3>
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Judul</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($data['title']); ?></p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Ruangan</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e($conflict->room->name); ?></p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Tanggal</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e(\Carbon\Carbon::parse($data['meeting_date'])->format('d M Y')); ?></p>
            </div>
            <div class="gaming-card-flat p-3">
                <p class="text-xs mb-1" style="color:var(--text-muted);">Waktu</p>
                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e(substr($data['start_time'],0,5)); ?> – <?php echo e(substr($data['end_time'],0,5)); ?></p>
            </div>
        </div>

        <form method="POST" action="<?php echo e(route('override.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="gaming-label">Alasan Override <span style="color:#f87171;">*</span></label>
                <textarea name="reason" rows="4" required placeholder="Jelaskan alasan kenapa booking ini harus didahulukan (urgensi, deadline, etc.)..." class="gaming-input" style="resize:vertical;"><?php echo e(old('reason')); ?></textarea>
                <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm mt-1" style="color:#f87171;"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex gap-3 pt-2" style="border-top:1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">Kirim Permintaan Override</button>
                <a href="<?php echo e(route('koordinator.meetings.create')); ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\override\create.blade.php ENDPATH**/ ?>