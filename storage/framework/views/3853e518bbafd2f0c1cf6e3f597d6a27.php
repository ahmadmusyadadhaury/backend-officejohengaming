<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?php echo $__env->yieldContent('title', 'JOHEN OFFICE Management System'); ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo e(asset('favicon.ico')); ?>?v=<?php echo e(filemtime(public_path('favicon.ico'))); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('favicon-32x32.png')); ?>?v=<?php echo e(filemtime(public_path('favicon-32x32.png'))); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('favicon-16x16.png')); ?>?v=<?php echo e(filemtime(public_path('favicon-16x16.png'))); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('apple-touch-icon.png')); ?>?v=<?php echo e(filemtime(public_path('apple-touch-icon.png'))); ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?php echo e(asset('css/gaming.css')); ?>?v=<?php echo e(md5_file(public_path('css/gaming.css'))); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .sidebar-safe  { padding-bottom: env(safe-area-inset-bottom, 16px); }
        .topbar-safe   { padding-top: env(safe-area-inset-top, 0px); }
        .min-h-screen-safe { min-height: 100vh; min-height: -webkit-fill-available; }
        body { -webkit-overflow-scrolling: touch; }

        /* Topbar dark mode */
        @media (prefers-color-scheme: dark) {
            .topbar-dropdown {
                background: var(--bg-surface-2) !important;
                border-color: var(--border-color) !important;
            }
            .topbar-dropdown a:hover { background: rgba(255,255,255,0.05) !important; }
            .topbar-dropdown p { color: var(--text-primary) !important; }
            .topbar-dropdown .text-xs { color: var(--text-muted) !important; }
        }

        /* Flash message dark mode */
        @media (prefers-color-scheme: dark) {
            .flash-success { background: rgba(16,185,129,0.1) !important; border-color: rgba(16,185,129,0.3) !important; color: #34d399 !important; }
            .flash-error   { background: rgba(239,68,68,0.1) !important; border-color: rgba(239,68,68,0.3) !important; color: #f87171 !important; }
        }

        /* Flatpickr time picker — lebar sesuai input */
        .flatpickr-calendar {
            width: auto !important;
            min-width: 100% !important;
            max-width: none !important;
            border-radius: 8px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            background: var(--bg-surface, #1e1e2e) !important;
            border: 1px solid var(--border-color, #2e2e3e) !important;
        }
        .flatpickr-calendar.noCalendar {
            min-width: 160px !important;
        }
        .flatpickr-time {
            max-height: none !important;
            border-radius: 8px;
            border: none !important;
        }
        .flatpickr-time input {
            font-size: 0.95rem !important;
            font-weight: 600;
            color: var(--text-primary, #eee) !important;
            background: transparent !important;
        }
        .flatpickr-time .flatpickr-am-pm {
            font-size: 0.8rem;
            color: var(--text-secondary, #aaa) !important;
        }
        .flatpickr-time .flatpickr-am-pm:hover {
            background: var(--bg-surface-2, #2a2a3e) !important;
        }
        .flatpickr-time .numInputWrapper span {
            border-color: var(--border-color, #2e2e3e) !important;
        }
        .flatpickr-time .numInputWrapper span:hover {
            background: var(--bg-surface-2, #2a2a3e) !important;
        }
        .flatpickr-calendar:before,
        .flatpickr-calendar:after {
            display: none !important;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body style="background:var(--bg-base);color:var(--text-primary);" class="min-h-screen-safe <?php echo $__env->yieldContent('body-class'); ?>">

    
    <div id="sidebar-overlay" class="fixed inset-0 z-20 hidden lg:hidden"
        style="background:rgba(0,0,0,0.7);backdrop-filter:blur(4px);"
        onclick="toggleSidebar()"></div>

    
    <aside id="sidebar" class="gaming-sidebar lg:w-60 flex flex-col fixed top-0 left-0 z-30 transition-transform duration-300 -translate-x-full lg:translate-x-0" style="height:100dvh;">

        
        <div class="sidebar-brand flex-shrink-0 flex items-center gap-2 px-4 py-4" style="border-bottom:1px solid var(--sidebar-border);">
            <div class="relative flex-shrink-0">
                <img src="<?php echo e(asset('images/logo/logo_web.png')); ?>" alt="JOHEN OFFICE" loading="lazy"
                    class="w-9 h-9 rounded-lg object-contain">

            </div>
            <div class="min-w-0 flex-1">
                <p class="font-gaming font-bold leading-none truncate" style="font-size:0.85rem;color:var(--sidebar-brand);letter-spacing:0.05em;">JOHEN OFFICE</p>
                <p class="truncate" style="font-size:0.6rem;color:#9398b8;letter-spacing:0.1em;margin-top:2px;">MANAGEMENT SYSTEM</p>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden flex-shrink-0" style="color:var(--sidebar-text);background:none;border:none;cursor:pointer;padding:4px;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        
        <nav class="flex-1 min-h-0 overflow-y-auto px-3 py-4 space-y-0.5">
            <?php echo $__env->yieldContent('sidebar-menu'); ?>
        </nav>

        
        <div class="flex-shrink-0 px-3 py-3" style="border-top:1px solid var(--sidebar-border);padding-bottom:max(12px, env(safe-area-inset-bottom));">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="sidebar-item w-full" style="color:#f87171;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    
    <div class="lg:ml-60 flex flex-col min-h-screen-safe">

        
        <header class="gaming-topbar flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg transition"
                    style="color:var(--text-secondary);background:none;border:none;cursor:pointer;"
                    onmouseover="this.style.background='var(--bg-surface-2)'"
                    onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="min-w-0">
                    <h1 class="font-gaming font-semibold leading-tight truncate" style="font-size:1.1rem;color:var(--text-primary);">
                        <?php echo $__env->yieldContent('page-title', 'Dashboard'); ?>
                    </h1>
                    <p class="hidden sm:block truncate" style="font-size:0.8rem;color:var(--text-muted);"><?php echo $__env->yieldContent('page-subtitle', ''); ?></p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                
                <?php
                    $activeInvitations = \App\Models\MeetingInvitation::where('user_id', auth()->id())
                        ->whereHas('meeting', function($q) {
                            $q->whereIn('status', ['approved','confirmed','in_progress'])
                              ->where(function($q2) {
                                  $q2->where('meeting_date', '>', today())
                                     ->orWhere(function($q3) {
                                         $q3->where('meeting_date', today())
                                            ->where('end_time', '>', \Carbon\Carbon::now()->format('H:i:s'));
                                     });
                              });
                        });
                    $activeInvitations = $activeInvitations->with('meeting')->get();
                    $pendingInvitations = $activeInvitations->where('is_read', false);
                    $activeWeeklyInvitations = \App\Models\WeeklyMeetingInvitation::where('user_id', auth()->id())
                        ->whereHas('session', fn($q) => $q->whereIn('status', ['active','extended']))
                        ->with('session.weeklyMeeting')->get();
                    $pendingWeeklyInvitations = $activeWeeklyInvitations->where('is_read', false);
                    $totalPending = $pendingInvitations->count() + $pendingWeeklyInvitations->count();
                ?>
                <span id="notif-total-pending" data-count="<?php echo e($totalPending); ?>" class="hidden"></span>

                <div class="flex items-center gap-2">
                    <div class="relative hidden sm:block">
                        <button type="button" data-notif-btn onclick="this.nextElementSibling.classList.toggle('hidden')" class="topbar-btn" aria-label="Notifikasi">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span data-notif-badge class="topbar-badge <?php echo e($totalPending > 0 ? '' : 'hidden'); ?>"><?php echo e($totalPending); ?></span>
                        </button>
                        <div class="hidden absolute right-0 top-12 w-64 rounded-xl z-50 max-h-80 overflow-y-auto topbar-dropdown"
                            style="background:var(--bg-surface);border:1px solid var(--border-color);box-shadow:var(--shadow-lg);">
                            
                            <p class="px-4 py-2 font-gaming font-semibold" style="font-size:0.7rem;letter-spacing:0.08em;color:var(--text-muted);border-bottom:1px solid var(--border-color);">
                                UNDANGAN AKTIF
                            </p>
                            <?php if($activeInvitations->count() === 0 && $activeWeeklyInvitations->count() === 0): ?>
                                <div class="px-4 py-3 text-center text-xs" style="color:var(--text-muted);">
                                    Belum ada undangan aktif
                                </div>
                            <?php endif; ?>
                            <?php $__currentLoopData = $activeInvitations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button type="button" onclick="showInvitationModal(<?php echo e($inv->id); ?>, <?php echo e($inv->meeting_id); ?>)" class="flex items-start gap-3 px-4 py-3 transition text-left w-full" style="border-bottom:1px solid var(--border-color);background:none;border-left:none;border-right:none;border-top:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='transparent'">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:<?php echo e(!$inv->is_read ? 'var(--color-accent)' : 'var(--text-muted)'); ?>;"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);"><?php echo e($inv->meeting->title); ?></p>
                                    <p class="text-xs" style="color:var(--text-muted);"><?php echo e($inv->meeting->meeting_date->format('d M Y')); ?> · <?php echo e(substr($inv->meeting->start_time,0,5)); ?></p>
                                </div>
                            </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $activeWeeklyInvitations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('weekly.show', $inv)); ?>" class="flex items-start gap-3 px-4 py-3 transition" style="border-bottom:1px solid var(--border-color);">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:<?php echo e(!$inv->is_read ? '#00d4ff' : 'var(--text-muted)'); ?>;"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);">🔁 <?php echo e($inv->session->weeklyMeeting->title); ?></p>
                                    <p class="text-xs" style="color:var(--text-muted);"><?php echo e($inv->session->session_date->format('d M Y')); ?> · <?php echo e(substr($inv->session->start_time,0,5)); ?></p>
                                </div>
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            
                            <?php if($upcomingMeetings->count() > 0): ?>
                            <p class="px-4 py-2 font-gaming font-semibold" style="font-size:0.7rem;letter-spacing:0.08em;color:var(--text-muted);border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color);margin-top:4px;">
                                📅 JADWAL MEETING TERDEKAT
                            </p>
                            <?php $__currentLoopData = $upcomingMeetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-start gap-3 px-4 py-3" style="border-bottom:1px solid var(--border-color);">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:var(--color-secondary);"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);"><?php echo e($meeting->title); ?></p>
                                    <p class="text-xs" style="color:var(--text-muted);"><?php echo e($meeting->meeting_date->format('d M Y')); ?> · <?php echo e(substr($meeting->start_time,0,5)); ?></p>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            
                            <?php
                                $recentNotifs = \App\Models\Notification::where('user_id', auth()->id())
                                    ->where('is_read', false)
                                    ->latest()
                                    ->take(5)
                                    ->get();
                            ?>
                            <?php if($recentNotifs->count() > 0): ?>
                            <p class="px-4 py-2 font-gaming font-semibold" style="font-size:0.7rem;letter-spacing:0.08em;color:var(--text-muted);border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color);margin-top:4px;">
                                🔔 NOTIFIKASI
                            </p>
                            <?php $__currentLoopData = $recentNotifs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $dotColor = match ($n->type) {
                                    'tagihan' => '#ef4444',
                                    'approval' => '#f59e0b',
                                    'meeting' => '#00d4ff',
                                    default => 'var(--color-accent)',
                                };
                            ?>
                            <a href="<?php echo e($n->url ?? '#'); ?>" onclick="markNotifRead('<?php echo e($n->type); ?>', event)" class="flex items-start gap-3 px-4 py-3 transition" style="border-bottom:1px solid var(--border-color);text-decoration:none;">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:<?php echo e($dotColor); ?>;"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);"><?php echo e($n->title); ?></p>
                                    <p class="text-xs" style="color:var(--text-muted);"><?php echo e($n->message); ?></p>
                                </div>
                            </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            
                            <?php if($upcomingAlerts->count() > 0): ?>
                            <p class="px-4 py-2 font-gaming font-semibold" style="font-size:0.7rem;letter-spacing:0.08em;color:var(--text-muted);border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color);margin-top:4px;">
                                ⚠️  PERINGATAN KADALUARSA
                            </p>
                            <?php $__currentLoopData = $upcomingAlerts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-start gap-3 px-4 py-3" style="border-bottom:1px solid var(--border-color);">
                                <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:#f87171;"></div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-medium truncate" style="color:var(--text-primary);"><?php echo e($alert->name); ?></p>
                                    <p class="text-xs" style="color:var(--text-muted);">Stock: <?php echo e($alert->quantity); ?> unit</p>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <?php
                                $notif_isApprover = in_array(auth()->user()->role, ['head_of_store', 'gm', 'hr', 'admin']);
                            ?>
                            <?php if($notif_isApprover && ($pendingPajakApprovalsCount ?? 0) > 0): ?>
                            <a href="<?php echo e(route('admin.vehicles.index')); ?>#pending-approvals" style="text-decoration:none;">
                                <p class="px-4 py-2 font-gaming font-semibold" style="font-size:0.7rem;letter-spacing:0.08em;color:var(--text-muted);border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color);margin-top:4px;">
                                    🔔 PENGAJUAN PAJAK
                                </p>
                                <div class="flex items-start gap-3 px-4 py-3" style="border-bottom:1px solid var(--border-color);">
                                    <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0" style="background:#f59e0b;"></div>
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-medium truncate" style="color:var(--text-primary);"><?php echo e($pendingPajakApprovalsCount); ?> pengajuan menunggu</p>
                                        <p class="text-xs" style="color:var(--text-muted);">Pembayaran pajak kendaraan perlu disetujui</p>
                                    </div>
                                </div>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <button type="button" class="topbar-btn hidden sm:inline-flex" onclick="window.location.href='<?php echo e(route('calendar')); ?>'" aria-label="Kalender">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </button>

                    <button id="theme-toggle" type="button" onclick="toggleTheme()" class="topbar-btn hidden sm:inline-flex" aria-label="Toggle theme">
                        <svg id="theme-toggle-icon" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 3.75a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V4.5A.75.75 0 0112 3.75zm0 14.25a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5a.75.75 0 01.75-.75zm8.25-6.75a.75.75 0 01.75.75h1.5a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75.75.75 0 01.75-.75zM4.5 12a.75.75 0 01.75.75H3.75a.75.75 0 010-1.5h1.5A.75.75 0 014.5 12zm12.03-5.72a.75.75 0 011.06 0l1.06 1.06a.75.75 0 01-1.06 1.06l-1.06-1.06a.75.75 0 010-1.06zM6.36 17.64a.75.75 0 011.06 0l1.06 1.06a.75.75 0 01-1.06 1.06L6.36 18.7a.75.75 0 010-1.06zm12.03 0a.75.75 0 010 1.06l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zM7.42 6.34a.75.75 0 010 1.06L6.36 8.46a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zM12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"/>
                        </svg>
                    </button>

                    <div class="relative">
                        <button type="button" class="topbar-profile-btn" onclick="this.parentElement.querySelector('[data-profile-dropdown]').classList.toggle('hidden')">
                            <span class="topbar-profile-avatar"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 2))); ?></span>
                            <span class="hidden sm:inline font-semibold" style="font-size:0.75rem;color:var(--text-primary);"><?php echo e(auth()->user()->role_label); ?></span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div data-profile-dropdown class="hidden absolute right-0 top-12 w-48 rounded-xl z-50 topbar-dropdown"
                            style="background:var(--bg-surface);border:1px solid var(--border-color);box-shadow:var(--shadow-lg);overflow:hidden;">
                            <div class="px-4 py-3 border-b" style="border-color:var(--border-color);">
                                <p class="text-sm font-semibold" style="color:var(--text-primary);"><?php echo e(auth()->user()->name); ?></p>
                                <p class="text-xs" style="color:var(--text-muted);"><?php echo e(auth()->user()->email); ?></p>
                            </div>
                            <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-3 px-4 py-3 transition"
                                style="color:var(--text-primary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium">Profile Saya</span>
                            </a>
                            <a href="<?php echo e(route('settings.index')); ?>" class="flex items-center gap-3 px-4 py-3 transition"
                                style="color:var(--text-primary);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-sm font-medium">Pengaturan</span>
                            </a>

                            
                            <div class="sm:hidden border-t" style="border-color:var(--border-color);">
                                <button type="button" onclick="var dd=this.closest('[data-profile-dropdown]');dd.classList.add('hidden');var nd=document.querySelector('[data-notif-btn]');if(nd)nd.click();" class="w-full flex items-center gap-3 px-4 py-3 transition"
                                    style="color:var(--text-primary);background:none;border:none;cursor:pointer;text-align:left;"
                                    onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    <span class="text-sm font-medium">Notifikasi</span>
                                    <span data-notif-badge class="topbar-badge <?php echo e($totalPending > 0 ? '' : 'hidden'); ?>" style="position:static;margin-left:auto;"><?php echo e($totalPending); ?></span>
                                </button>
                            </div>

                            
                            <div class="sm:hidden" style="border-top:1px solid var(--border-color);">
                                <a href="<?php echo e(route('calendar')); ?>" class="flex items-center gap-3 px-4 py-3 transition"
                                    style="color:var(--text-primary);text-decoration:none;"
                                    onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="text-sm font-medium">Kalender</span>
                                </a>
                            </div>

                            
                            <div class="sm:hidden" style="border-top:1px solid var(--border-color);">
                                <button type="button" onclick="toggleTheme();this.closest('[data-profile-dropdown]').classList.toggle('hidden')" class="w-full flex items-center gap-3 px-4 py-3 transition"
                                    style="color:var(--text-primary);background:none;border:none;cursor:pointer;text-align:left;"
                                    onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 3.75a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V4.5A.75.75 0 0112 3.75zm0 14.25a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5a.75.75 0 01.75-.75zm8.25-6.75a.75.75 0 01.75.75h1.5a.75.75 0 010 1.5h-1.5a.75.75 0 01-.75-.75.75.75 0 01.75-.75zM4.5 12a.75.75 0 01.75.75H3.75a.75.75 0 010-1.5h1.5A.75.75 0 014.5 12zm12.03-5.72a.75.75 0 011.06 0l1.06 1.06a.75.75 0 01-1.06 1.06l-1.06-1.06a.75.75 0 010-1.06zM6.36 17.64a.75.75 0 011.06 0l1.06 1.06a.75.75 0 01-1.06 1.06L6.36 18.7a.75.75 0 010-1.06zm12.03 0a.75.75 0 010 1.06l-1.06 1.06a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zM7.42 6.34a.75.75 0 010 1.06L6.36 8.46a.75.75 0 01-1.06-1.06l1.06-1.06a.75.75 0 011.06 0zM12 7.5a4.5 4.5 0 100 9 4.5 4.5 0 000-9z"/>
                                    </svg>
                                    <span class="text-sm font-medium">Tema</span>
                                </button>
                            </div>

                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="border-t" style="border-color:var(--border-color);">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 transition"
                                    style="color:#f87171;background:none;border:none;cursor:pointer;text-align:left;"
                                    onmouseover="this.style.background='rgba(248, 113, 113, 0.1)'" onmouseout="this.style.background='none'">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    <span class="text-sm font-medium">Keluar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        
        <div class="px-4 lg:px-6 pt-4">
            <?php if(session('success')): ?>
                <span id="success-flash-data" style="display:none;"><?php echo e(session('success')); ?></span>
            <?php endif; ?>
            <?php if(session('access_error')): ?>
                <span id="access-error-flash-data" style="display:none;"><?php echo e(session('access_error')); ?></span>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="flash-error rounded-lg px-4 py-3 mb-4 text-sm flex items-center gap-2 animate-fade-in"
                    style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ef4444;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
            <?php if($errors->any()): ?>
                <div class="flash-error rounded-lg px-4 py-3 mb-4 text-sm animate-fade-in"
                    style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ef4444;">
                    <ul class="list-disc list-inside space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        
        <main class="flex-1 page-content">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    
    <div id="invitation-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
        <div class="w-full max-w-[480px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Detail Undangan Meeting</h3>
                <button type="button" onclick="closeInvitationModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1" id="invitation-modal-body">
                <div class="text-center py-8" style="color:var(--text-muted);">Memuat data...</div>
            </div>
            <div class="px-6 py-4 flex-shrink-0 flex justify-end" style="border-top:1px solid var(--border-color);">
                <button type="button" onclick="closeInvitationModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
            </div>
        </div>
    </div>

    
    <div id="success-modal" class="modal-modern" style="z-index:9999;" onclick="if(event.target===this)closeSuccessModal()">
        <div class="modal-modern-panel sm" onclick="event.stopPropagation()">
            <div class="modal-modern-header">
                <h3 id="success-modal-header">Berhasil</h3>
                <button type="button" onclick="closeSuccessModal()" class="modal-modern-close">&times;</button>
            </div>
            <div class="modal-modern-body text-center">
                <div class="flex flex-col items-center py-4 space-y-3">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center" style="background:rgba(16,185,129,0.15);">
                        <svg class="w-7 h-7" fill="#10b981" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-base font-bold" style="color:var(--text-primary);" id="success-modal-title">Berhasil!</h2>
                        <p class="text-sm" style="color:var(--text-tertiary);" id="success-modal-sub">Data telah diproses.</p>
                    </div>
                </div>
            </div>
            <div class="modal-modern-footer justify-center">
                <button type="button" onclick="closeSuccessModal()" class="btn btn-sm btn-primary">Tutup</button>
            </div>
        </div>
    </div>

    
    <div id="confirm-modal" class="modal-modern" style="z-index:60;" onclick="if(event.target===this)closeConfirmModal()">
        <div class="modal-modern-panel sm" onclick="event.stopPropagation()">
            <div class="modal-modern-body text-center">
                <div class="flex flex-col items-center py-3 space-y-3">
                    <div id="confirm-icon-wrap" class="w-12 h-12 rounded-full flex items-center justify-center" style="background:rgba(239,68,68,0.15);">
                        <svg id="confirm-icon-svg" class="w-6 h-6" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path id="confirm-icon-path" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-base font-semibold" style="color:var(--text-primary);" id="confirm-title">Konfirmasi</p>
                        <p class="text-sm" style="color:var(--text-muted);" id="confirm-message">Yakin ingin melanjutkan?</p>
                    </div>
                </div>
            </div>
            <div class="modal-modern-footer justify-center gap-3">
                <button type="button" onclick="closeConfirmModal()" class="btn btn-sm btn-secondary">Batal</button>
                <button type="button" id="confirm-yes-btn" class="btn btn-sm btn-danger">Ya, Hapus</button>
            </div>
        </div>
    </div>

    
    <div id="access-error-modal" class="modal-modern" style="z-index:60;" onclick="if(event.target===this)closeAccessErrorModal()">
        <div class="modal-modern-panel sm" onclick="event.stopPropagation()">
            <div class="modal-modern-header">
                <h3>Akses Ditolak</h3>
                <button type="button" onclick="closeAccessErrorModal()" class="modal-modern-close">&times;</button>
            </div>
            <div class="modal-modern-body text-center">
                <div class="flex flex-col items-center py-4 space-y-3">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center" style="background:rgba(239,68,68,0.12);">
                        <svg class="w-7 h-7" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <p class="text-sm" style="color:var(--text-muted);" id="access-error-message">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                </div>
            </div>
            <div class="modal-modern-footer justify-center">
                <button type="button" onclick="closeAccessErrorModal()" class="btn btn-sm btn-secondary">Tutup</button>
            </div>
        </div>
    </div>

    
    <div id="alert-modal" class="modal-modern" style="z-index:60;" onclick="if(event.target===this)closeAlertModal()">
        <div class="modal-modern-panel sm" onclick="event.stopPropagation()">
            <div class="modal-modern-header">
                <h3 id="alert-modal-title">Perhatian</h3>
                <button type="button" onclick="closeAlertModal()" class="modal-modern-close">&times;</button>
            </div>
            <div class="modal-modern-body text-center">
                <div class="flex flex-col items-center py-4 space-y-3">
                    <div class="w-14 h-14 rounded-full flex items-center justify-center" style="background:rgba(245,158,11,0.12);">
                        <svg class="w-7 h-7" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm" style="color:var(--text-muted);" id="alert-modal-message"></p>
                </div>
            </div>
            <div class="modal-modern-footer justify-center">
                <button type="button" onclick="closeAlertModal()" class="btn btn-sm btn-primary">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) { const el = document.getElementById(id); if (el) { el.style.display = 'flex'; document.body.style.overflow = 'hidden'; } }
        function closeModal(id) { const el = document.getElementById(id); if (el) { el.style.display = 'none'; document.body.style.overflow = ''; } }

        // Success Modal
        function closeSuccessModal() {
            closeModal('success-modal');
        }

        function parseSuccessMessage(msg) {
            const clean = msg.replace(/\.\s*$/, '').trim();
            const parts = clean.split(' berhasil ');
            let entity = parts[0] || clean;
            let action = parts[1] || '';

            const capitalize = (s) => s.charAt(0).toUpperCase() + s.slice(1);

            let header = entity + ' Berhasil';
            if (action) header += ' ' + capitalize(action);

            let title = entity + ' berhasil';
            if (action) title += ' ' + action;
            if (!title.endsWith('!')) title += '!';

            let sub = entity;
            if (action.includes('ditambah') || action.includes('dibuat') || action.includes('dikirim')) {
                sub += ' telah ditambahkan';
            } else if (action.includes('diperbarui')) {
                sub += ' telah diperbarui';
            } else if (action.includes('dihapus') || action.includes('dibatalkan')) {
                sub += ' telah dihapus';
            } else if (action.includes('disetujui')) {
                sub += ' telah disetujui';
            } else if (action.includes('ditolak')) {
                sub += ' telah ditolak';
            } else if (action.includes('dikonfirmasi')) {
                sub += ' telah dikonfirmasi';
            } else if (action.includes('diselesaikan')) {
                sub += ' telah diselesaikan';
            } else if (action) {
                sub += ' telah ' + action;
            } else {
                sub = clean;
            }

            return { header, title, sub };
        }

        function showSuccessModal(msg) {
            const { header, title, sub } = parseSuccessMessage(msg);
            document.getElementById('success-modal-header').textContent = header;
            document.getElementById('success-modal-title').textContent = title;
            document.getElementById('success-modal-sub').textContent = sub;
            openModal('success-modal');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const el = document.getElementById('success-flash-data');
            if (el) showSuccessModal(el.textContent);

            const errEl = document.getElementById('access-error-flash-data');
            if (errEl) openAccessErrorModal(errEl.textContent);

            const sm = document.getElementById('success-modal');
            if (sm) {
                sm.addEventListener('click', function(e) {
                    if (e.target === this) closeSuccessModal();
                });
            }
        });

        let confirmCallback = null;
        function showConfirmModal(message, onConfirm, options) {
            options = options || {};
            document.getElementById('confirm-message').textContent = message;
            var btn = document.getElementById('confirm-yes-btn');
            btn.textContent = options.buttonText || 'Ya, Hapus';
            btn.className = 'btn btn-sm';
            if (options.icon === 'success' || options.buttonColor === '#10b981') {
                btn.classList.add('btn-success');
            } else {
                btn.classList.add('btn-danger');
            }
            var iconWrap = document.getElementById('confirm-icon-wrap');
            var iconSvg = document.getElementById('confirm-icon-svg');
            var iconPath = document.getElementById('confirm-icon-path');
            if (options.icon === 'success') {
                iconWrap.style.background = 'rgba(16,185,129,0.15)';
                iconSvg.style.color = '#10b981';
                iconPath.setAttribute('d', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z');
            } else {
                iconWrap.style.background = 'rgba(239,68,68,0.15)';
                iconSvg.style.color = '#ef4444';
                iconPath.setAttribute('d', 'M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z');
            }
            confirmCallback = onConfirm;
            openModal('confirm-modal');
        }
        function closeConfirmModal() {
            confirmCallback = null;
            closeModal('confirm-modal');
        }

        function openAccessErrorModal(msg) {
            document.getElementById('access-error-message').textContent = msg || 'Anda tidak memiliki izin untuk mengakses halaman ini.';
            openModal('access-error-modal');
        }

        function closeAccessErrorModal() {
            closeModal('access-error-modal');
        }

        function showAlertModal(message, title) {
            document.getElementById('alert-modal-title').textContent = title || 'Perhatian';
            document.getElementById('alert-modal-message').textContent = message;
            openModal('alert-modal');
        }
        function closeAlertModal() {
            closeModal('alert-modal');
        }
        document.getElementById('alert-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeAlertModal();
        });

        document.getElementById('confirm-yes-btn')?.addEventListener('click', function() {
            if (typeof confirmCallback === 'function') confirmCallback();
            closeConfirmModal();
        });
        document.getElementById('confirm-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeConfirmModal();
        });

        function confirmSubmit(event, form) {
            event.preventDefault();
            const msg = form.getAttribute('data-confirm') || 'Yakin ingin melanjutkan?';
            showConfirmModal(msg, function() { form.submit(); });
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const isOpen  = !sidebar.classList.contains('-translate-x-full');
            sidebar.classList.toggle('-translate-x-full', isOpen);
            overlay.classList.toggle('hidden', isOpen);
        }

        function toggleSidebarSection(button) {
            const section = button.closest('.sidebar-section');
            const submenu = section ? section.nextElementSibling : null;
            const caret   = button.querySelector('.caret');
            if (!submenu || !caret) return;
            submenu.classList.toggle('hidden');
            caret.classList.toggle('rotated');
            button.setAttribute('aria-expanded', submenu.classList.contains('hidden') ? 'false' : 'true');
        }

        function getStoredTheme() {
            try { return localStorage.getItem('johenTheme'); } catch (e) { return null; }
        }

        function updateThemeButton(theme) {
    const icon = document.getElementById('theme-toggle-icon');
    const button = document.getElementById('theme-toggle');

    if (!icon || !button) return;

    icon.setAttribute('viewBox', '0 0 24 24');
    icon.innerHTML = '';

    // Reset
    icon.removeAttribute('stroke');
    icon.removeAttribute('stroke-width');
    icon.removeAttribute('stroke-linecap');
    icon.removeAttribute('stroke-linejoin');
    icon.setAttribute('fill', 'currentColor');

    button.classList.remove('light', 'dark');

    if (theme === 'dark') {

        button.classList.add('dark');

        // Bulan tebal
        icon.innerHTML = `
            <path
                fill-rule="evenodd"
                clip-rule="evenodd"
                d="M9.598 2.75a.75.75 0 01.785.977
                8.25 8.25 0 0010.89 10.89
                .75.75 0 01.977.785
                10.25 10.25 0 11-12.652-12.652z"
            />
        `;

        button.setAttribute(
            'aria-label',
            'Mode Gelap aktif, klik untuk terang'
        );

    } else {

        button.classList.add('light');

        // Matahari
        icon.innerHTML = `
            <path d="M12 18a6 6 0 100-12 6 6 0 000 12z"/>
            <path d="M12 2.25a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75z"/>
            <path d="M12 19.5a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-.75a.75.75 0 01.75-.75z"/>
            <path d="M21 11.25a.75.75 0 010 1.5h-1.5a.75.75 0 010-1.5H21z"/>
            <path d="M4.5 11.25a.75.75 0 010 1.5H3a.75.75 0 010-1.5h1.5z"/>
            <path d="M18.36 5.64a.75.75 0 010 1.06l-1.06 1.06a.75.75 0 11-1.06-1.06l1.06-1.06a.75.75 0 011.06 0z"/>
            <path d="M7.76 16.24a.75.75 0 010 1.06L6.7 18.36a.75.75 0 11-1.06-1.06l1.06-1.06a.75.75 0 011.06 0z"/>
            <path d="M18.36 18.36a.75.75 0 01-1.06 0l-1.06-1.06a.75.75 0 111.06-1.06l1.06 1.06a.75.75 0 010 1.06z"/>
            <path d="M7.76 7.76a.75.75 0 01-1.06 0L5.64 6.7A.75.75 0 116.7 5.64L7.76 6.7a.75.75 0 010 1.06z"/>
        `;

        button.setAttribute(
            'aria-label',
            'Mode Terang aktif, klik untuk gelap'
        );
    }
}

        function applyTheme(theme) {
            const body = document.body;
            body.classList.toggle('dark', theme === 'dark');
            body.classList.toggle('light', theme === 'light');
            updateThemeButton(theme);
            try { localStorage.setItem('johenTheme', theme); } catch (e) {}
        }

        function resolvePreferredTheme() {
            const stored = getStoredTheme();
            if (stored === 'dark' || stored === 'light') return stored;
            return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
        }

        function toggleTheme() {
            const newTheme = document.body.classList.contains('dark') ? 'light' : 'dark';
            applyTheme(newTheme);
        }

        function initTheme() {
            applyTheme(resolvePreferredTheme());
            if (window.matchMedia) {
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
                    if (!getStoredTheme()) {
                        applyTheme(event.matches ? 'dark' : 'light');
                    }
                });
            }
        }

        initTheme();

        // ── Notifikasi Realtime (AudioContext — lebih keras, work di background) ──
        let audioCtx       = null;
        let actBuffer      = null;
        let meetBuffer     = null;
        let soundUnlocked  = false;

        // Unlock AudioContext setelah interaksi user pertama (browser policy)
        document.addEventListener('click', function unlockAudio() {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();

            // Preload & decode kedua sound file
            Promise.all([
                fetch('<?php echo e(asset("sounds/notif-activity.mp3")); ?>').then(r => r.arrayBuffer()).then(buf => audioCtx.decodeAudioData(buf)),
                fetch('<?php echo e(asset("sounds/notif-meeting.mp3")); ?>').then(r => r.arrayBuffer()).then(buf => audioCtx.decodeAudioData(buf)),
            ]).then(([act, meet]) => {
                actBuffer  = act;
                meetBuffer = meet;
            }).catch(() => {});

            soundUnlocked = true;
            document.removeEventListener('click', unlockAudio);
        }, { once: true });

        function playSound(audio) {
            // Fallback ke Audio element jika AudioContext belum siap
            if (typeof audio === 'object' && audio instanceof Audio) {
                audio.currentTime = 0;
                audio.play().catch(() => {});
                return;
            }
        }

        function playBuffer(buffer) {
            if (!soundUnlocked || !audioCtx || !buffer) return;
            const source  = audioCtx.createBufferSource();
            const gain    = audioCtx.createGain();
            gain.gain.value = 2.0; // 2x lebih keras
            source.buffer = buffer;
            source.connect(gain);
            gain.connect(audioCtx.destination);
            source.start(0);
        }

        let pageBaseTitle = document.title;

        function updateSidebarBadge(selector, count) {
            document.querySelectorAll(selector).forEach(el => {
                if (count > 0) {
                    el.textContent = count;
                    el.style.display = 'inline-block';
                } else {
                    el.style.display = 'none';
                }
            });
        }

        function updateNotifBadges(activityCount, meetingCount) {
            document.querySelectorAll('.notif-badge-activity').forEach(el => {
                el.textContent    = activityCount;
                el.style.display  = activityCount > 0 ? 'inline-block' : 'none';
            });
            document.querySelectorAll('.notif-badge-meeting').forEach(el => {
                el.textContent    = meetingCount;
                el.style.display  = meetingCount > 0 ? 'inline-block' : 'none';
            });

            // Update judul tab seperti WhatsApp "(1) New message"
            const totalBadge = activityCount + meetingCount;
            if (!pageBaseTitle) pageBaseTitle = document.title.replace(/^\(\d+\)\s*/, '');
            document.title = totalBadge > 0 ? '(' + totalBadge + ') ' + pageBaseTitle : pageBaseTitle;

            // Badge API untuk icon tab (Chrome/Edge)
            if (navigator.setAppBadge) {
                navigator.setAppBadge(totalBadge).catch(() => {});
            } else if (navigator.clearAppBadge) {
                navigator.clearAppBadge().catch(() => {});
            }
        }

        // Fetch notif dari server, update badge, bunyikan suara jika ada baru
        function pollNotifications() {
            fetch('<?php echo e(route("realtime.notifications")); ?>')
                .then(r => r.json())
                .then(data => {
                    const activityCount = data.items.filter(n => n.type === 'activity').length;
                    const meetingCount  = data.items.filter(n => n.type === 'meeting').length;
                    const tagihanCount  = data.items.filter(n => n.type === 'tagihan').length;
                    const approvalCount = data.items.filter(n => n.type === 'approval').length;

                    // Pertama kali load — set baseline tanpa bunyi
                    if (lastActivityCount === null) {
                        lastActivityCount = activityCount;
                        lastMeetingCount  = meetingCount;
                        lastTagihanCount  = tagihanCount;
                        lastApprovalCount = approvalCount;
                        updateNotifBadges(activityCount, meetingCount);
                        return;
                    }

                    // Ada notif baru — bunyikan suara
                    if (activityCount > lastActivityCount) playBuffer(actBuffer);
                    if (meetingCount  > lastMeetingCount)  playBuffer(meetBuffer);

                    lastActivityCount = activityCount;
                    lastMeetingCount  = meetingCount;
                    lastTagihanCount  = tagihanCount;
                    lastApprovalCount = approvalCount;
                    updateNotifBadges(activityCount, meetingCount);
                    refreshSidebarBadges();
                }).catch(() => {});
        }

        // Tandai notif sudah dibaca — update DB dulu, baru update UI
        function markNotifRead(type, event) {
            if (event) event.preventDefault(); // cegah navigasi dulu
            const href = event ? event.currentTarget.href : null;

            fetch('<?php echo e(route("realtime.notifications.read")); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ type })
            }).then(() => {
                const newActivity = type === 'activity' ? 0 : lastActivityCount;
                const newMeeting  = type === 'meeting'  ? 0 : lastMeetingCount;
                lastActivityCount = newActivity;
                lastMeetingCount  = newMeeting;
                updateNotifBadges(newActivity, newMeeting);
                refreshSidebarBadges();
                if (href) window.location.href = href;
            }).catch(() => {
                if (href) window.location.href = href;
            });
        }

        // Topbar undangan badge + sidebar badge
        function refreshTopbarNotif() {
            fetch('<?php echo e(route("realtime.notif")); ?>')
                .then(r => r.json())
                .then(data => {
                    const badgeEl = document.querySelector('[data-notif-badge]');
                    if (!badgeEl) return;
                    if (data.total_pending > 0) {
                        badgeEl.textContent = data.total_pending;
                        badgeEl.classList.remove('hidden');
                    } else {
                        badgeEl.classList.add('hidden');
                    }

                    // Update sidebar badges
                    updateSidebarBadge('.tagihan-badge', data.total_tagihan || 0);
                    updateSidebarBadge('.approval-badge', data.total_pending_approvals || 0);
                }).catch(() => {});
        }

        function refreshSidebarBadges() {
            fetch('<?php echo e(route("realtime.notif")); ?>')
                .then(r => r.json())
                .then(data => {
                    updateSidebarBadge('.tagihan-badge', data.total_tagihan || 0);
                    updateSidebarBadge('.approval-badge', data.total_pending_approvals || 0);
                }).catch(() => {});
        }

        // Jalankan polling dengan delay 2 detik agar tidak compete dengan render
        setTimeout(pollNotifications, 2000);
        setInterval(pollNotifications, 30000);  // setiap 30 detik
        setInterval(refreshTopbarNotif, 30000); // topbar setiap 30 detik

        // ── Indikator Push Status ──
        const pushDot    = document.getElementById('push-dot');
        const pushLabel  = document.getElementById('push-label');
        const pushStatus = document.getElementById('push-status');

        function updatePushStatus(active, msg) {
            if (pushDot) pushDot.style.background = active ? '#22c55e' : '#ef4444';
            if (pushStatus) pushStatus.title = msg;
            if (pushLabel) pushLabel.textContent = active ? 'PUSH ON' : 'PUSH OFF';
        }

        // ── Web Push Notification ──
        if ('serviceWorker' in navigator && 'PushManager' in window) {
            navigator.serviceWorker.register('/sw.js').then(function(reg) {
                // Listen message dari Service Worker → trigger sound instan
                navigator.serviceWorker.addEventListener('message', function(event) {
                    if (event.data && event.data.type === 'push_notification') {
                        playBuffer(event.data.notifType === 'meeting' ? meetBuffer : actBuffer);
                        pollNotifications();
                    }
                });

                // Cek subscription yang sudah ada
                reg.pushManager.getSubscription().then(function(existing) {
                    if (existing) {
                        sendSubscriptionToServer(existing);
                        updatePushStatus(true, 'Push notification aktif');
                    } else {
                        updatePushStatus(false, 'Belum subscribe — izinkan notifikasi');
                    }
                });

                // Minta izin notifikasi
                Notification.requestPermission().then(function(permission) {
                    if (permission !== 'granted') {
                        updatePushStatus(false, 'Izin notifikasi ditolak — ubah di pengaturan browser');
                        return;
                    }

                    // Ambil VAPID public key
                    fetch('<?php echo e(route("push.vapid")); ?>')
                        .then(r => r.json())
                        .then(data => {
                            const vapidKey = urlBase64ToUint8Array(data.key);

                            reg.pushManager.getSubscription().then(function(existing) {
                                if (existing) {
                                    sendSubscriptionToServer(existing);
                                    updatePushStatus(true, 'Push notification aktif');
                                    return;
                                }

                                // Subscribe baru
                                reg.pushManager.subscribe({
                                    userVisibleOnly: true,
                                    applicationServerKey: vapidKey
                                }).then(function(sub) {
                                    sendSubscriptionToServer(sub);
                                    updatePushStatus(true, 'Push notification aktif');
                                }).catch(function(err) {
                                    updatePushStatus(false, 'Gagal subscribe: ' + err.message);
                                });
                            });
                        }).catch(function(err) {
                            updatePushStatus(false, 'Gagal ambil VAPID key');
                        });
                });
            }).catch(function(err) {
                updatePushStatus(false, 'Service Worker gagal daftar');
            });
        } else {
            updatePushStatus(false, 'Browser tidak mendukung push notification');
        }

        function sendSubscriptionToServer(subscription) {
            const key  = subscription.getKey('p256dh');
            const auth = subscription.getKey('auth');

            fetch('<?php echo e(route("push.subscribe")); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    endpoint: subscription.endpoint,
                    p256dh:   key  ? btoa(String.fromCharCode(...new Uint8Array(key)))  : null,
                    auth:     auth ? btoa(String.fromCharCode(...new Uint8Array(auth))) : null,
                })
            }).catch(() => {});
        }

        function urlBase64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64  = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
            const raw     = window.atob(base64);
            return Uint8Array.from([...raw].map(c => c.charCodeAt(0)));
        }

        // Tutup dropdown profile saat klik di luar
        document.addEventListener('click', function(event) {
            const profileDropdown = document.querySelector('[data-profile-dropdown]');
            const profileButton = event.target.closest('.topbar-profile-btn');
            
            if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
                if (!profileButton && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            }
        });

        // Invitation Modal
        function showInvitationModal(invitationId, meetingId) {
            const body = document.getElementById('invitation-modal-body');
            body.innerHTML = '<div class="text-center py-8" style="color:var(--text-muted);">Memuat data...</div>';
            openModal('invitation-modal');

            fetch('/undangan/' + invitationId, { headers: { 'Accept': 'text/html' } })
                .then(r => r.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const content = doc.querySelector('#content');
                    if (content) {
                        body.innerHTML = content.innerHTML;
                    } else {
                        body.innerHTML = '<div class="text-center py-8" style="color:var(--text-muted);">Gagal memuat data.</div>';
                    }
                })
                .catch(() => {
                    body.innerHTML = '<div class="text-center py-8" style="color:var(--text-muted);">Gagal memuat data.</div>';
                });
        }

        function closeInvitationModal() {
            closeModal('invitation-modal');
        }

        document.getElementById('invitation-modal').addEventListener('click', function(e) {
            if (e.target === this) closeInvitationModal();
        });

        function closeAllModals() {
            document.querySelectorAll('[id$="-modal"]').forEach(function(el) {
                if (el.style.display === 'flex') el.style.display = 'none';
            });
            document.body.style.overflow = '';
        }

        function checkModalOpen() {
            return document.querySelectorAll('[id$="-modal"]').length > 0;
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const sm = document.getElementById('success-modal');
                if (sm && sm.style.display === 'flex') { closeSuccessModal(); return; }
                const cm = document.getElementById('confirm-modal');
                if (cm && cm.style.display === 'flex') { closeConfirmModal(); return; }
                const am = document.getElementById('access-error-modal');
                if (am && am.style.display === 'flex') { closeAccessErrorModal(); return; }
                const alm = document.getElementById('alert-modal');
                if (alm && alm.style.display === 'flex') { closeAlertModal(); return; }
                closeInvitationModal();
                var prModal = document.getElementById('pajak-request-modal');
                if (prModal && prModal.style.display === 'flex') { closeModal('pajak-request-modal'); return; }
            }
        });

        /* === Pajak Request Functions (global — available dari halaman mana pun) === */
        function showPajakRequestModal(vehicleId) {
            closeModal('vehicle-modal');
            closeModal('detail-modal');
            document.querySelectorAll('.dropdown-menu').forEach(function(el) { el.style.display = 'none'; });
            var el = document.getElementById('pr-vehicle_id');
            if (!el) return;
            el.value = vehicleId;
            document.getElementById('pr-jenis').value = '';
            document.getElementById('pr-nominal').value = '';
            document.getElementById('pr-bukti').value = '';
            var label = document.getElementById('pr-bukti-label');
            if (label) label.textContent = 'Klik untuk upload (JPG/PNG)';
            var preview = document.getElementById('pr-bukti-preview');
            if (preview) preview.style.display = 'none';
            var img = document.getElementById('pr-bukti-preview-img');
            if (img) img.src = '';
            var form = document.getElementById('pajak-request-form');
            if (form) form.action = '/admin/vehicles/' + vehicleId + '/pajak-request';
            openModal('pajak-request-modal');
        }

        document.getElementById('pajak-request-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeModal('pajak-request-modal');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    function pad2(v) { return String(v).padStart(2, '0'); }
    function nowTime() {
        const n = new Date();
        return pad2(n.getHours()) + ':' + pad2(n.getMinutes());
    }
    function addHour(t) {
        const [h, m] = t.split(':').map(Number);
        return pad2((h + 1) % 24) + ':' + pad2(m);
    }
    function getTodayStr() {
        return new Date().toISOString().slice(0, 10);
    }
    </script>
    
    <div id="pajak-request-modal" style="display:none;position:fixed;inset:0;z-index:100000;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
        <div style="width:100%;max-width:500px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:20px;box-shadow:0 25px 60px rgba(0,0,0,0.5);display:flex;flex-direction:column;max-height:80vh;" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Ajukan Pembayaran Pajak</h3>
                <button type="button" onclick="closeModal('pajak-request-modal')" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <form id="pajak-request-form" method="POST" enctype="multipart/form-data" style="padding:20px 24px;overflow-y:auto;flex:1;">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="vehicle_id" id="pr-vehicle_id" value="">
                <div style="display:flex;flex-direction:column;gap:14px;">
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:13px;font-weight:600;color:var(--text-primary);">Jenis Pajak <span style="color:#f87171;">*</span></label>
                        <select name="jenis" id="pr-jenis" required style="width:100%;height:48px;padding:0 16px;background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:12px;color:var(--text-primary);font-size:14px;outline:none;">
                            <option value="">Pilih jenis pajak</option>
                            <option value="tahunan">Pajak Tahunan</option>
                            <option value="5_tahunan">Pajak 5 Tahunan</option>
                        </select>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:13px;font-weight:600;color:var(--text-primary);">Nominal Pembayaran <span style="color:#f87171;">*</span></label>
                        <input type="number" name="nominal" id="pr-nominal" required min="0" placeholder="Masukan nominal pembayaran" style="width:100%;height:48px;padding:0 16px;background:var(--bg-surface-2);border:1px solid var(--border-color);border-radius:12px;color:var(--text-primary);font-size:14px;outline:none;box-sizing:border-box;">
                    </div>
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="font-size:13px;font-weight:600;color:var(--text-primary);">Upload Bukti Pembayaran <span style="color:#f87171;">*</span></label>
                        <label for="pr-bukti" style="width:100%;height:80px;background:var(--bg-surface-2);border:1px dashed var(--border-color);border-radius:12px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;cursor:pointer;transition:all 0.25s ease;" onmouseover="this.style.borderColor='rgba(108,92,255,0.4)'" onmouseout="this.style.borderColor='var(--border-color)'">
                            <svg class="w-5 h-5" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span id="pr-bukti-label" style="font-size:12px;color:var(--text-muted);">Klik untuk upload (JPG/PNG)</span>
                        </label>
                        <input type="file" name="bukti_bayar" id="pr-bukti" accept="image/jpeg,image/png" required style="display:none;">
                        <div id="pr-bukti-preview" style="display:none;position:relative;text-align:center;margin-top:8px;">
                            <img id="pr-bukti-preview-img" src="" alt="Preview" style="max-width:100%;max-height:100px;border-radius:8px;object-fit:cover;">
                            <button type="button" onclick="clearUploadBukti()" style="position:absolute;top:4px;right:4px;width:24px;height:24px;border-radius:50%;background:rgba(0,0,0,0.55);color:#fff;border:none;font-size:16px;line-height:1;cursor:pointer;display:flex;align-items:center;justify-content:center;padding:0;" onmouseover="this.style.background='rgba(0,0,0,0.8)'" onmouseout="this.style.background='rgba(0,0,0,0.55)'">×</button>
                        </div>
                    </div>
                </div>
                <div style="display:flex;justify-content:flex-end;gap:12px;padding-top:20px;margin-top:20px;border-top:1px solid var(--border-color);">
                    <button type="button" onclick="closeModal('pajak-request-modal')" style="padding:10px 28px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;background:transparent;border:1px solid var(--border-color);color:var(--text-secondary);" onmouseover="this.style.borderColor='rgba(128,128,128,0.4)';this.style.color='var(--text-primary)'" onmouseout="this.style.borderColor='var(--border-color)';this.style.color='var(--text-secondary)'">Batal</button>
                    <button type="submit" style="padding:10px 28px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">Kirim Pengajuan</button>
                </div>
            </form>
        </div>
    </div>

    <?php echo $__env->yieldPushContent('modals'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
    <script>
        (function() {
            var buktiEl = document.getElementById('pr-bukti');
            if (buktiEl) {
                buktiEl.addEventListener('change', function() {
                    var label = document.getElementById('pr-bukti-label');
                    var preview = document.getElementById('pr-bukti-preview');
                    var previewImg = document.getElementById('pr-bukti-preview-img');
                    if (!label || !preview || !previewImg) return;
                    if (this.files && this.files[0]) {
                        label.textContent = this.files[0].name;
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            preview.style.display = 'block';
                            previewImg.src = e.target.result;
                        };
                        reader.readAsDataURL(this.files[0]);
                    } else {
                        label.textContent = 'Klik untuk upload (JPG/PNG)';
                        preview.style.display = 'none';
                        previewImg.src = '';
                    }
                });
            }
        })();
        function clearUploadBukti() {
            var input = document.getElementById('pr-bukti');
            var label = document.getElementById('pr-bukti-label');
            var preview = document.getElementById('pr-bukti-preview');
            var previewImg = document.getElementById('pr-bukti-preview-img');
            if (input) { input.value = ''; }
            if (label) { label.textContent = 'Klik untuk upload (JPG/PNG)'; }
            if (preview) { preview.style.display = 'none'; }
            if (previewImg) { previewImg.src = ''; }
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views/layouts/app.blade.php ENDPATH**/ ?>