<?php $__env->startSection('title', 'Pengaturan'); ?>
<?php $__env->startSection('page-title', 'Pengaturan'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola pengaturan akun kamu'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php if(auth()->user()->hasFullAccess()): ?>
        <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php elseif(auth()->user()->role === 'koordinator'): ?>
        <?php echo $__env->make('partials.sidebar-leader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('partials.sidebar-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .toggle-wrap {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        user-select: none;
    }
    .toggle-wrap input { display: none; }
    .toggle-track {
        position: relative;
        width: 44px;
        height: 24px;
        border-radius: 12px;
        background: var(--border-color);
        transition: background 0.2s;
        flex-shrink: 0;
    }
    .toggle-track::after {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        transition: transform 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .toggle-wrap input:checked + .toggle-track {
        background: var(--color-accent);
    }
    .toggle-wrap input:checked + .toggle-track::after {
        transform: translateX(20px);
    }
    .toggle-label {
        font-size: 0.875rem;
        color: var(--text-primary);
    }
    .toggle-desc {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 1px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full pt-4 space-y-4 animate-fade-in">
    
    <form method="POST" action="<?php echo e(route('settings.update')); ?>" id="settings-form" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="gaming-card overflow-hidden" id="tampilan-section">
            <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">TAMPILAN</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium" style="color:var(--text-primary);">Mode <?php echo e($user->theme === 'dark' ? 'Gelap' : 'Terang'); ?></p>
                        <p class="text-xs" style="color:var(--text-muted);">Ganti tema antarmuka gelap atau terang</p>
                    </div>
                    <label class="toggle-wrap">
                        <input type="hidden" name="theme" value="light">
                        <input type="checkbox" name="theme" value="dark" id="theme-toggle-input"
                            <?php echo e($user->theme === 'dark' ? 'checked' : ''); ?>

                            onchange="previewTheme(this.checked)">
                        <span class="toggle-track"></span>
                    </label>
                </div>
            </div>
        </div>

        
        <div class="gaming-card overflow-hidden">
            <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">NOTIFIKASI</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="toggle-label">Notifikasi Email</p>
                        <p class="toggle-desc">Terima pembaruan melalui email</p>
                    </div>
                    <label class="toggle-wrap">
                        <input type="checkbox" name="email_notifications" value="1"
                            <?php echo e($user->email_notifications ? 'checked' : ''); ?>>
                        <span class="toggle-track"></span>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="toggle-label">Notifikasi Aplikasi</p>
                        <p class="toggle-desc">Terima pemberitahuan di dalam aplikasi</p>
                    </div>
                    <label class="toggle-wrap">
                        <input type="checkbox" name="app_notifications" value="1"
                            <?php echo e($user->app_notifications ? 'checked' : ''); ?>>
                        <span class="toggle-track"></span>
                    </label>
                </div>
            </div>
        </div>

        
        <div class="gaming-card overflow-hidden">
            <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">TENTANG APLIKASI</h3>
            </div>
            <div class="p-6 space-y-0">
                <?php
                    $aboutInfos = [
                        ['label' => 'Nama Aplikasi', 'value' => 'Johen Office'],
                        ['label' => 'Versi',         'value' => '2.0.0'],
                        ['label' => 'Pengguna',      'value' => $user->name . ' (' . $user->role_label . ')'],
                    ];
                ?>
                <?php $__currentLoopData = $aboutInfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between py-3" style="border-bottom:1px solid var(--border-color);">
                        <span class="text-sm" style="color:var(--text-muted);"><?php echo e($info['label']); ?></span>
                        <span class="text-sm font-medium" style="color:var(--text-primary);"><?php echo e($info['value']); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="flex justify-end pt-2 pb-8">
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </form>

</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function previewTheme(isDark) {
        const theme = isDark ? 'dark' : 'light';
        document.body.classList.toggle('dark', isDark);
        document.body.classList.toggle('light', !isDark);
        try { localStorage.setItem('johenTheme', theme); } catch (e) {}
        if (window.updateThemeButton) window.updateThemeButton(theme);
        const label = document.querySelector('#tampilan-section .text-sm.font-medium');
        if (label) label.textContent = 'Mode ' + (isDark ? 'Gelap' : 'Terang');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const chk = document.getElementById('theme-toggle-input');
        if (chk) chk.checked = '<?php echo e($user->theme); ?>' === 'dark';
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\settings\index.blade.php ENDPATH**/ ?>