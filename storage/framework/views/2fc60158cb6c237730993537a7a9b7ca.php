<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Pengaturan Email'); ?>
<?php $__env->startSection('page-title', 'Pengaturan Email'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola alamat pengirim dan penerima notifikasi email'); ?>

<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full pt-4 space-y-4 animate-fade-in">

    <?php if(session('success')): ?>
    <div class="px-5 py-3 rounded-xl text-sm font-semibold" style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);color:#34d399;">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
    <div class="px-5 py-3 rounded-xl text-sm font-semibold" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#f87171;">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $err): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div><?php echo e($err); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.settings.email.update')); ?>" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="gaming-card overflow-hidden">
            <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold flex items-center gap-2" style="color:var(--text-primary);letter-spacing:0.05em;">
                    <svg class="w-4 h-4" style="color:#6c5cff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    PENGIRIM
                </h3>
            </div>
            <div class="p-6 space-y-5">
                <div class="field-group">
                    <label class="text-sm font-medium" style="color:var(--text-primary);">Email Pengirim <span class="field-req">*</span></label>
                    <p class="text-xs mb-1" style="color:var(--text-muted);">Alamat email yang akan muncul sebagai pengirim notifikasi.</p>
                    <input type="email" name="mail_from_address" required
                        value="<?php echo e(old('mail_from_address', $mailFromAddress)); ?>"
                        class="gaming-input" placeholder="contoh@email.com"
                        style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);border-radius:8px;padding:10px 14px;font-size:13px;outline:none;width:100%;">
                </div>
                <div class="field-group">
                    <label class="text-sm font-medium" style="color:var(--text-primary);">Nama Pengirim</label>
                    <p class="text-xs mb-1" style="color:var(--text-muted);">Nama yang akan tampil sebagai pengirim email.</p>
                    <input type="text" name="mail_from_name"
                        value="<?php echo e(old('mail_from_name', $mailFromName)); ?>"
                        class="gaming-input" placeholder="Johen Office System"
                        style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);border-radius:8px;padding:10px 14px;font-size:13px;outline:none;width:100%;">
                </div>
            </div>
        </div>

        <div class="gaming-card overflow-hidden">
            <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold flex items-center gap-2" style="color:var(--text-primary);letter-spacing:0.05em;">
                    <svg class="w-4 h-4" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"/>
                    </svg>
                    PENERIMA NOTIFIKASI
                </h3>
            </div>
            <div class="p-6 space-y-5">
                <div class="field-group">
                    <label class="text-sm font-medium" style="color:var(--text-primary);">Email Penerima <span class="field-req">*</span></label>
                    <p class="text-xs mb-1" style="color:var(--text-muted);">Alamat email penerima notifikasi token listrik rendah. Pisahkan dengan koma jika lebih dari satu.</p>
                    <input type="text" name="token_low_recipients" required
                        value="<?php echo e(old('token_low_recipients', $tokenLowRecipients)); ?>"
                        class="gaming-input" placeholder="email1@email.com,email2@email.com"
                        style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);border-radius:8px;padding:10px 14px;font-size:13px;outline:none;width:100%;">
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-2 pb-8 gap-3">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">
                Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan
            </button>
        </div>

    </form>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.field-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.field-req { color: #f87171; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\settings\email.blade.php ENDPATH**/ ?>