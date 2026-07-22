<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Komposisi Tim'); ?>
<?php $__env->startSection('page-title', 'Overview > Komposisi Tim'); ?>
<?php $__env->startSection('page-subtitle', 'Atur jumlah per posisi dalam organisasi'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 space-y-4 animate-fade-in">

    <div class="gaming-card" style="overflow:visible;">
        <form method="POST" action="<?php echo e(route('admin.team-compositions.update')); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:0.8rem;color:var(--text-primary);">Komposisi Tim</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;font-weight:400;">Atur jumlah per posisi dalam organisasi</div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan
            </button>
        </div>

        <div class="px-6 py-5">
            
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-2.5 md:gap-3 mb-6">
                <?php
                    $roleCards = [
                        ['key' => 'ceo', 'label' => 'CEO', 'color' => '#fbbf24', 'bg' => 'rgba(251,191,36,0.12)', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['key' => 'gm', 'label' => 'General Manager', 'color' => '#a78bfa', 'bg' => 'rgba(167,139,250,0.12)', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
                        ['key' => 'head_of_store', 'label' => 'Head of Store', 'color' => '#34d399', 'bg' => 'rgba(52,211,153,0.12)', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['key' => 'hr', 'label' => 'HR', 'color' => '#fb923c', 'bg' => 'rgba(251,146,60,0.12)', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                        ['key' => 'koordinator', 'label' => 'Koordinator', 'color' => '#38bdf8', 'bg' => 'rgba(56,189,248,0.12)', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                        ['key' => 'total_team', 'label' => 'Total Tim', 'color' => '#c084fc', 'bg' => 'rgba(192,132,252,0.12)', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                        ['key' => 'karyawan', 'label' => 'Karyawan', 'color' => '#f87171', 'bg' => 'rgba(248,113,113,0.12)', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
                    ];
                ?>
                <?php $__currentLoopData = $roleCards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $comp = $compositions->firstWhere('role', $card['key']); ?>
                    <div class="stat-card-compact flex-col items-center text-center py-3" style="border-color:<?php echo e($card['color']); ?>20;">
                        <div class="stat-icon-box mb-1.5" style="background:<?php echo e($card['bg']); ?>;box-shadow:0 0 12px <?php echo e($card['color']); ?>20;">
                            <svg class="w-4 h-4" style="color:<?php echo e($card['color']); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($card['icon']); ?>"/>
                            </svg>
                        </div>
                        <div class="stat-num" style="color:<?php echo e($card['color']); ?>;"><?php echo e($comp->max_count ?? 0); ?></div>
                        <div class="stat-label-text"><?php echo e($card['label']); ?></div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="overflow-x-auto">
                <table class="gaming-table min-w-[500px]">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Posisi</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $compositions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td style="color:var(--text-muted);"><?php echo e($loop->iteration); ?></td>
                            <td style="color:var(--text-primary);font-weight:500;"><?php echo e($comp->label); ?></td>
                            <td>
                                <input type="number" name="max_count[<?php echo e($comp->id); ?>]" value="<?php echo e($comp->max_count); ?>" min="0"
                                    class="gaming-input" style="width:100px;text-align:center;padding:6px 10px;font-size:0.8rem;">
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="3" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data komposisi.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        </form>
    </div>
</div>

<style>
.gaming-table tbody td { padding: 0.75rem 1.125rem; vertical-align: middle; font-size:0.8rem; }
.gaming-table thead th { padding: 0.625rem 1.125rem; font-size:0.65rem; letter-spacing:0.03em; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views/admin/team-compositions/index.blade.php ENDPATH**/ ?>