<?php
    $isMeetingActive = request()->routeIs('user.*');

    $now = \Carbon\Carbon::today();
    $sevenDays = $now->copy()->addDays(7);
    $totalTagihan = \App\Models\Payment::where('jenis', 'listrik')
            ->whereNull('requested_by')
            ->whereNotIn('status', ['lunas', 'rejected'])
            ->where('jatuh_tempo', '<=', $sevenDays)
            ->count()
        + \App\Models\WifiPayment::whereNull('requested_by')
            ->whereNotIn('status', ['lunas', 'rejected'])
            ->where('masa_tenggang', '<=', $sevenDays)
            ->count()
        + \App\Models\PembayaranAsetDigital::whereNull('requested_by')
            ->whereNotIn('status', ['lunas', 'rejected'])
            ->where('jatuh_tempo', '<=', $sevenDays)
            ->count()
        + \App\Models\PembayaranIplRuko::whereNull('requested_by')
            ->whereNotIn('status', ['lunas', 'rejected'])
            ->where('jatuh_tempo', '<=', $sevenDays)
            ->count()
        + \App\Models\PembayaranAsetMes::whereNull('requested_by')
            ->whereNotIn('status', ['lunas', 'rejected'])
            ->where('jatuh_tempo', '<=', $sevenDays)
            ->count()
        ;
?>

<p class="sidebar-section-label">Menu Utama</p>

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
    <a href="<?php echo e(route('user.dashboard')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('user.dashboard') ? 'active' : ''); ?>"><span class="truncate">Daftar Meeting</span></a>
</div>

<p class="sidebar-section-label">Pembayaran</p>
<a href="<?php echo e(route('payment-approval.tagihan')); ?>"
    class="sidebar-item <?php echo e(request()->routeIs('payment-approval.tagihan') ? 'active' : ''); ?>">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
    <span class="truncate">Tagihan</span>
    <span class="sidebar-badge tagihan-badge" style="<?php echo e($totalTagihan > 0 ? '' : 'display:none;'); ?>background:#ef4444;color:#fff;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;line-height:1.4;"><?php echo e($totalTagihan); ?></span>
</a>
<?php if(auth()->user()->role === 'admin'): ?>
<a href="<?php echo e(route('payment-approval.create')); ?>"
    class="sidebar-item <?php echo e(request()->routeIs('payment-approval.create') ? 'active' : ''); ?>">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
    </svg>
    <span class="truncate">Ajukan Pembayaran</span>
</a>
<?php endif; ?>
<a href="<?php echo e(route('payment-approval.status')); ?>"
    class="sidebar-item <?php echo e(request()->routeIs('payment-approval.status') ? 'active' : ''); ?>">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span class="truncate">Status Pengajuan</span>
</a>

<p class="sidebar-section-label">Akun</p>
<a href="<?php echo e(route('profile.edit')); ?>"
    class="sidebar-item <?php echo e(request()->routeIs('profile.edit') ? 'active' : ''); ?>">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    <span class="truncate">Profile</span>
</a>
<?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\partials\sidebar-user.blade.php ENDPATH**/ ?>