<?php
    $isMeetingActive = request()->routeIs('admin.meetings.*', 'admin.moms.*', 'calendar', 'koordinator.meetings.*', 'koordinator.mom.*');
    $isAssetActive = request()->routeIs('admin.vehicles.*', 'admin.digital-assets.*', 'admin.sim-cards.*', 'admin.peralatan-kantor.*', 'admin.ruko.*', 'admin.sosial-media.*', 'admin.aset-mes.*');
    $isPaymentActive = request()->routeIs('admin.pembayaran.*', 'admin.payment-approvals.*', 'payment-approval.*');
    $isAdminActive = request()->routeIs('admin.users.*', 'admin.admins.*', 'admin.assets.*', 'admin.teams.*', 'admin.rooms.*');

    $isFullAccess = in_array(auth()->user()->role, \App\Models\User::FULL_ACCESS_ROLES);

    $hasInvitations = \App\Models\MeetingInvitation::where('user_id', auth()->id())
        ->whereHas('meeting', function($q) {
            $q->whereIn('status', ['approved','confirmed','in_progress'])
              ->where(function($q2) {
                  $q2->where('meeting_date', '>', today())
                     ->orWhere(function($q3) {
                         $q3->where('meeting_date', today())
                            ->where('end_time', '>', \Carbon\Carbon::now()->format('H:i:s'));
                     });
              });
        })->exists();

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

    $role = auth()->user()->role;
    $approverRoles = ['admin', 'head_of_store', 'hr', 'gm', 'ceo'];
    $isApprover = in_array($role, $approverRoles);
    $totalApproval = 0;
    if ($isApprover) {
        $totalApproval = \App\Models\Payment::where('jenis', 'listrik')->where('status', 'pending')->count()
            + \App\Models\WifiPayment::where('status', 'pending')->count()
            + \App\Models\PembayaranAsetDigital::where('status', 'pending')->count()
            + \App\Models\PembayaranIplRuko::where('status', 'pending')->count()
            + \App\Models\PembayaranAsetMes::where('status', 'pending')->count()
            ;
    }
?>

<p class="sidebar-section-label">Overview</p>

<a href="<?php echo e(route('admin.dashboard')); ?>"
    class="sidebar-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
    </svg>
    <span class="truncate">Dashboard</span>
</a>

<?php if($isFullAccess): ?>
<p class="sidebar-section-label">Manajemen</p>

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
    <a href="<?php echo e(route('koordinator.meetings.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('koordinator.meetings.*') ? 'active' : ''); ?>"><span class="truncate">Meeting Saya</span></a>
    <a href="<?php echo e(route('admin.meetings.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.meetings.*') ? 'active' : ''); ?>"><span class="truncate">Permintaan Meeting</span></a>
    <a href="<?php echo e(route('admin.moms.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.moms.*', 'koordinator.mom.*') ? 'active' : ''); ?>"><span class="truncate">Rekap MOM</span></a>
    <a href="<?php echo e(route('calendar')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('calendar') ? 'active' : ''); ?>"><span class="truncate">Jadwal Meeting</span></a>
