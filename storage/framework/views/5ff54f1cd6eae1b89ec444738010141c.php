<?php
    $isMeetingActive = request()->routeIs('koordinator.meetings.*', 'koordinator.mom.*', 'calendar');
    $isOperationalActive = request()->routeIs('koordinator.data-saya.*', 'koordinator.asset-saya.*', 'koordinator.aset-tim.*', 'koordinator.aset-mes.*');
    $isPaymentActive = request()->routeIs('payment-approval.*');

    $now = \Carbon\Carbon::today();
    $sevenDays = $now->copy()->addDays(7);
    $userId = auth()->id();
    $myAsetTimIds = \App\Models\AsetTim::where('penanggung_jawab', $userId)->pluck('id');
    $myAsetMesIds = \App\Models\AsetMes::where('penanggung_jawab', $userId)->pluck('id');

    $totalTagihan = ($myAsetTimIds->isNotEmpty()
            ? \App\Models\PembayaranAsetTim::whereNull('requested_by')
                ->whereNotIn('status', ['lunas', 'rejected'])
                ->whereIn('aset_tim_id', $myAsetTimIds)
                ->where('jatuh_tempo', '<=', $sevenDays)
                ->count()
            : 0)
        + ($myAsetMesIds->isNotEmpty()
            ? \App\Models\PembayaranAsetMes::whereNull('requested_by')
                ->whereNotIn('status', ['lunas', 'rejected'])
                ->whereIn('aset_mes_id', $myAsetMesIds)
                ->where('jatuh_tempo', '<=', $sevenDays)
                ->count()
            : 0);
?>

<p class="sidebar-section-label">Menu Utama</p>

<a href="<?php echo e(route('koordinator.dashboard')); ?>"
    class="sidebar-item <?php echo e(request()->routeIs('koordinator.dashboard') ? 'active' : ''); ?>">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
    </svg>
    <span class="truncate">Dashboard</span>
</a>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="<?php echo e($isMeetingActive ? 'true' : 'false'); ?>">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="truncate">Meeting</span>
        </span>
        <svg class="w-3 h-3 caret <?php echo e($isMeetingActive ? 'rotated' : ''); ?>" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu <?php echo e($isMeetingActive ? '' : 'hidden'); ?>">
    <a href="<?php echo e(route('koordinator.meetings.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('koordinator.meetings.index') ? 'active' : ''); ?>">
        <span class="flex-1 truncate">Meeting Saya</span>
        <span class="notif-badge-activity ml-auto" style="display:none;background:#ef4444;color:white;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;"></span>
    </a>
    <a href="<?php echo e(route('koordinator.mom.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('koordinator.mom.index') ? 'active' : ''); ?>"><span class="truncate">Rekap MOM</span></a>
    <a href="<?php echo e(route('calendar')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('calendar') ? 'active' : ''); ?>"><span class="truncate">Jadwal Meeting</span></a>
</div>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="<?php echo e($isOperationalActive ? 'true' : 'false'); ?>">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span class="truncate">Operasional</span>
        </span>
        <svg class="w-3 h-3 caret <?php echo e($isOperationalActive ? 'rotated' : ''); ?>" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu <?php echo e($isOperationalActive ? '' : 'hidden'); ?>">
    <a href="<?php echo e(route('koordinator.data-saya.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('koordinator.data-saya.index') ? 'active' : ''); ?>">
        <span class="truncate">Aset Saya</span>
    </a>
    <a href="<?php echo e(route('koordinator.asset-saya.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('koordinator.asset-saya.*') ? 'active' : ''); ?>">
        <span class="truncate">Data Aset Saya</span>
    </a>
    <a href="<?php echo e(route('koordinator.aset-tim.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('koordinator.aset-tim.index') ? 'active' : ''); ?>"><span class="truncate">Aset TIM</span></a>
    <a href="<?php echo e(route('koordinator.aset-mes.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('koordinator.aset-mes.index') ? 'active' : ''); ?>"><span class="truncate">Aset MES</span></a>
</div>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="<?php echo e($isPaymentActive ? 'true' : 'false'); ?>">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
            <span class="truncate">Pembayaran</span>
        </span>
        <svg class="w-3 h-3 caret <?php echo e($isPaymentActive ? 'rotated' : ''); ?>" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu <?php echo e($isPaymentActive ? '' : 'hidden'); ?>">
    <a href="<?php echo e(route('payment-approval.tagihan')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('payment-approval.tagihan') ? 'active' : ''); ?>">
        <span class="truncate">Tagihan</span>
        <span class="sidebar-badge tagihan-badge" style="<?php echo e($totalTagihan > 0 ? '' : 'display:none;'); ?>background:#ef4444;color:#fff;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;line-height:1.4;"><?php echo e($totalTagihan); ?></span>
    </a>
    <a href="<?php echo e(route('payment-approval.status')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('payment-approval.status') ? 'active' : ''); ?>"><span class="truncate">Status Pengajuan</span></a>
</div>

<p class="sidebar-section-label">Akun</p>
<a href="<?php echo e(route('profile.edit')); ?>"
    class="sidebar-item <?php echo e(request()->routeIs('profile.edit') ? 'active' : ''); ?>">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    <span class="truncate">Profile</span>
</a>
<?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views/partials/sidebar-leader.blade.php ENDPATH**/ ?>