<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard'); ?>
<?php $__env->startSection('page-subtitle', 'Selamat datang, ' . auth()->user()->name); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 pt-2 stagger-children">

    
    <div class="gaming-card p-6 relative overflow-hidden" style="background:#6C63FF80;border:1px solid rgba(108,99,255,0.3);">
        <div class="absolute inset-0 grid-pattern opacity-20"></div>
        <div class="relative">
            <h2 class="font-gaming font-bold text-2xl text-white tracking-wide mb-1">Selamat Datang Kembali</h2>
            <p class="text-white/80" style="font-size:0.95rem;">Kelola Meeting, Pembayaran, Aset Perusahaan dalam Satu Sistem</p>
        </div>
    </div>

    
    <div>
        <h3 class="text-xs font-gaming font-bold uppercase tracking-widest mb-3" style="color:var(--text-muted);">Breakdown Akun</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            <?php
                $accountBreakdown = [
                    ['label' => 'Karyawan', 'count' => $stats['total_karyawan'], 'icon' => 'M17 20h5v-2a3 3 0 00-5.856-1.477M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857m-10 1.857v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z', 'bg' => 'linear-gradient(135deg,#3b82f6,#60a5fa)'],
                    ['label' => 'Koordinator', 'count' => $stats['total_koordinator'], 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.659V19a2 2 0 002 2z', 'bg' => 'linear-gradient(135deg,#3b82f6,#60a5fa)'],
                    ['label' => 'Head of Store', 'count' => $stats['total_head_store'], 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'bg' => 'linear-gradient(135deg,#a855f7,#d946ef)'],
                    ['label' => 'General Manager', 'count' => $stats['total_gm'], 'icon' => 'M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'bg' => 'linear-gradient(135deg,#f59e0b,#fbbf24)'],
                    ['label' => 'Chief Executive Officer', 'count' => $stats['total_ceo'], 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'bg' => 'linear-gradient(135deg,#a855f7,#d946ef)'],
                ];
            ?>
            <?php $__currentLoopData = $accountBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="gaming-card p-4 flex items-center gap-3" style="background:<?php echo e($item['bg']); ?>;box-shadow:0 4px 12px rgba(0,0,0,0.2);">
                <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center" style="background:rgba(255,255,255,0.2);">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="<?php echo e($item['icon']); ?>"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-2xl font-gaming font-bold text-white"><?php echo e($item['count']); ?></div>
                    <div class="text-xs text-white/80 font-medium"><?php echo e($item['label']); ?></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div>
        <h3 class="text-xs font-gaming font-bold uppercase tracking-widest mb-3" style="color:var(--text-muted);">Statistik Meeting</h3>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <?php
                $meetingStats = [
                    ['label' => 'Human Resources', 'count' => $stats['total_hr'], 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.659V19a2 2 0 002 2z', 'bg' => 'linear-gradient(135deg,#ec4899,#f472b6)'],
                    ['label' => 'Total Tim', 'count' => $stats['total_team'], 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.659V19a2 2 0 002 2z', 'bg' => 'linear-gradient(135deg,#06b6d4,#22d3ee)'],
                    ['label' => 'Menunggu Approval', 'count' => $stats['pending'], 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'bg' => 'linear-gradient(135deg,#f59e0b,#fbbf24)'],
                    ['label' => 'Meeting Hari Ini', 'count' => $stats['today_meetings'], 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-2a6 6 0 0112 0v2zm0 0h6v-2a6 6 0 00-9-5.659V19a2 2 0 002 2z', 'bg' => 'linear-gradient(135deg,#a855f7,#d946ef)'],
                ];
            ?>
            <?php $__currentLoopData = $meetingStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="gaming-card p-4 flex items-center gap-3" style="background:<?php echo e($item['bg']); ?>;box-shadow:0 4px 12px rgba(0,0,0,0.2);">
                <div class="flex-shrink-0 w-12 h-12 rounded-lg flex items-center justify-center" style="background:rgba(255,255,255,0.2);">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="<?php echo e($item['icon']); ?>"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <div class="text-2xl font-gaming font-bold text-white"><?php echo e($item['count']); ?></div>
                    <div class="text-xs text-white/80 font-medium"><?php echo e($item['label']); ?></div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div style="border-top:1px solid var(--border-color);"></div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="gaming-card overflow-hidden" style="border:1px solid rgba(124,58,237,0.2);">
            <div class="px-5 py-4" style="background:linear-gradient(135deg,rgba(124,58,237,0.1),rgba(124,58,237,0.05));border-bottom:1px solid rgba(124,58,237,0.2);">
                <h3 class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">TOTAL ASET</h3>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div>
                    <div class="text-3xl font-gaming font-bold" style="color:var(--color-accent);"><?php echo e($stats['total_assets']); ?></div>
                    <p class="text-xs" style="color:var(--text-muted);margin-top:4px;">Jumlah Aset</p>
                </div>
                <?php if($stats['assets_near_expire'] > 0): ?>
                <div class="pt-3 px-3 py-2 rounded" style="background:rgba(239,68,68,0.1);border-left:3px solid #ef4444;">
                    <p class="text-xs font-medium" style="color:#ef4444;">⚠ <?php echo e($stats['assets_near_expire']); ?> akan expire dalam 30 hari</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="gaming-card overflow-hidden" style="border:1px solid rgba(59,130,246,0.2);">
            <div class="px-5 py-4" style="background:linear-gradient(135deg,rgba(59,130,246,0.1),rgba(59,130,246,0.05));border-bottom:1px solid rgba(59,130,246,0.2);">
                <h3 class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">MEETING</h3>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div>
                    <div class="text-3xl font-gaming font-bold" style="color:#60a5fa;"><?php echo e($stats['total_meetings']); ?></div>
                    <p class="text-xs" style="color:var(--text-muted);margin-top:4px;">Total Meeting</p>
                </div>
                <div class="pt-1">
                    <p class="text-sm font-medium" style="color:var(--text-primary);"><?php echo e($stats['meetings_this_week']); ?> meeting minggu ini</p>
                </div>
            </div>
        </div>

        
        <div class="gaming-card overflow-hidden" style="border:1px solid rgba(16,185,129,0.2);">
            <div class="px-5 py-4" style="background:linear-gradient(135deg,rgba(16,185,129,0.1),rgba(16,185,129,0.05));border-bottom:1px solid rgba(16,185,129,0.2);">
                <h3 class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">PEMBAYARAN</h3>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div>
                    <div class="text-3xl font-gaming font-bold" style="color:#34d399;"><?php echo e($stats['total_payments']); ?></div>
                    <p class="text-xs" style="color:var(--text-muted);margin-top:4px;">Total Pembayaran</p>
                </div>
                <?php if($stats['pending_payments'] > 0): ?>
                <div class="pt-1">
                    <p class="text-sm font-medium" style="color:#f59e0b;"><?php echo e($stats['pending_payments']); ?> pending pembayaran</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="gaming-card overflow-hidden" style="border:1px solid rgba(245,158,11,0.2);">
            <div class="px-5 py-4" style="background:linear-gradient(135deg,rgba(245,158,11,0.1),rgba(245,158,11,0.05));border-bottom:1px solid rgba(245,158,11,0.2);">
                <h3 class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">ASET DIGITAL</h3>
            </div>
            <div class="px-5 py-4 space-y-3">
                <div>
                    <div class="text-3xl font-gaming font-bold" style="color:#fbbf24;"><?php echo e($stats['digital_assets']); ?></div>
                    <p class="text-xs" style="color:var(--text-muted);margin-top:4px;">Total Aset Digital</p>
                </div>
                <?php if($digitalAssetsNeedMaintenance->count() > 0): ?>
                <div class="pt-1">
                    <p class="text-sm font-medium" style="color:#f59e0b;"><?php echo e($digitalAssetsNeedMaintenance->count()); ?> memerlukan maintenance</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(245,158,11,0.1),rgba(245,158,11,0.05));">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">MENUNGGU APPROVAL</h3>
                <span class="badge" style="background:rgba(245,158,11,0.2);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);"><?php echo e($stats['pending']); ?></span>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                <?php $__empty_1 = true; $__currentLoopData = $approvalWaitingMeetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="px-5 py-3 transition hover:bg-slate-100/5">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="text-sm font-medium" style="color:var(--text-primary);"><?php echo e($meeting->title); ?></p>
                            <p class="text-xs mt-1" style="color:var(--text-muted);"><?php echo e($meeting->room->name); ?> • <?php echo e($meeting->meeting_date->format('d M Y')); ?></p>
                        </div>
                        <a href="<?php echo e(route('admin.meetings.show', $meeting)); ?>" class="badge flex-shrink-0 cursor-pointer" style="background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);">
                            Review
                        </a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Tidak ada meeting yang menunggu approval</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(59,130,246,0.1),rgba(59,130,246,0.05));">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">MEETING HARI INI</h3>
                <span class="badge" style="background:rgba(59,130,246,0.2);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);"><?php echo e(today()->isoFormat('D MMM')); ?></span>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                <?php $__empty_1 = true; $__currentLoopData = $todayMeetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="px-5 py-3 transition hover:bg-slate-100/5">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="w-2 h-2 rounded-full flex-shrink-0" style="background:#60a5fa;box-shadow:0 0 6px rgba(96,165,250,0.6);"></span>
                        <p class="text-sm font-medium" style="color:var(--text-primary);"><?php echo e($meeting->title); ?></p>
                    </div>
                    <p class="text-xs ml-4" style="color:var(--text-muted);"><?php echo e(substr($meeting->start_time,0,5)); ?> – <?php echo e(substr($meeting->end_time,0,5)); ?> • <?php echo e($meeting->team->name); ?></p>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Tidak ada meeting hari ini</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(168,85,247,0.1),rgba(168,85,247,0.05));">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">PEMBAYARAN MENDATANG</h3>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                <?php $__empty_1 = true; $__currentLoopData = $upcomingPayments->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="px-5 py-3 flex items-center justify-between gap-3 transition hover:bg-slate-100/5">
                    <div class="min-w-0">
                        <p class="text-sm font-medium truncate" style="color:var(--text-primary);"><?php echo e($payment->room->name); ?></p>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted);"><?php echo e($payment->meeting_date->format('d M Y')); ?> • <?php echo e(substr($payment->start_time,0,5)); ?></p>
                    </div>
                    <span class="badge flex-shrink-0 text-xs" style="background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);">
                        PENDING
                    </span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Tidak ada pembayaran mendatang</p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="gaming-card overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(16,185,129,0.1),rgba(16,185,129,0.05));">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">UNDANGAN AKTIF</h3>
            </div>
            <div class="divide-y" style="border-color:var(--border-color);">
                <?php $__empty_1 = true; $__currentLoopData = $myInvitations->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="px-5 py-3 flex items-center justify-between gap-3 transition hover:bg-slate-100/5">
                    <div class="min-w-0">
                        <p class="text-sm font-medium truncate" style="color:var(--text-primary);"><?php echo e($inv->meeting->title); ?></p>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted);"><?php echo e($inv->meeting->team->name); ?> • <?php echo e(substr($inv->meeting->start_time,0,5)); ?></p>
                    </div>
                    <span class="badge flex-shrink-0 text-xs" style="background:rgba(16,185,129,0.15);color:#34d399;border:1px solid rgba(16,185,129,0.3);">
                        AKTIF
                    </span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-5 py-8 text-center">
                    <p class="text-sm" style="color:var(--text-muted);">Tidak ada undangan aktif</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <?php if($expiringAssets->count() > 0 || $expiredAssets->count() > 0): ?>
    <div class="gaming-card overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,rgba(239,68,68,0.1),rgba(239,68,68,0.05));">
            <h3 class="font-gaming font-semibold flex items-center gap-2" style="color:var(--text-primary);letter-spacing:0.05em;">
                <svg class="w-5 h-5 flex-shrink-0" style="color:#ef4444;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                </svg>
                PERINGATAN EXPIRE
            </h3>
            <span class="badge" style="background:rgba(239,68,68,0.2);color:#ef4444;border:1px solid rgba(239,68,68,0.3);"><?php echo e($expiringAssets->count() + $expiredAssets->count()); ?></span>
        </div>
        <div class="divide-y" style="border-color:var(--border-color);">
            <?php $__empty_1 = true; $__currentLoopData = $expiredAssets->merge($expiringAssets)->take(8); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $daysLeft = now()->diffInDays($asset->expire_date);
                $isExpired = $asset->expire_date->isPast();
                $badgeClass = $isExpired 
                    ? 'background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.3);'
                    : ($daysLeft <= 7 
                        ? 'background:rgba(245,158,11,0.15);color:#fbbf24;border:1px solid rgba(245,158,11,0.3);'
                        : 'background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.3);');
            ?>
            <div class="px-5 py-3 flex items-center justify-between gap-3 transition hover:bg-slate-100/5">
                <div class="min-w-0">
                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);"><?php echo e($asset->asset_name); ?></p>
                    <p class="text-xs mt-0.5" style="color:var(--text-muted);">
                        <?php if($isExpired): ?>
                            <span style="color:#ef4444;">Expired <?php echo e($daysLeft); ?> hari lalu</span>
                        <?php else: ?>
                            Expire dalam <?php echo e($daysLeft); ?> hari (<?php echo e($asset->expire_date->format('d M Y')); ?>)
                        <?php endif; ?>
                    </p>
                </div>
                <span class="badge flex-shrink-0 text-xs" style="<?php echo e($badgeClass); ?>">
                    <?php if($isExpired): ?>
                        EXPIRED
                    <?php elseif($daysLeft <= 7): ?>
                        URGENT
                    <?php else: ?>
                        SOON
                    <?php endif; ?>
                </span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="px-5 py-8 text-center">
                <p class="text-sm" style="color:var(--text-muted);">Semua aset dalam kondisi baik</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function refreshDashboardStats() {
        fetch('<?php echo e(route("realtime.dashboard")); ?>')
            .then(r => r.json())
            .then(data => {
                if (data.pending !== undefined) {
                    const pendingEl = document.getElementById('stat-pending');
                    if (pendingEl) pendingEl.textContent = data.pending;
                }
                if (data.today_meetings !== undefined) {
                    const todayEl = document.getElementById('stat-today');
                    if (todayEl) todayEl.textContent = data.today_meetings;
                }
            }).catch(() => {});
    }
    setInterval(refreshDashboardStats, 60000);
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\dashboard_new.blade.php ENDPATH**/ ?>