</div>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="<?php echo e($isAssetActive ? 'true' : 'false'); ?>">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <span class="truncate">Data Aset</span>
        </span>
        <svg class="w-3 h-3 caret <?php echo e($isAssetActive ? 'rotated' : ''); ?>" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu <?php echo e($isAssetActive ? '' : 'hidden'); ?>">
    <a href="<?php echo e(route('admin.vehicles.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.vehicles.*') ? 'active' : ''); ?>"><span class="truncate">Kendaraan</span></a>
    <a href="<?php echo e(route('admin.digital-assets.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.digital-assets.*') ? 'active' : ''); ?>"><span class="truncate">Digital</span></a>
    <a href="<?php echo e(route('admin.sosial-media.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.sosial-media.*') ? 'active' : ''); ?>"><span class="truncate">Sosial Media</span></a>
    <a href="<?php echo e(route('admin.sim-cards.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.sim-cards.*') ? 'active' : ''); ?>"><span class="truncate">SIM Card</span></a>
    <a href="<?php echo e(route('admin.peralatan-kantor.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.peralatan-kantor.*') ? 'active' : ''); ?>"><span class="truncate">Peralatan Kantor</span></a>
    <a href="<?php echo e(route('admin.ruko.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.ruko.*') ? 'active' : ''); ?>"><span class="truncate">Aset Ruko</span></a>
    <a href="<?php echo e(route('admin.aset-mes.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.aset-mes.*') ? 'active' : ''); ?>"><span class="truncate">Aset MES</span></a>
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
    <a href="<?php echo e(route('admin.pembayaran.index', ['jenis' => 'listrik'])); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request('jenis') === 'listrik' ? 'active' : ''); ?>"><span class="truncate">Listrik</span></a>
    <a href="<?php echo e(route('admin.pembayaran.index', ['jenis' => 'internet'])); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request('jenis') === 'internet' ? 'active' : ''); ?>"><span class="truncate">Internet</span></a>
    <a href="<?php echo e(route('admin.pembayaran.index', ['jenis' => 'aset_digital'])); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request('jenis') === 'aset_digital' ? 'active' : ''); ?>"><span class="truncate">Aset Digital</span></a>
    <a href="<?php echo e(route('admin.pembayaran.index', ['jenis' => 'ipl_ruko'])); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request('jenis') === 'ipl_ruko' ? 'active' : ''); ?>"><span class="truncate">IPL Ruko</span></a>
    <?php if(in_array(auth()->user()->role, ['admin', 'hr', 'admin_ga'])): ?>
    <a href="<?php echo e(route('payment-approval.tagihan')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('payment-approval.tagihan') ? 'active' : ''); ?>">
        <span class="truncate">Tagihan</span>
        <span class="sidebar-badge tagihan-badge" style="<?php echo e($totalTagihan > 0 ? '' : 'display:none;'); ?>background:#ef4444;color:#fff;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;line-height:1.4;"><?php echo e($totalTagihan); ?></span>
    </a>
    <a href="<?php echo e(route('payment-approval.create')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('payment-approval.create') ? 'active' : ''); ?>"><span class="truncate">Ajukan Pembayaran</span></a>
    <a href="<?php echo e(route('payment-approval.status')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('payment-approval.status') ? 'active' : ''); ?>"><span class="truncate">Status Pengajuan</span></a>
    <?php endif; ?>
    <a href="<?php echo e(route('admin.payment-approvals.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.payment-approvals.*') ? 'active' : ''); ?>">
        <span class="truncate">Persetujuan</span>
        <span class="sidebar-badge approval-badge" style="<?php echo e($totalApproval > 0 ? '' : 'display:none;'); ?>background:#ef4444;color:#fff;font-size:0.6rem;font-weight:700;padding:1px 5px;border-radius:999px;min-width:18px;text-align:center;line-height:1.4;"><?php echo e($totalApproval); ?></span>
    </a>
</div>

<p class="sidebar-section-label">Admin</p>

<div class="sidebar-section">
    <button type="button" class="sidebar-section-toggle" onclick="toggleSidebarSection(this)" aria-expanded="<?php echo e($isAdminActive ? 'true' : 'false'); ?>">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="truncate">Kelola</span>
        </span>
        <svg class="w-3 h-3 caret <?php echo e($isAdminActive ? 'rotated' : ''); ?>" viewBox="0 0 20 20" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 8l4 4 4-4"/></svg>
    </button>
</div>
<div class="sidebar-submenu <?php echo e($isAdminActive ? '' : 'hidden'); ?>">
    <a href="<?php echo e(route('admin.users.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>"><span class="truncate">Kelola Akun</span></a>
    <?php if(auth()->user()->role === 'admin'): ?>
    <a href="<?php echo e(route('admin.admins.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.admins.*') ? 'active' : ''); ?>"><span class="truncate">Kelola Admin</span></a>
    <?php endif; ?>
    <a href="<?php echo e(route('admin.assets.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.assets.*') ? 'active' : ''); ?>"><span class="truncate">Kelola Aset Meeting</span></a>
    <a href="<?php echo e(route('admin.teams.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.teams.*') ? 'active' : ''); ?>"><span class="truncate">Kelola Tim</span></a>
    <a href="<?php echo e(route('admin.rooms.index')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.rooms.*') ? 'active' : ''); ?>"><span class="truncate">Kelola Ruangan</span></a>
    <a href="<?php echo e(route('admin.settings.email')); ?>" class="sidebar-item sidebar-submenu-item <?php echo e(request()->routeIs('admin.settings.email') ? 'active' : ''); ?>"><span class="truncate">Pengaturan Email</span></a>
</div>

<?php else: ?>

<a href="<?php echo e(route('calendar')); ?>" class="sidebar-item <?php echo e(request()->routeIs('calendar') ? 'active' : ''); ?>">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
    </svg>
    <span class="truncate">Jadwal Meeting</span>
</a>

<?php endif; ?>

<p class="sidebar-section-label">Akun</p>
<a href="<?php echo e(route('profile.edit')); ?>"
    class="sidebar-item <?php echo e(request()->routeIs('profile.edit') ? 'active' : ''); ?>">
    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    <span class="truncate">Profile</span>
</a>
<?php /**PATH C:\laragon\www\backend-officejohengaming\resources\views/partials/sidebar-admin.blade.php ENDPATH**/ ?>