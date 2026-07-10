<?php $__env->startSection('body-class', 'page-admin'); ?>
<?php $__env->startSection('title', $jenisLabels[$jenis]); ?>
<?php $__env->startSection('page-title', 'Pembayaran'); ?>
<?php $__env->startSection('page-subtitle', $jenis === 'internet' ? 'Data WiFi prabayar — Indosat billing tgl 5, IndiHome billing tgl 20. Input setelah bayar.' : 'Kelola tagihan '.$jenisLabels[$jenis]); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<script>window.INLINE_TEST = 'WORKS';</script>
<div class="pt-2 space-y-4 animate-fade-in">

    
    <?php if($jenis === 'internet'): ?>

    <?php
        $alertGroups = collect();
        if (isset($alerts) && $alerts->isNotEmpty()) {
            $alertGroups = $alerts->groupBy(function($w) {
                $s = $w->status_internet;
                if ($s === 'mati') return 'mati';
                if ($s === 'segera_habis') return 'segera_habis';
                if ($s === 'jatuh_tempo') return 'jatuh_tempo';
                return 'other';
            });
        }
    ?>
    <?php if(isset($alerts) && $alerts->isNotEmpty()): ?>
    <div class="space-y-2">
        <?php if(isset($alertGroups['mati'])): ?>
        <div class="gaming-card p-3 flex items-start gap-3" style="border-left:3px solid #ef4444;">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-xs" style="color:var(--text-primary);">
                <span style="font-weight:600;"><?php echo e($alertGroups['mati']->count()); ?> WiFi</span>
                <span style="color:var(--text-muted);"> dengan masa tenggang sudah lewat.</span>
                <button type="button" onclick="setFilter('mati')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
        <?php endif; ?>
        <?php if(isset($alertGroups['segera_habis'])): ?>
        <div class="gaming-card p-3 flex items-start gap-3" style="border-left:3px solid #f59e0b;">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            <div class="text-xs" style="color:var(--text-primary);">
                <span style="font-weight:600;"><?php echo e($alertGroups['segera_habis']->count()); ?> WiFi</span>
                <span style="color:var(--text-muted);"> akan segera habis masa tenggangnya (≤3 hari).</span>
                <button type="button" onclick="setFilter('segera_habis')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
        <?php endif; ?>
        <?php if(isset($alertGroups['jatuh_tempo'])): ?>
        <div class="gaming-card p-3 flex items-start gap-3" style="border-left:3px solid #f97316;">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f97316;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-xs" style="color:var(--text-primary);">
                <span style="font-weight:600;"><?php echo e($alertGroups['jatuh_tempo']->count()); ?> WiFi</span>
                <span style="color:var(--text-muted);"> akan jatuh tempo (≤7 hari).</span>
                <button type="button" onclick="setFilter('jatuh_tempo')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:none rgba(124,58,237,0.25);">
                <svg class="w-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01M3.5 13.58a10.5 10.5 0 0117 0"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);"><?php echo e($stats['total']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-primary);">Total WiFi</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);">Seluruh data WiFi</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:none rgba(16,185,129,0.2);">
                <svg class="w-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#34d399;"><?php echo e($stats['aktif']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Aktif</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(249,115,22,0.15);box-shadow:none rgba(249,115,22,0.2);">
                <svg class="w-[18px]" style="color:#fb923c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#fb923c;"><?php echo e($stats['jatuh_tempo']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Jatuh Tempo</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:none rgba(245,158,11,0.2);">
                <svg class="w-[18px]" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#f59e0b;"><?php echo e($stats['segera_habis']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Segera Habis</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:none rgba(239,68,68,0.2);">
                <svg class="w-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;"><?php echo e($stats['mati']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Mati</div>
                
            </div>
        </div>
    </div>
    <?php elseif($jenis === 'aset_digital'): ?>

    <?php
        $alertGroups = collect();
        if (isset($alerts) && $alerts->isNotEmpty()) {
            $alertGroups = $alerts->groupBy(function($a) {
                if ($a->status_digital === 'mati') return 'mati';
                if ($a->status_digital === 'segera_habis') return 'segera_habis';
                if ($a->status_digital === 'jatuh_tempo') return 'jatuh_tempo';
                return 'other';
            });
        }
    ?>
    <?php if(isset($alerts) && $alerts->isNotEmpty()): ?>
    <div class="space-y-2">
        <?php if(isset($alertGroups['mati'])): ?>
        <div class="gaming-card p-3 flex items-start gap-3" style="border-left:3px solid #ef4444;">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-xs" style="color:var(--text-primary);">
                <span style="font-weight:600;"><?php echo e($alertGroups['mati']->count()); ?> Aset Digital</span>
                <span style="color:var(--text-muted);"> lewat jatuh tempo.</span>
                <button type="button" onclick="setFilter('mati')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
        <?php endif; ?>
        <?php if(isset($alertGroups['segera_habis'])): ?>
        <div class="gaming-card p-3 flex items-start gap-3" style="border-left:3px solid #f59e0b;">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            <div class="text-xs" style="color:var(--text-primary);">
                <span style="font-weight:600;"><?php echo e($alertGroups['segera_habis']->count()); ?> Aset Digital</span>
                <span style="color:var(--text-muted);"> akan segera jatuh tempo (≤3 hari).</span>
                <button type="button" onclick="setFilter('segera_habis')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
        <?php endif; ?>
        <?php if(isset($alertGroups['jatuh_tempo'])): ?>
        <div class="gaming-card p-3 flex items-start gap-3" style="border-left:3px solid #f97316;">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f97316;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-xs" style="color:var(--text-primary);">
                <span style="font-weight:600;"><?php echo e($alertGroups['jatuh_tempo']->count()); ?> Aset Digital</span>
                <span style="color:var(--text-muted);"> akan jatuh tempo (≤7 hari).</span>
                <button type="button" onclick="setFilter('jatuh_tempo')" class="text-xs font-semibold" style="color:#a78bfa;background:none;border:none;cursor:pointer;text-decoration:underline;padding:0;margin-left:4px;">Lihat</button>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:none rgba(124,58,237,0.25);">
                <svg class="w-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);"><?php echo e($stats['total']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-primary);">Total Aset Digital</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);"><?php echo e($stats['total']); ?> tagihan</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:none rgba(16,185,129,0.2);">
                <svg class="w-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#34d399;"><?php echo e($stats['aktif']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Aktif</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(249,115,22,0.15);box-shadow:none rgba(249,115,22,0.2);">
                <svg class="w-[18px]" style="color:#fb923c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#fb923c;"><?php echo e($stats['jatuh_tempo']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Jatuh Tempo</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:none rgba(245,158,11,0.2);">
                <svg class="w-[18px]" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#f59e0b;"><?php echo e($stats['segera_habis']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Segera Habis</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:none rgba(239,68,68,0.2);">
                <svg class="w-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;"><?php echo e($stats['mati']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Mati</div>
                
            </div>
        </div>
    </div>
    <?php elseif($jenis === 'ipl_ruko'): ?>

    <?php
        $alertGroups = collect();
        if (isset($alerts) && $alerts->isNotEmpty()) {
            $alertGroups = $alerts->groupBy(function($a) {
                if ($a->status_ipl === 'mati') return 'mati';
                if ($a->status_ipl === 'segera_habis') return 'segera_habis';
                if ($a->status_ipl === 'jatuh_tempo') return 'jatuh_tempo';
                return 'other';
            });
        }
    ?>
    <?php if(isset($alerts) && $alerts->isNotEmpty()): ?>
    <div style="display:flex;gap:8px;flex-wrap:wrap;">
        <?php if(isset($alertGroups['mati'])): ?>
        <div style="flex:1;min-width:260px;">
            <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-bold" style="color:#ef4444;"><?php echo e($alertGroups['mati']->count()); ?> IPL Ruko Lewat Jatuh Tempo</div>
                    <div class="text-xs mt-1" style="color:var(--text-secondary);"><?php echo e($alertGroups['mati']->count()); ?> IPL Ruko lewat jatuh tempo.</div>
                </div>
                <button type="button" onclick="setFilter('mati')" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(239,68,68,0.12);color:#ef4444;border:1px solid rgba(239,68,68,0.2);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
            </div>
        </div>
        <?php endif; ?>
        <?php if(isset($alertGroups['segera_habis'])): ?>
        <div style="flex:1;min-width:260px;">
            <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-bold" style="color:#f59e0b;"><?php echo e($alertGroups['segera_habis']->count()); ?> IPL Ruko Segera Jatuh Tempo</div>
                    <div class="text-xs mt-1" style="color:var(--text-secondary);"><?php echo e($alertGroups['segera_habis']->count()); ?> IPL Ruko akan segera jatuh tempo (≤3 hari).</div>
                </div>
                <button type="button" onclick="setFilter('segera_habis')" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(245,158,11,0.12);color:#f59e0b;border:1px solid rgba(245,158,11,0.2);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
            </div>
        </div>
        <?php endif; ?>
        <?php if(isset($alertGroups['jatuh_tempo'])): ?>
        <div style="flex:1;min-width:260px;">
            <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(249,115,22,0.08);border:1px solid rgba(249,115,22,0.2);">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f97316;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-bold" style="color:#f97316;"><?php echo e($alertGroups['jatuh_tempo']->count()); ?> IPL Ruko Jatuh Tempo</div>
                    <div class="text-xs mt-1" style="color:var(--text-secondary);"><?php echo e($alertGroups['jatuh_tempo']->count()); ?> IPL Ruko akan jatuh tempo (≤7 hari).</div>
                </div>
                <button type="button" onclick="setFilter('jatuh_tempo')" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(249,115,22,0.12);color:#f97316;border:1px solid rgba(249,115,22,0.2);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:none rgba(124,58,237,0.25);">
                <svg class="w-[18px]" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xl font-gaming font-bold" style="color:var(--text-primary);"><?php echo e($stats['total']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-primary);">Total IPL Ruko</div>
                <div class="text-xs mt-0.5 leading-tight" style="color:var(--text-muted);"><?php echo e($stats['total']); ?> tagihan</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:none rgba(16,185,129,0.2);">
                <svg class="w-[18px]" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#34d399;"><?php echo e($stats['aktif']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Aktif</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(249,115,22,0.15);box-shadow:none rgba(249,115,22,0.2);">
                <svg class="w-[18px]" style="color:#fb923c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#fb923c;"><?php echo e($stats['jatuh_tempo']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Jatuh Tempo</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(245,158,11,0.15);box-shadow:none rgba(245,158,11,0.2);">
                <svg class="w-[18px]" style="color:#f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#f59e0b;"><?php echo e($stats['segera_habis']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Segera Habis</div>
                
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(239,68,68,0.15);box-shadow:none rgba(239,68,68,0.2);">
                <svg class="w-[18px]" style="color:#ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xl font-gaming font-bold" style="color:#ef4444;"><?php echo e($stats['mati']); ?></div>
                <div class="text-[11px] font-semibold mt-0.5" style="color:var(--text-secondary);">Mati</div>
                
            </div>
        </div>
    </div>
    <?php elseif($jenis !== 'listrik'): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(124,58,237,0.15);box-shadow:0 0 16px rgba(124,58,237,0.25);">
                <svg class="w-6 h-6" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.1 0-2 .9-2 2H9a3 3 0 013-3V7a2 2 0 012 2h-2zm0 8a3 3 0 01-3-3h1a2 2 0 002 2v1zm2-4h4v2h-4v-2zm-8 0H2v2h4v-2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-3xl font-gaming font-bold" style="color:var(--text-primary);"><?php echo e($stats['total']); ?></div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Total Tagihan</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);"><?php echo e($stats['total']); ?> tagihan</div>
            </div>
        </div>
        <div class="gaming-card p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                style="background:rgba(16,185,129,0.15);box-shadow:0 0 16px rgba(16,185,129,0.2);">
                <svg class="w-6 h-6" style="color:#34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-3xl font-gaming font-bold" style="color:#34d399;"><?php echo e($stats['aktif']); ?></div>
                <div class="text-sm font-semibold mt-0.5" style="color:var(--text-secondary);">Sudah Dibayar</div>
                <div class="text-xs mt-0.5" style="color:var(--text-muted);">Tagihan lunas</div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if(!in_array($jenis, ['listrik', 'internet', 'aset_digital', 'ipl_ruko']) && $alertItems->isNotEmpty()): ?>
        <?php
            $today = now()->startOfDay();
            $redItems = collect();
            $yellowItems = collect();
            $dueField = $jenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
            foreach ($alertItems as $a) {
                $dueDate = $a->{$dueField};
                if (!$dueDate) continue;
                $dueStart = $dueDate->copy()->startOfDay();
                if ($dueStart->lte($today)) {
                    $redItems->push($a);
                } elseif ($dueStart->lte($today->copy()->addDays(3))) {
                    $yellowItems->push($a);
                }
            }
        ?>
        <?php if($redItems->isNotEmpty() || $yellowItems->isNotEmpty()): ?>
        <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <?php if($redItems->isNotEmpty()): ?>
            <div style="flex:1;min-width:280px;">
                <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.25);">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#ef4444;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-bold" style="color:#ef4444;"><?php echo e($redItems->count()); ?> Lewat Jatuh Tempo</div>
                        <div class="text-xs mt-1" style="color:var(--text-secondary);"><?php echo e($redItems->count()); ?> tagihan lewat jatuh tempo.</div>
                    </div>
                    <button type="button" onclick="showAlertPopup('danger')" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(239,68,68,0.15);color:#ef4444;border:1px solid rgba(239,68,68,0.25);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
                </div>
            </div>
            <?php endif; ?>
            <?php if($yellowItems->isNotEmpty()): ?>
            <div style="flex:1;min-width:280px;">
                <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.25);">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:#f59e0b;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-bold" style="color:#f59e0b;"><?php echo e($yellowItems->count()); ?> Segera Jatuh Tempo</div>
                        <div class="text-xs mt-1" style="color:var(--text-secondary);"><?php echo e($yellowItems->count()); ?> tagihan jatuh tempo dalam 3 hari.</div>
                    </div>
                    <button type="button" onclick="showAlertPopup('warning')" style="flex-shrink:0;padding:6px 12px;border-radius:8px;font-size:11px;font-weight:600;background:rgba(245,158,11,0.15);color:#f59e0b;border:1px solid rgba(245,158,11,0.25);cursor:pointer;white-space:nowrap;">Lihat Detail</button>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>

    
    <div id="alert-overlay" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);" onclick="if(event.target===this)closeAlertPopup()">
        <div class="w-full max-w-[460px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);" id="alert-popup-title">Detail Tagihan</h3>
                <button type="button" onclick="closeAlertPopup()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1" id="alert-popup-body"></div>
            <div class="px-6 py-4 flex-shrink-0 flex justify-end items-center" style="border-top:1px solid var(--border-color);">
                <button type="button" onclick="closeAlertPopup()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
            </div>
        </div>
    </div>

    
    <?php if($jenis === 'listrik' && $tokenAlert): ?>
    <div class="flex items-start gap-3 px-5 py-3.5 rounded-2xl" style="margin-bottom:8px;background:<?php echo e($tokenAlert['level'] === 'danger' ? 'rgba(239,68,68,0.1)' : ($tokenAlert['level'] === 'warning' ? 'rgba(245,158,11,0.1)' : 'rgba(59,130,246,0.1)')); ?>;border:1px solid <?php echo e($tokenAlert['level'] === 'danger' ? 'rgba(239,68,68,0.25)' : ($tokenAlert['level'] === 'warning' ? 'rgba(245,158,11,0.25)' : 'rgba(59,130,246,0.25)')); ?>;">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" style="color:<?php echo e($tokenAlert['level'] === 'danger' ? '#ef4444' : ($tokenAlert['level'] === 'warning' ? '#f59e0b' : '#3b82f6')); ?>;" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
        </svg>
        <div>
            <div class="text-sm font-bold" style="color:<?php echo e($tokenAlert['level'] === 'danger' ? '#ef4444' : ($tokenAlert['level'] === 'warning' ? '#f59e0b' : '#3b82f6')); ?>;">Token Listrik</div>
            <div class="text-sm mt-1" style="color:var(--text-secondary);"><?php echo e($tokenAlert['message']); ?></div>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if($jenis !== 'listrik'): ?>
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Pembayaran <?php echo e($jenisLabels[$jenis]); ?></div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">
                    <?php if($jenis === 'internet'): ?>
                        Data WiFi.
                    <?php else: ?>
                        Data tagihan <?php echo e($jenisLabels[$jenis]); ?>.
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <?php if(auth()->user()->role !== 'gm'): ?>
                <button type="button" onclick="openCreateModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Tagihan
                </button>
                <?php endif; ?>
                <?php if($jenis === 'ipl_ruko'): ?>
                <button type="button" onclick="openBulkIplModal()" class="btn btn-secondary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Generate 1 Tahun
                </button>
                <?php endif; ?>
            </div>
        </div>
        <div class="px-5 py-2.5 flex flex-wrap items-center gap-3" style="border-bottom:1px solid var(--border-color);">
            <div class="relative flex-1 min-w-0 max-w-full sm:min-w-[200px] sm:max-w-[260px]">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="search-payment" placeholder="Cari..." oninput="filterTable()"
                    class="w-full pl-9 pr-3 py-1.5 rounded-lg text-xs"
                    style="background:var(--bg-surface);border:1px solid var(--border-color);color:var(--text-primary);outline:none;">
            </div>
            <div class="flex items-center gap-2" style="margin-left:auto;">
                <a href="<?php echo e(route('admin.export', ['type' => 'pembayaran', 'jenis' => $jenis, 'filter' => 'all'])); ?>" class="btn btn-secondary btn-sm inline-flex items-center gap-1.5">Download Excel</a>
                <div class="filter-dropdown-wrap" style="position:relative;">
                <button type="button" onclick="toggleFilterMenu(event)" class="filter-btn"
                    style="display:flex;align-items:center;gap:6px;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid var(--border-color);background:var(--bg-card);color:var(--text-primary);outline:none;white-space:nowrap;">
                    <span id="filter-label">Semua Status</span>
                    <svg class="w-3.5 h-3.5" style="color:var(--text-muted);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div id="filter-menu" class="filter-menu" style="display:none;position:absolute;right:0;top:100%;z-index:40;min-width:150px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                    <button type="button" data-value="all" onclick="setFilter('all')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Semua Status</button>
                    <?php if($jenis === 'internet'): ?>
                    <button type="button" data-value="aktif" onclick="setFilter('aktif')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" data-value="jatuh_tempo" onclick="setFilter('jatuh_tempo')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Jatuh Tempo</button>
                    <button type="button" data-value="segera_habis" onclick="setFilter('segera_habis')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Segera Habis</button>
                    <button type="button" data-value="mati" onclick="setFilter('mati')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Mati</button>
                    <?php elseif($jenis === 'aset_digital'): ?>
                    <button type="button" data-value="aktif" onclick="setFilter('aktif')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" data-value="jatuh_tempo" onclick="setFilter('jatuh_tempo')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Jatuh Tempo</button>
                    <button type="button" data-value="segera_habis" onclick="setFilter('segera_habis')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Segera Habis</button>
                    <button type="button" data-value="mati" onclick="setFilter('mati')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Mati</button>
                    <?php elseif($jenis === 'ipl_ruko'): ?>
                    <button type="button" data-value="aktif" onclick="setFilter('aktif')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Aktif</button>
                    <button type="button" data-value="jatuh_tempo" onclick="setFilter('jatuh_tempo')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Jatuh Tempo</button>
                    <button type="button" data-value="segera_habis" onclick="setFilter('segera_habis')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Segera Habis</button>
                    <button type="button" data-value="mati" onclick="setFilter('mati')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Mati</button>
                    <?php else: ?>
                    <button type="button" data-value="jatuh_tempo" onclick="setFilter('jatuh_tempo')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Jatuh Tempo</button>
                    <?php endif; ?>
                    <button type="button" data-value="lunas" onclick="setFilter('lunas')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Lunas</button>
                    <button type="button" data-value="pending" onclick="setFilter('pending')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Menunggu</button>
                    <button type="button" data-value="rejected" onclick="setFilter('rejected')" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Ditolak</button>
                </div>
            </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="gaming-table min-w-[900px]" id="payment-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <?php if($jenis === 'internet'): ?>
                            <th>Nama Internet</th>
                            <th class="hidden md:table-cell">Provider</th>
                            <th class="hidden md:table-cell">PIC</th>
                            <th class="hidden lg:table-cell">Jabatan</th>
                            <th class="hidden md:table-cell">Masa Tenggang</th>
                            <th style="color:var(--text-muted);font-size:0.65rem;">Hari</th>
                            <th class="hidden md:table-cell">Biaya</th>
                        <?php else: ?>
                            <th><?php echo e($jenis === 'aset_digital' ? 'Nama Aset' : 'Periode'); ?></th>
                            <th class="hidden md:table-cell">Tagihan</th>
                            <th>Jatuh Tempo</th>
                            <?php if(in_array($jenis, ['aset_digital', 'ipl_ruko'])): ?>
                            <th style="color:var(--text-muted);font-size:0.65rem;">Hari</th>
                            <?php endif; ?>
                            <th>Nominal</th>
                        <?php endif; ?>
                        <th>Status</th>
                            <th class="hidden md:table-cell">Tgl Bayar</th>
                            <?php if(auth()->user()->role !== 'gm'): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="payment-tbody">
                    <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $itemId = $item->id;
                        if ($jenis === 'internet') {
                            $statusInternet = $item->status_internet;
                            $badgeClass = match($statusInternet) {
                                'lunas' => 'badge-green',
                                'pending' => 'badge-blue',
                                'rejected' => 'badge-red',
                                'aktif' => 'badge-green',
                                'jatuh_tempo' => 'badge-orange',
                                'segera_habis' => 'badge-yellow',
                                'mati' => 'badge-red',
                                default => 'badge-red',
                            };
                            $badgeLabel = match($statusInternet) {
                                'lunas' => 'Lunas',
                                'pending' => 'Menunggu',
                                'rejected' => 'Ditolak',
                                'aktif' => 'Aktif',
                                'jatuh_tempo' => 'Jatuh Tempo',
                                'segera_habis' => 'Segera Habis',
                                'mati' => 'Mati',
                                default => 'Nonaktif',
                            };
                            $dataStatus = $statusInternet;
                        } elseif ($jenis === 'aset_digital') {
                            $statusDigital = $item->status_digital;
                            $badgeClass = match($statusDigital) {
                                'lunas' => 'badge-green',
                                'pending' => 'badge-blue',
                                'rejected' => 'badge-red',
                                'aktif' => 'badge-green',
                                'jatuh_tempo' => 'badge-orange',
                                'segera_habis' => 'badge-yellow',
                                'mati' => 'badge-red',
                                default => 'badge-red',
                            };
                            $badgeLabel = match($statusDigital) {
                                'lunas' => 'Lunas',
                                'pending' => 'Menunggu',
                                'rejected' => 'Ditolak',
                                'aktif' => 'Aktif',
                                'jatuh_tempo' => 'Jatuh Tempo',
                                'segera_habis' => 'Segera Habis',
                                'mati' => 'Mati',
                                default => 'Nonaktif',
                            };
                            $dataStatus = $statusDigital;
                        } elseif ($jenis === 'ipl_ruko') {
                            $statusIpl = $item->status_ipl;
                            $badgeClass = match($statusIpl) {
                                'lunas' => 'badge-green',
                                'pending' => 'badge-blue',
                                'rejected' => 'badge-red',
                                'aktif' => 'badge-green',
                                'jatuh_tempo' => 'badge-orange',
                                'segera_habis' => 'badge-yellow',
                                'mati' => 'badge-red',
                                default => 'badge-red',
                            };
                            $badgeLabel = match($statusIpl) {
                                'lunas' => 'Lunas',
                                'pending' => 'Menunggu',
                                'rejected' => 'Ditolak',
                                'aktif' => 'Aktif',
                                'jatuh_tempo' => 'Jatuh Tempo',
                                'segera_habis' => 'Segera Habis',
                                'mati' => 'Mati',
                                default => 'Nonaktif',
                            };
                            $dataStatus = $statusIpl;
                        } else {
                            $dueDate = $item->jatuh_tempo;
                            $today = now()->startOfDay();
                            if ($item->status === 'lunas') {
                                $badgeClass = 'badge-green';
                                $badgeLabel = 'Lunas';
                            } elseif ($item->status === 'pending') {
                                $badgeClass = 'badge-blue';
                                $badgeLabel = 'Menunggu';
                            } elseif ($item->status === 'rejected') {
                                $badgeClass = 'badge-red';
                                $badgeLabel = 'Ditolak';
                            } elseif ($dueDate) {
                                $dueStart = $dueDate->copy()->startOfDay();
                                if ($dueStart->lt($today)) {
                                    $badgeClass = 'badge-red';
                                    $badgeLabel = 'Terlambat';
                                } elseif ($dueStart->lte($today->copy()->addDays(3))) {
                                    $sisa = $today->diffInDays($dueStart);
                                    $badgeClass = 'badge-yellow';
                                    $badgeLabel = $sisa === 0 ? 'Hari Ini' : 'H - ' . $sisa . ' Hari';
                                } else {
                                    $badgeClass = 'badge-yellow';
                                    $badgeLabel = 'Jatuh Tempo';
                                }
                            } else {
                                $badgeClass = 'badge-yellow';
                                $badgeLabel = 'Jatuh Tempo';
                            }
                            $dataStatus = $item->status;
                        }
                    ?>
                    <tr data-status="<?php echo e($dataStatus); ?>">
                        <td style="color:var(--text-muted);"><?php echo e($loop->iteration); ?></td>
                        <?php if($jenis === 'internet'): ?>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($item->nama_internet); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e($item->provider); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e($item->pic); ?></td>
                        <td class="hidden lg:table-cell" style="color:var(--text-muted);"><?php echo e($item->jabatan); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e($item->masa_tenggang?->format('d/m/Y')); ?></td>
                        <td style="color:var(--text-muted);font-size:0.7rem;"><?php echo e($item->hari_internet); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--text-primary);font-weight:600;">Rp <?php echo e(number_format($item->biaya, 0, ',', '.')); ?></td>
                        <?php else: ?>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($item->periode); ?></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e($item->tanggal_tagihan?->format('d/m/Y')); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($item->jatuh_tempo?->format('d/m/Y')); ?></td>
                        <?php if($jenis === 'aset_digital'): ?>
                        <td style="color:var(--text-muted);font-size:0.7rem;"><?php echo e($item->hari_digital); ?></td>
                        <?php elseif($jenis === 'ipl_ruko'): ?>
                        <td style="color:var(--text-muted);font-size:0.7rem;"><?php echo e($item->hari_ipl); ?></td>
                        <?php endif; ?>
                        <td style="color:var(--text-primary);font-weight:600;">Rp <?php echo e(number_format($item->nominal, 0, ',', '.')); ?></td>
                        <?php endif; ?>
                        <td><span class="badge <?php echo e($badgeClass); ?>"><?php echo e($badgeLabel); ?></span></td>
                        <td class="hidden md:table-cell" style="color:var(--text-muted);"><?php echo e(($item->tanggal_bayar) ? $item->tanggal_bayar->format('d/m/Y') : '-'); ?></td>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showDetail(<?php echo e($itemId); ?>)" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, <?php echo e($itemId); ?>)" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-<?php echo e($itemId); ?>" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showDetail(<?php echo e($itemId); ?>)" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <button type="button" onclick="openEditModal(<?php echo e($itemId); ?>)" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Edit</button>
                                        <form method="POST" action="<?php echo e(route('admin.pembayaran.destroy', $itemId)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus data ini?" style="margin:0;">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <input type="hidden" name="jenis" value="<?php echo e($jenis); ?>">
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data <?php echo e($jenisLabels[$jenis]); ?>.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if($jenis === 'internet'): ?>
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between flex-wrap gap-3" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Pengecekan Usage Internet</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">
                    Lakukan pengecekan usage internet per ruangan setiap hari.
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <form method="GET" action="<?php echo e(route('admin.pembayaran.index')); ?>" class="flex items-center gap-2">
                    <input type="hidden" name="jenis" value="internet">
                    <input type="month" name="internet_usage_date" value="<?php echo e($internetUsageDate); ?>" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                </form>
                <?php if(auth()->user()->role !== 'gm'): ?>
                <button type="button" onclick="openInternetUsageModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Input Usage
                </button>
                <?php endif; ?>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Ruangan</th>
                        <th>Hari</th>
                        <th>Tanggal</th>
                        <th>Penggunaan Wifi/Hari</th>
                        <th>Penggunaan Ethernet/Hari</th>
                        <th>Pengecek</th>
                        <th>Keterangan</th>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $internetUsages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-muted);"><?php echo e($i + 1); ?></td>
                        <td style="color:var(--text-primary);font-weight:500;"><?php echo e($u->ruangan); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($u->hari); ?></td>
                        <td style="color:var(--text-primary);"><?php echo e($u->tanggal->format('d M Y')); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e(number_format($u->penggunaan_wifi, 2)); ?> GB</td>
                        <td style="color:var(--text-muted);"><?php echo e(number_format($u->penggunaan_ethernet, 2)); ?> GB</td>
                        <td style="color:var(--text-primary);"><?php echo e($u->checker?->name ?? '-'); ?></td>
                        <td style="color:var(--text-muted);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo e($u->keterangan ?: '-'); ?></td>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <div class="flex items-center gap-1">
                                <button type="button" onclick="showInternetUsageDetail(<?php echo e($u->id); ?>)" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:4px;padding:3px 6px;font-size:0.7rem;">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </button>
                                <div class="dropdown-wrap" style="position:relative;">
                                    <button type="button" onclick="toggleDropdown(this, <?php echo e($u->id); ?>)" class="btn btn-secondary btn-sm" style="padding:3px 6px;font-size:0.7rem;line-height:1;">⋮</button>
                                    <div id="dropdown-<?php echo e($u->id); ?>" class="dropdown-menu" style="display:none;position:absolute;top:100%;right:0;z-index:99999;min-width:130px;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:10px;padding:4px;box-shadow:0 8px 24px rgba(0,0,0,0.15);margin-top:4px;">
                                        <button type="button" onclick="showInternetUsageDetail(<?php echo e($u->id); ?>)" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:var(--text-primary);border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Detail</button>
                                        <form method="POST" action="<?php echo e(route('admin.pembayaran.internet-usage.destroy', $u->id)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus data usage ini?" style="margin:0;">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit" style="display:block;width:100%;text-align:left;padding:7px 12px;border:none;background:none;font-size:13px;color:#ef4444;border-radius:6px;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada data usage internet.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    
    <?php if($jenis === 'listrik'): ?>
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between flex-wrap gap-3" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Riwayat Top Up Token</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">Riwayat pembelian/pengisian token listrik.</div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex items-center gap-1" style="border:1px solid var(--border-color);border-radius:8px;padding:2px;background:var(--bg-card);">
                    <button type="button" onclick="setTopupRange('harian')" class="topup-range-btn" data-range="harian" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:<?php echo e(($topupRange ?? 'bulanan') === 'harian' ? 'rgba(124,58,237,0.2)' : 'none'); ?>;color:<?php echo e(($topupRange ?? 'bulanan') === 'harian' ? '#a78bfa' : 'var(--text-muted)'); ?>;">Harian</button>
                    <button type="button" onclick="setTopupRange('mingguan')" class="topup-range-btn" data-range="mingguan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:<?php echo e(($topupRange ?? 'bulanan') === 'mingguan' ? 'rgba(124,58,237,0.2)' : 'none'); ?>;color:<?php echo e(($topupRange ?? 'bulanan') === 'mingguan' ? '#a78bfa' : 'var(--text-muted)'); ?>;">Mingguan</button>
                    <button type="button" onclick="setTopupRange('bulanan')" class="topup-range-btn" data-range="bulanan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:<?php echo e(($topupRange ?? 'bulanan') === 'bulanan' ? 'rgba(124,58,237,0.2)' : 'none'); ?>;color:<?php echo e(($topupRange ?? 'bulanan') === 'bulanan' ? '#a78bfa' : 'var(--text-muted)'); ?>;">Bulanan</button>
                </div>
                <a href="<?php echo e(route('admin.export', ['type' => 'token-topups', 'range' => $topupRange ?? 'bulanan'])); ?>" class="btn btn-secondary btn-sm" title="Download Excel Riwayat Top Up">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Excel
                </a>
                <?php if(auth()->user()->role !== 'gm'): ?>
                <button type="button" onclick="openTopupModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Top Up Baru
                </button>
                <?php endif; ?>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Bayar</th>
                        <th>Periode</th>
                        <th>Jumlah KWH</th>
                        <th>Nominal</th>
                        <th>Oleh</th>
                        <th>Catatan</th>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $topupHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td style="color:var(--text-muted);"><?php echo e($i + 1); ?></td>
                        <td style="color:var(--text-primary);"><?php echo e($t->payment_date->format('d M Y')); ?></td>
                        <td style="color:var(--text-muted);"><?php echo e($t->period); ?></td>
                        <td style="font-weight:600;color:var(--text-primary);"><?php echo e(number_format($t->amount_kwh, 0)); ?> KWH</td>
                        <td style="color:var(--text-primary);">Rp <?php echo e(number_format($t->nominal, 0)); ?></td>
                        <td style="color:var(--text-primary);"><?php echo e($t->creator?->name ?? '-'); ?></td>
                        <td style="color:var(--text-muted);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo e($t->notes ?: 'Tidak ada catatan'); ?></td>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <form method="POST" action="<?php echo e(route('admin.pembayaran.token-topup.destroy', $t->id)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus data top up ini?" style="margin:0;">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" style="background:none;border:none;color:#ef4444;cursor:pointer;font-size:13px;padding:2px 6px;">Hapus</button>
                            </form>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada riwayat top up token.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php if($jenis === 'listrik'): ?>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(124,58,237,0.12);">
                <svg class="w-5 h-5" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <div class="text-xs font-semibold" style="color:var(--text-muted);">Top Up Terakhir</div>
                <div class="text-lg font-gaming font-bold" style="color:var(--text-primary);"><?php echo e($latestPayment ? number_format($latestPayment->amount_kwh, 0) : '7.000'); ?> KWH</div>
                <div class="text-xs font-medium" style="color:var(--text-muted);"><?php echo e($latestPayment && $latestPayment->nominal ? 'Rp '.number_format($latestPayment->nominal, 0) : ''); ?></div>
                <div class="text-xs" style="color:var(--text-muted);"><?php echo e($latestPayment ? $latestPayment->payment_date->format('d M Y') : '-'); ?> · <?php echo e($latestPayment?->creator?->name ?? '-'); ?></div>
            </div>
            <?php if(auth()->user()->role !== 'gm'): ?>
            <button type="button" onclick="openTopupModal()" class="btn btn-primary btn-xs flex-shrink-0" style="font-size:11px;padding:4px 10px;">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Top Up
            </button>
            <?php endif; ?>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(59,130,246,0.12);">
                <svg class="w-5 h-5" style="color:#60a5fa;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xs font-semibold" style="color:var(--text-muted);">Terpakai</div>
                <div class="text-lg font-gaming font-bold" style="color:var(--text-primary);"><?php echo e(number_format($usedKwh, 1)); ?> KWH</div>
            </div>
        </div>
        <div class="gaming-card p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:<?php echo e($latestReading && $latestReading->remaining_kwh < 500 ? 'rgba(239,68,68,0.12)' : ($latestReading && $latestReading->remaining_kwh < 1000 ? 'rgba(245,158,11,0.12)' : 'rgba(16,185,129,0.12)')); ?>;">
                <svg class="w-5 h-5" style="color:<?php echo e($latestReading && $latestReading->remaining_kwh < 500 ? '#ef4444' : ($latestReading && $latestReading->remaining_kwh < 1000 ? '#f59e0b' : '#34d399')); ?>;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01"/>
                </svg>
            </div>
            <div class="min-w-0">
                <div class="text-xs font-semibold" style="color:var(--text-muted);">Sisa Token</div>
                <div class="text-lg font-gaming font-bold" style="color:<?php echo e($latestReading && $latestReading->remaining_kwh < 500 ? '#ef4444' : ($latestReading && $latestReading->remaining_kwh < 1000 ? '#f59e0b' : 'var(--text-primary)')); ?>;">
                    <?php echo e($latestReading ? number_format($latestReading->remaining_kwh, 1) : '0'); ?> KWH
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    
    <div class="gaming-card" style="overflow:visible;">
        <div class="px-5 py-4 flex items-center justify-between flex-wrap gap-3" style="border-bottom:1px solid var(--border-color);">
            <div>
                <div style="font-weight:600;font-size:15px;color:var(--text-primary);">Pengecekan Token Listrik</div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;font-weight:400;">
                    Lakukan pengecekan sisa KWH token setiap minggu. Kapasitas token: <?php echo e(number_format($capacityKwh, 0)); ?> KWH/bulan.
                </div>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex items-center gap-1" style="border:1px solid var(--border-color);border-radius:8px;padding:2px;background:var(--bg-card);">
                    <button type="button" onclick="setReadingRange('harian')" class="reading-range-btn" data-range="harian" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:<?php echo e(($readingRange ?? 'bulanan') === 'harian' ? 'rgba(59,130,246,0.2)' : 'none'); ?>;color:<?php echo e(($readingRange ?? 'bulanan') === 'harian' ? '#60a5fa' : 'var(--text-muted)'); ?>;">Harian</button>
                    <button type="button" onclick="setReadingRange('mingguan')" class="reading-range-btn" data-range="mingguan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:<?php echo e(($readingRange ?? 'bulanan') === 'mingguan' ? 'rgba(59,130,246,0.2)' : 'none'); ?>;color:<?php echo e(($readingRange ?? 'bulanan') === 'mingguan' ? '#60a5fa' : 'var(--text-muted)'); ?>;">Mingguan</button>
                    <button type="button" onclick="setReadingRange('bulanan')" class="reading-range-btn" data-range="bulanan" style="padding:4px 10px;border:none;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;background:<?php echo e(($readingRange ?? 'bulanan') === 'bulanan' ? 'rgba(59,130,246,0.2)' : 'none'); ?>;color:<?php echo e(($readingRange ?? 'bulanan') === 'bulanan' ? '#60a5fa' : 'var(--text-muted)'); ?>;">Bulanan</button>
                </div>
                <form method="GET" action="<?php echo e(route('admin.pembayaran.index')); ?>" class="flex items-center gap-2">
                    <input type="hidden" name="jenis" value="listrik">
                    <input type="month" name="token_month" value="<?php echo e($tokenMonth); ?>" class="gaming-input" style="padding:6px 10px;font-size:13px;" onchange="this.form.submit()">
                </form>
                <a href="<?php echo e(route('admin.export', ['type' => 'token-readings', 'range' => $readingRange ?? 'bulanan', 'token_month' => $tokenMonth])); ?>" class="btn btn-secondary btn-sm" title="Download Excel Pengecekan Token">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Excel
                </a>
                <?php if(auth()->user()->role !== 'gm'): ?>
                <button type="button" onclick="openTokenModal()" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Input Pengecekan
                </button>
                <?php endif; ?>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="gaming-table w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Check</th>
                        <th>Sisa KWH</th>
                        <th>Terpakai</th>
                        <th>Status</th>
                        <th>Pengecek</th>
                        <th>Catatan</th>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <th>Aksi</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tokenReadings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $statusMap = ['segera_isi' => ['#ef4444', 'Segera Isi Token'], 'warning' => ['#f97316', 'Warning'], 'perhatian' => ['#3b82f6', 'Perhatian'], 'aman' => ['#10b981', 'Aman']];
                        $statusColor = $statusMap[$r->status][0] ?? '#10b981';
                        $statusLabel = $statusMap[$r->status][1] ?? 'Aman';
                        $usedInReading = $capacityKwh - $r->remaining_kwh;
                    ?>
                    <tr>
                        <td style="color:var(--text-muted);"><?php echo e($i + 1); ?></td>
                        <td style="color:var(--text-primary);"><?php echo e($r->checked_date->format('d M Y')); ?></td>
                        <td style="font-weight:600;color:var(--text-primary);"><?php echo e($r->remaining_kwh); ?> KWH</td>
                        <td style="color:var(--text-muted);"><?php echo e(number_format($usedInReading, 0)); ?> KWH</td>
                        <td><span class="badge text-xs" style="background:<?php echo e($statusColor === '#10b981' ? 'rgba(16,185,129,0.15)' : ($statusColor === '#3b82f6' ? 'rgba(59,130,246,0.15)' : ($statusColor === '#f97316' ? 'rgba(249,115,22,0.15)' : 'rgba(239,68,68,0.15)'))); ?>;color:<?php echo e($statusColor); ?>;border:1px solid <?php echo e($statusColor === '#10b981' ? 'rgba(16,185,129,0.3)' : ($statusColor === '#3b82f6' ? 'rgba(59,130,246,0.3)' : ($statusColor === '#f97316' ? 'rgba(249,115,22,0.3)' : 'rgba(239,68,68,0.3)'))); ?>;"><?php echo e($statusLabel); ?></span></td>
                        <td style="color:var(--text-primary);"><?php echo e($r->checker->name); ?></td>
                        <td style="color:var(--text-muted);max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo e($r->notes ?: 'Tidak ada catatan'); ?></td>
                        <?php if(auth()->user()->role !== 'gm'): ?>
                        <td>
                            <div class="flex items-center gap-1">
                                <form method="POST" action="<?php echo e(route('admin.pembayaran.token-reading.destroy', $r->id)); ?>" onsubmit="confirmSubmit(event, this)" data-confirm="Hapus data pengecekan ini?" style="margin:0;">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" style="background:none;border:none;color:#ef4444;cursor:pointer;font-size:13px;padding:2px 6px;">Hapus</button>
                                </form>
                                <a href="<?php echo e(route('admin.export', ['type' => 'token-readings'])); ?>" class="btn btn-secondary btn-sm" style="padding:4px 8px;line-height:1;" title="Download Excel">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
                            </div>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" style="text-align:center;padding:2rem;color:var(--text-muted);">Belum ada pengecekan token listrik.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php endif; ?>

</div>

<?php if($jenis === 'listrik'): ?>

<div id="token-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Input Pengecekan Token</h3>
            <button type="button" onclick="closeTokenModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1">
            <form method="POST" action="<?php echo e(route('admin.pembayaran.token-reading.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div class="field-group">
                        <label class="gaming-label">Sisa KWH <span class="field-req">*</span></label>
                        <input type="number" name="remaining_kwh" id="f-remaining_kwh" required step="0.01" min="0" max="9999" placeholder="Contoh: 342.5" class="gaming-input">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Input sisa KWH yang tertera di meteran.</div>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Tanggal Pengecekan <span class="field-req">*</span></label>
                        <input type="date" name="checked_date" id="f-checked_date" required value="<?php echo e(date('Y-m-d')); ?>" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Pengecek <span class="field-req">*</span></label>
                        <select name="checked_by" id="f-checked_by" required class="gaming-input">
                            <option value="">Pilih pengecek</option>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($u->id); ?>" <?php echo e($u->id === auth()->id() ? 'selected' : ''); ?>><?php echo e($u->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Catatan</label>
                        <textarea name="notes" id="f-notes" rows="2" placeholder="Catatan (opsional)" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;">
                    <button type="button" onclick="closeTokenModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="topup-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Top Up Token Listrik</h3>
            <button type="button" onclick="closeTopupModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1">
            <form method="POST" action="<?php echo e(route('admin.pembayaran.token-topup.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div class="field-group">
                        <label class="gaming-label">Jumlah KWH <span class="field-req">*</span></label>
                        <input type="number" name="amount_kwh" id="f-amount_kwh" required step="0.01" min="1" placeholder="Contoh: 7000" class="gaming-input">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Masukkan jumlah KWH yang dibeli.</div>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Nominal (Rp) <span class="field-req">*</span></label>
                        <input type="number" name="nominal" id="f-nominal" required step="0.01" min="0" placeholder="Contoh: 1500000" class="gaming-input">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Masukkan nominal harga token.</div>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Tanggal Bayar <span class="field-req">*</span></label>
                        <input type="date" name="payment_date" id="f-payment_date" required value="<?php echo e(date('Y-m-d')); ?>" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Catatan</label>
                        <textarea name="notes" id="f-topup-notes" rows="2" placeholder="Catatan (opsional)" class="gaming-input" style="resize:vertical;"></textarea>
                    </div>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;">
                    <button type="button" onclick="closeTopupModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>


<div id="detail-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[460px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="detail-title">Detail</h3>
            <button type="button" onclick="closeDetail()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1" id="detail-body"></div>
        <div class="px-6 py-4 flex-shrink-0 flex items-center gap-2" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Tutup</button>
            <button type="button" id="detail-bayar-btn" onclick="markAsLunas()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="display:none;background:#10b981;color:#fff;border:none;cursor:pointer;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10b981'">Bayar / Lunaskan</button>
            <button type="button" id="detail-edit-btn" onclick="editFromDetail()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;" onmouseover="this.style.transform='translateY(-1px)'" onmouseout="this.style.transform=''">Edit</button>
        </div>
    </div>
</div>


<div id="payment-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[440px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">

        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);" id="modal-title">Tambah Tagihan</h3>
            <button type="button" onclick="closePaymentModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="px-6 py-5 overflow-y-auto flex-1">
            <form id="payment-form" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" id="form-method" value="POST">
                <input type="hidden" name="id" id="form-id" value="">
                <input type="hidden" name="jenis" id="f-jenis" value="<?php echo e($jenis); ?>">

                <div class="form-grid-2">
                    <?php if($jenis === 'internet'): ?>
                    <div class="field-group">
                        <label class="gaming-label">Nama Internet <span class="field-req">*</span></label>
                        <input type="text" name="nama_internet" id="f-nama_internet" required placeholder="Contoh: Wifi 1 (Kantor Utama)" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Provider <span class="field-req">*</span></label>
                        <select name="provider" id="f-provider" required class="gaming-input">
                            <option value="">Pilih provider</option>
                            <option value="Indosat">Indosat</option>
                            <option value="IndiHome">IndiHome</option>
                            <option value="First Media">First Media</option>
                            <option value="MyRepublic">MyRepublic</option>
                            <option value="Biznet">Biznet</option>
                            <option value="CBN">CBN</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">PIC <span class="field-req">*</span></label>
                        <input type="text" name="pic" id="f-pic" required placeholder="Nama penanggung jawab" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jabatan <span class="field-req">*</span></label>
                        <select name="jabatan" id="f-jabatan" required class="gaming-input gaming-select">
                            <option value="">Pilih Jabatan</option>
                            <option value="Chief Executive Officer (CEO)">Chief Executive Officer (CEO)</option>
                            <option value="General Manager (GM)">General Manager (GM)</option>
                            <option value="Head of Store">Head of Store</option>
                            <option value="Admin Master">Admin Master</option>
                            <option value="HR">HR</option>
                            <option value="Koordinator">Koordinator</option>
                            <option value="Karyawan">Karyawan</option>
                        </select>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Masa Tenggang <span class="field-req">*</span></label>
                        <input type="date" name="masa_tenggang" id="f-masa_tenggang" required class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Biaya <span class="field-req">*</span></label>
                        <input type="number" name="biaya" id="f-biaya" required placeholder="Contoh: Rp 300.000" class="gaming-input" min="0" step="0.01">
                    </div>
                    <?php else: ?>
                    <div class="field-group">
                        <label class="gaming-label"><?php echo e($jenis === 'aset_digital' ? 'Nama Aset' : 'Periode'); ?> <span class="field-req">*</span></label>
                        <input type="text" name="periode" id="f-periode" required placeholder="<?php echo e($jenis === 'aset_digital' ? 'Contoh: Adobe Photoshop' : 'Contoh: Januari 2026'); ?>" class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Nominal <span class="field-req">*</span></label>
                        <input type="number" name="nominal" id="f-nominal" required placeholder="Contoh: Rp 300.000" class="gaming-input" min="0" step="0.01">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Tagihan <span class="field-req">*</span></label>
                        <input type="date" name="tanggal_tagihan" id="f-tanggal_tagihan" required class="gaming-input">
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Jatuh Tempo <span class="field-req">*</span></label>
                        <input type="date" name="jatuh_tempo" id="f-jatuh_tempo" required class="gaming-input">
                    </div>
                    <?php endif; ?>
                    <div class="field-group">
                        <label class="gaming-label">Status <span class="field-req">*</span></label>
                        <select name="status" id="f-status" required class="gaming-input" onchange="toggleTanggalBayar()">
                            <option value="jatuh_tempo">Jatuh Tempo</option>
                            <option value="lunas">Lunas</option>
                            <option value="pending">Menunggu</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="field-group" id="f-tanggal_bayar-group">
                        <label class="gaming-label">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" id="f-tanggal_bayar" class="gaming-input">
                    </div>
                </div>

                <div class="form-footer">
                    <button type="button" onclick="closePaymentModal()" class="btn-form btn-form-batal">Batal</button>
                    <button type="submit" class="btn-form btn-form-simpan" id="form-submit-btn">Tambah</button>
                </div>
            </form>
        </div>

    </div>
</div>


<div id="bayar-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Bayar / Lunaskan</h3>
            <button type="button" onclick="closeBayarModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1">
            <div id="bayar-info" style="margin-bottom:16px;padding:12px;border-radius:10px;background:var(--bg-surface-2);border:1px solid var(--border-color);">
                <div id="bayar-name" style="font-weight:600;font-size:14px;color:var(--text-primary);"></div>
                <div id="bayar-nominal" style="font-size:13px;color:var(--text-muted);margin-top:4px;"></div>
                <div id="bayar-due" style="font-size:13px;color:var(--text-muted);margin-top:2px;"></div>
            </div>
            <form id="bayar-form" method="POST" action="<?php echo e(url('admin/pembayaran')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="jenis" value="<?php echo e($jenis); ?>">
                <input type="hidden" name="id" id="bayar-id" value="">
                <?php if($jenis === 'internet'): ?>
                <input type="hidden" name="nama_internet" id="bayar-nama_internet">
                <input type="hidden" name="provider" id="bayar-provider">
                <input type="hidden" name="pic" id="bayar-pic">
                <input type="hidden" name="jabatan" id="bayar-jabatan">
                <input type="hidden" name="masa_tenggang" id="bayar-masa_tenggang">
                <input type="hidden" name="biaya" id="bayar-biaya">
                <?php else: ?>
                <input type="hidden" name="periode" id="bayar-periode">
                <input type="hidden" name="tanggal_tagihan" id="bayar-tanggal_tagihan">
                <input type="hidden" name="jatuh_tempo" id="bayar-jatuh_tempo">
                <input type="hidden" name="nominal" id="bayar-nominal_val">
                <?php endif; ?>
                <input type="hidden" name="status" id="bayar-status" value="lunas">
                <div class="space-y-4">
                    <div class="field-group">
                        <label class="gaming-label">Tanggal Bayar <span class="field-req">*</span></label>
                        <input type="date" name="tanggal_bayar" id="bayar-tanggal_bayar" required value="<?php echo e(date('Y-m-d')); ?>" class="gaming-input">
                    </div>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;">
                    <button type="button" onclick="closeBayarModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#10b981,#34d399);color:#fff;border:none;box-shadow:0 4px 15px rgba(16,185,129,0.3);cursor:pointer;">Lunaskan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div id="bulk-ipl-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
    <div class="w-full max-w-[420px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <h3 class="text-base font-bold" style="color:var(--text-primary);">Generate Tagihan IPL 1 Tahun</h3>
            <button type="button" onclick="closeBulkIplModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <div class="px-6 py-5 overflow-y-auto flex-1">
            <form method="POST" action="<?php echo e(route('admin.pembayaran.ipl-bulk')); ?>">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div class="field-group">
                        <label class="gaming-label">Tahun <span class="field-req">*</span></label>
                        <input type="number" name="year" id="f-bulk-year" required min="2020" max="2035" value="<?php echo e(date('Y')); ?>" class="gaming-input">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Masukkan tahun tagihan yang akan digenerate (12 bulan).</div>
                    </div>
                    <div class="field-group">
                        <label class="gaming-label">Nominal per Bulan (Rp) <span class="field-req">*</span></label>
                        <input type="number" name="nominal" id="f-bulk-nominal" required min="0" placeholder="Contoh: 500000" class="gaming-input">
                        <div style="font-size:11px;color:var(--text-muted);margin-top:4px;">Nominal tagihan untuk setiap bulan. Seragam untuk 12 bulan.</div>
                    </div>
                </div>
                <div style="display:flex;gap:8px;justify-content:flex-end;margin-top:20px;padding-top:16px;border-top:1px solid var(--border-color);">
                    <button type="button" onclick="closeBulkIplModal()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-primary);border:1px solid var(--border-color);background:var(--bg-surface);cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='var(--bg-surface)'">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:linear-gradient(135deg,#6c5cff,#8b7bff);color:#fff;border:none;box-shadow:0 4px 15px rgba(108,92,255,0.3);cursor:pointer;" onclick="return confirm('Generate 12 tagihan IPL untuk tahun '+document.getElementById('f-bulk-year').value+'?')">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php if($jenis === 'internet'): ?>
    
    <div id="internet-usage-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);">
        <div class="w-full max-w-[480px] rounded-3xl shadow-2xl flex flex-col" style="max-height:65vh;background:var(--bg-surface);" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Input Usage Internet</h3>
                <button type="button" onclick="closeInternetUsageModal()" class="p-1.5 rounded-xl transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="px-6 py-5 overflow-y-auto flex-1">
                <form method="POST" action="<?php echo e(route('admin.pembayaran.internet-usage.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="space-y-4">
                        <div class="field-group">
                            <label class="gaming-label">Ruangan <span class="field-req">*</span></label>
                            <select name="ruangan" required class="gaming-input">
                                <option value="">Pilih ruangan</option>
                                <option value="Johen MLBB">Johen MLBB</option>
                                <option value="Johen PUBG">Johen PUBG</option>
                                <option value="Johen Free Fire">Johen Free Fire</option>
                                <option value="Johen Roblox">Johen Roblox</option>
                                <option value="Johen Valorant">Johen Valorant</option>
                                <option value="Johen E-Football">Johen E-Football</option>
                                <option value="Monkey PUBG">Monkey PUBG</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="field-group">
                                <label class="gaming-label">Hari <span class="field-req">*</span></label>
                                <select name="hari" required class="gaming-input">
                                    <option value="">Pilih hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div class="field-group">
                                <label class="gaming-label">Tanggal <span class="field-req">*</span></label>
                                <input type="date" name="tanggal" required value="<?php echo e(date('Y-m-d')); ?>" class="gaming-input">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="field-group">
                                <label class="gaming-label">Penggunaan Wifi (GB) <span class="field-req">*</span></label>
                                <input type="number" name="penggunaan_wifi" required step="0.01" min="0" placeholder="0.00" class="gaming-input">
                            </div>
                            <div class="field-group">
                                <label class="gaming-label">Penggunaan Ethernet (GB) <span class="field-req">*</span></label>
                                <input type="number" name="penggunaan_ethernet" required step="0.01" min="0" placeholder="0.00" class="gaming-input">
                            </div>
                        </div>
                        <div class="field-group">
                            <label class="gaming-label">Keterangan</label>
                            <textarea name="keterangan" rows="2" placeholder="Catatan (opsional)" class="gaming-input" style="resize:vertical;"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-3 pt-5 mt-5" style="border-top:1px solid var(--border-color);">
                        <button type="button" onclick="closeInternetUsageModal()" class="btn-form btn-form-batal">Batal</button>
                        <button type="submit" class="btn-form btn-form-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<script>
window.__paymentScript = 0;
console.log('[PAYMENT] Script loaded', window.__paymentScript);
window.__paymentScript = 1;
const paymentData = <?php echo json_encode($itemsJson, 15, 512) ?>;
const internetUsageData = <?php echo json_encode($internetUsagesJson, 15, 512) ?>;
const currentJenis = '<?php echo e($jenis); ?>';
const dueField = currentJenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
const jenisLabel = <?php echo json_encode($jenisLabels[$jenis] ?? $jenis, 15, 512) ?>;
let detailId = null;

function showAlertPopup(type) {
    const overlay = document.getElementById('alert-overlay');
    const title = document.getElementById('alert-popup-title');
    const body = document.getElementById('alert-popup-body');
    const today = new Date(); today.setHours(0,0,0,0);
    const color = type === 'danger' ? '#ef4444' : '#f59e0b';
    const bgColor = type === 'danger' ? 'rgba(239,68,68,0.1)' : 'rgba(245,158,11,0.1)';
    const borderColor = type === 'danger' ? 'rgba(239,68,68,0.25)' : 'rgba(245,158,11,0.25)';
    const label = currentJenis === 'internet' ? 'Masa Tenggang' : 'Jatuh Tempo';

    const items = paymentData.filter(function(item) {
        if (currentJenis === 'internet') {
            if (item.status_internet === 'lunas' || item.status_internet === 'pending' || item.status_internet === 'rejected') return false;
            if (!item[dueField]) return false;
            const due = new Date(item[dueField]); due.setHours(0,0,0,0);
            if (type === 'danger') return due <= today;
            const in3 = new Date(today); in3.setDate(in3.getDate() + 3);
            return due > today && due <= in3;
        }
        if (!item[dueField]) return false;
        if (item.status !== 'jatuh_tempo') return false;
        const due = new Date(item[dueField]); due.setHours(0,0,0,0);
        if (type === 'danger') return due <= today;
        const in3 = new Date(today); in3.setDate(in3.getDate() + 3);
        return due > today && due <= in3;
    });

    title.textContent = type === 'danger' ? 'Tagihan Lewat Jatuh Tempo' : 'Tagihan Segera Jatuh Tempo';
    title.style.color = color;
    body.innerHTML = '';

    if (items.length === 0) {
        body.innerHTML = '<div style="text-align:center;padding:20px;color:var(--text-muted);">Tidak ada data.</div>';
    } else {
        items.forEach(function(item, idx) {
            const due = new Date(item[dueField]); due.setHours(0,0,0,0);
            const diffDays = Math.round((today - due) / (1000 * 60 * 60 * 24));
            let badgeText = '';
            if (type === 'danger') {
                badgeText = diffDays === 0 ? 'Hari Ini' : diffDays + ' Hari Lewat';
            } else {
                badgeText = diffDays + ' Hari Lagi';
            }
            const name = currentJenis === 'internet' ? (item.nama_internet + ' (' + item.provider + ')') : item.periode;
            const nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.nominal);

            var row = document.createElement('div');
            row.setAttribute('data-id', item.id);
            row.style.cssText = 'display:flex;align-items:center;justify-content:space-between;padding:12px 0;cursor:pointer;transition:background 0.15s;' + (idx < items.length - 1 ? 'border-bottom:1px solid var(--border-color);' : '');
            row.onmouseover = function() { this.style.background = 'rgba(255,255,255,0.02)'; };
            row.onmouseout = function() { this.style.background = 'none'; };
            row.onclick = function() { goToEdit(item.id); };

            row.innerHTML =
                '<div class="min-w-0" style="flex:1;">' +
                    '<div style="font-weight:600;font-size:13px;color:var(--text-primary);">' + name + '</div>' +
                    '<div style="font-size:12px;color:var(--text-muted);margin-top:2px;">' + label + ': ' + badgeText + ' &middot; ' + nominal + '</div>' +
                '</div>' +
                '<div style="display:flex;align-items:center;gap:6px;flex-shrink:0;margin-left:12px;">' +
                    '<span style="padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600;background:' + (type === 'danger' ? 'rgba(239,68,68,0.15)' : 'rgba(245,158,11,0.15)') + ';color:' + color + ';border:1px solid ' + (type === 'danger' ? 'rgba(239,68,68,0.3)' : 'rgba(245,158,11,0.3)') + ';">' + badgeText + '</span>' +
                    '<svg style="width:14px;height:14px;color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>' +
                '</div>';

            body.appendChild(row);
        });
    }
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function goToEdit(id) {
    closeAlertPopup();
    openBayarModal(id);
}

function openBayarModal(id) {
    const i = paymentData.find(function(x) { return x.id === id; });
    if (!i) return;

    document.getElementById('bayar-id').value = i.id;
    document.getElementById('bayar-form').action = '<?php echo e(url("admin/pembayaran")); ?>/' + i.id;

    const name = currentJenis === 'internet' ? (i.nama_internet + ' (' + i.provider + ')') : i.periode;
    const nominalVal = i.nominal || i.biaya || 0;
    const nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(nominalVal);
    const dueField = currentJenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
    const dueLabel = currentJenis === 'internet' ? 'Masa Tenggang' : 'Jatuh Tempo';
    const dueDate = i[dueField] ? new Date(i[dueField]).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';

    document.getElementById('bayar-name').textContent = name;
    document.getElementById('bayar-nominal').textContent = 'Nominal: ' + nominal;
    document.getElementById('bayar-due').textContent = dueLabel + ': ' + dueDate;

    if (currentJenis === 'internet') {
        document.getElementById('bayar-nama_internet').value = i.nama_internet;
        document.getElementById('bayar-provider').value = i.provider;
        document.getElementById('bayar-pic').value = i.pic;
        document.getElementById('bayar-jabatan').value = i.jabatan;
        document.getElementById('bayar-masa_tenggang').value = i.masa_tenggang;
        document.getElementById('bayar-biaya').value = i.biaya;
    } else {
        document.getElementById('bayar-periode').value = i.periode;
        document.getElementById('bayar-tanggal_tagihan').value = i.tanggal_tagihan;
        document.getElementById('bayar-jatuh_tempo').value = i.jatuh_tempo;
        document.getElementById('bayar-nominal_val').value = i.nominal;
    }

    document.getElementById('bayar-tanggal_bayar').value = new Date().toISOString().split('T')[0];
    document.getElementById('bayar-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeBayarModal() {
    document.getElementById('bayar-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('bayar-modal')?.addEventListener('click', function(e) { if (e.target === this) closeBayarModal(); });

function closeAlertPopup() {
    document.getElementById('alert-overlay').style.display = 'none';
    document.body.style.overflow = '';
}

function toggleTanggalBayar() {
    const status = document.getElementById('f-status').value;
    const group = document.getElementById('f-tanggal_bayar-group');
    const input = document.getElementById('f-tanggal_bayar');
    if (status === 'lunas' || status === 'pending') {
        group.style.display = '';
        if (!input.value) {
            input.value = new Date().toISOString().split('T')[0];
        }
    } else {
        group.style.display = 'none';
        input.value = '';
    }
}

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Tagihan';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('payment-form').action = '<?php echo e(route('admin.pembayaran.store')); ?>';
    document.getElementById('form-submit-btn').textContent = 'Tambah';
    document.getElementById('payment-form').querySelectorAll('input, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method') el.value = '';
    });
    document.getElementById('f-status').value = 'jatuh_tempo';
    document.getElementById('f-tanggal_bayar-group').style.display = 'none';
    showPaymentModal();
}

function showDetail(id) {
    detailId = id;
    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    <?php if($jenis === 'internet'): ?>
    document.getElementById('detail-title').textContent = i.nama_internet;
    <?php else: ?>
    document.getElementById('detail-title').textContent = i.periode;
    <?php endif; ?>

    const statusComputedMap = {
        'lunas': { label: 'Lunas', bg: '#ecfdf5', text: '#059669', border: '#a7f3d0' },
        'pending': { label: 'Menunggu', bg: '#eff6ff', text: '#3b82f6', border: '#bfdbfe' },
        'rejected': { label: 'Ditolak', bg: '#fef2f2', text: '#dc2626', border: '#fecaca' },
        'aktif': { label: 'Aktif', bg: '#ecfdf5', text: '#059669', border: '#a7f3d0' },
        'jatuh_tempo': { label: 'Jatuh Tempo', bg: '#fff7ed', text: '#c2410c', border: '#fed7aa' },
        'segera_habis': { label: 'Segera Habis', bg: '#fefce8', text: '#b45309', border: '#fde68a' },
        'mati': { label: 'Mati', bg: '#fef2f2', text: '#dc2626', border: '#fecaca' },
    };
    const fmt = (d) => d ? new Date(d).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '-';

    <?php if($jenis === 'internet'): ?>
    const s = statusComputedMap[i.status_internet] || statusComputedMap['mati'];
    const rows = [
        { label: 'Nama Internet', value: i.nama_internet },
        { label: 'Provider', value: i.provider },
        { label: 'PIC', value: i.pic },
        { label: 'Jabatan', value: i.jabatan },
        { label: 'Masa Tenggang', value: fmt(i.masa_tenggang) },
        { label: 'Hari', value: i.hari_internet || '-' },
        { label: 'Biaya', value: 'Rp ' + Number(i.biaya).toLocaleString('id-ID') },
        { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
    ];
    <?php elseif($jenis === 'aset_digital'): ?>
    const s = statusComputedMap[i.status_digital] || statusComputedMap['mati'];
    const rows = [
        { label: 'Nama Aset', value: i.periode },
        { label: 'Tagihan', value: fmt(i.tanggal_tagihan) },
        { label: 'Jatuh Tempo', value: fmt(i.jatuh_tempo) },
        { label: 'Hari', value: i.hari_digital || '-' },
        { label: 'Nominal', value: 'Rp ' + Number(i.nominal).toLocaleString('id-ID') },
        { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
    ];
    <?php elseif($jenis === 'ipl_ruko'): ?>
    const s = statusComputedMap[i.status_ipl] || statusComputedMap['mati'];
    const rows = [
        { label: 'Periode', value: i.periode },
        { label: 'Tagihan', value: fmt(i.tanggal_tagihan) },
        { label: 'Jatuh Tempo', value: fmt(i.jatuh_tempo) },
        { label: 'Hari', value: i.hari_ipl || '-' },
        { label: 'PIC', value: i.pic || '-' },
        { label: 'Jabatan', value: i.jabatan || '-' },
        { label: 'Nominal', value: 'Rp ' + Number(i.nominal).toLocaleString('id-ID') },
        { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
    ];
    <?php else: ?>
    const fmtDate = (d) => d ? new Date(d + 'T00:00:00') : null;
    const today = new Date(); today.setHours(0,0,0,0);
    const dueDate = fmtDate(i.jatuh_tempo);
    let computedLabel, computedBg, computedText, computedBorder;
    if (i.status === 'lunas') {
        computedLabel = 'Lunas'; computedBg = '#ecfdf5'; computedText = '#059669'; computedBorder = '#a7f3d0';
    } else if (i.status === 'pending') {
        computedLabel = 'Menunggu'; computedBg = '#eff6ff'; computedText = '#3b82f6'; computedBorder = '#bfdbfe';
    } else if (i.status === 'rejected') {
        computedLabel = 'Ditolak'; computedBg = '#fef2f2'; computedText = '#dc2626'; computedBorder = '#fecaca';
    } else if (dueDate && dueDate < today) {
        computedLabel = 'Terlambat'; computedBg = '#fef2f2'; computedText = '#dc2626'; computedBorder = '#fecaca';
    } else if (dueDate && dueDate <= new Date(today.getTime() + 3*86400000)) {
        const sisa = Math.round((dueDate - today) / 86400000);
        computedLabel = sisa === 0 ? 'Hari Ini' : 'H - ' + sisa + ' Hari';
        computedBg = '#fff7ed'; computedText = '#c2410c'; computedBorder = '#fed7aa';
    } else {
        computedLabel = 'Jatuh Tempo'; computedBg = '#fff7ed'; computedText = '#c2410c'; computedBorder = '#fed7aa';
    }
    const s = { label: computedLabel, bg: computedBg, text: computedText, border: computedBorder };
    const rows = [
        { label: 'Periode', value: i.periode },
        { label: 'Tagihan', value: fmt(i.tanggal_tagihan) },
        { label: 'Jatuh Tempo', value: fmt(i.jatuh_tempo) },
        { label: 'Nominal', value: 'Rp ' + Number(i.nominal).toLocaleString('id-ID') },
        { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
    ];
    <?php endif; ?>

    const bayarBtn = document.getElementById('detail-bayar-btn');
    if (i.status === 'jatuh_tempo' || i.status === 'pending') {
        bayarBtn.style.display = '';
    } else {
        bayarBtn.style.display = 'none';
    }

    document.getElementById('detail-body').innerHTML = `
        <div class="space-y-1">
            ${rows.map((r, idx) => `
                <div class="flex items-center justify-between py-2.5" ${idx < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                    <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
                    <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</p>
                </div>
            `).join('')}
            <div class="flex items-center justify-between py-2.5">
                <p class="text-sm" style="color:var(--text-muted);">Status</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${s.bg};color:${s.text};border:1px solid ${s.border};">${s.label}</span>
            </div>
        </div>
    `;
    document.getElementById('detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function markAsLunas() {
    const id = detailId;
    if (!id) return;
    if (!confirm('Tandai pembayaran ini sebagai Lunas?')) return;

    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    const formData = new FormData();
    formData.append('_token', '<?php echo e(csrf_token()); ?>');
    formData.append('_method', 'PUT');
    formData.append('jenis', currentJenis);
    formData.append('status', 'lunas');
    formData.append('tanggal_bayar', new Date().toISOString().split('T')[0]);

    <?php if($jenis === 'internet'): ?>
    formData.append('nama_internet', i.nama_internet);
    formData.append('provider', i.provider);
    formData.append('pic', i.pic);
    formData.append('jabatan', i.jabatan);
    formData.append('masa_tenggang', i.masa_tenggang);
    formData.append('biaya', i.biaya);
    <?php else: ?>
    formData.append('periode', i.periode);
    formData.append('tanggal_tagihan', i.tanggal_tagihan);
    formData.append('jatuh_tempo', i.jatuh_tempo);
    formData.append('nominal', i.nominal);
    <?php endif; ?>

    fetch('<?php echo e(url('admin/pembayaran')); ?>/' + id, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: formData,
    }).then(r => {
        if (r.ok) { location.reload(); }
        else { r.json().then(e => { alert('Gagal: ' + JSON.stringify(e.errors || e)); }); }
    }).catch(() => { location.reload(); });
}

function closeDetail() {
    detailId = null;
    document.getElementById('detail-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function showInternetUsageDetail(id) {
    const u = internetUsageData.find(x => x.id === id);
    if (!u) return;

    document.getElementById('detail-title').textContent = u.ruangan + ' - ' + u.hari;

    const fmt = (d) => d ? new Date(d + 'T00:00:00').toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '-';

    const rows = [
        { label: 'Ruangan', value: u.ruangan },
        { label: 'Hari', value: u.hari },
        { label: 'Tanggal', value: fmt(u.tanggal) },
        { label: 'Penggunaan Wifi', value: Number(u.penggunaan_wifi).toFixed(2) + ' GB' },
        { label: 'Penggunaan Ethernet', value: Number(u.penggunaan_ethernet).toFixed(2) + ' GB' },
        { label: 'Pengecek', value: u.checker || '-' },
        { label: 'Keterangan', value: u.keterangan || '-' },
    ];

    const body = document.getElementById('detail-body');
    body.innerHTML = '';
    rows.forEach(function(r, i) {
        const div = document.createElement('div');
        div.style.cssText = 'display:flex;justify-content:space-between;align-items:center;padding:10px 0;' + (i < rows.length - 1 ? 'border-bottom:1px solid var(--border-color);' : '');
        div.innerHTML = '<span style="color:var(--text-muted);font-size:13px;">' + r.label + '</span><span style="color:var(--text-primary);font-size:13px;font-weight:600;text-align:right;max-width:55%;">' + r.value + '</span>';
        body.appendChild(div);
    });

    document.getElementById('detail-bayar-btn').style.display = 'none';
    var editBtn = document.getElementById('detail-edit-btn');
    if (editBtn) editBtn.style.display = 'none';

    document.getElementById('detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function editFromDetail() {
    const id = detailId;
    closeDetail();
    if (id) openEditModal(id);
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

function toggleDropdown(btn, id) {
    const all = document.querySelectorAll('.dropdown-menu');
    all.forEach(el => { if (el.id !== 'dropdown-' + id) el.style.display = 'none'; });
    const menu = document.getElementById('dropdown-' + id);
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(el => el.style.display = 'none');
    }
});

function openEditModal(id) {
    closeDetail();
    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    document.getElementById('modal-title').textContent = 'Edit Tagihan';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = i.id;
    document.getElementById('payment-form').action = '<?php echo e(url('admin/pembayaran')); ?>/' + i.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan Perubahan';

    <?php if($jenis === 'internet'): ?>
    document.getElementById('f-nama_internet').value = i.nama_internet;
    document.getElementById('f-provider').value = i.provider;
    document.getElementById('f-pic').value = i.pic;
    document.getElementById('f-jabatan').value = i.jabatan;
    document.getElementById('f-masa_tenggang').value = i.masa_tenggang;
    document.getElementById('f-biaya').value = i.biaya;
    <?php else: ?>
    document.getElementById('f-periode').value = i.periode;
    document.getElementById('f-tanggal_tagihan').value = i.tanggal_tagihan;
    document.getElementById('f-jatuh_tempo').value = i.jatuh_tempo;
    document.getElementById('f-nominal').value = i.nominal;
    <?php endif; ?>

    document.getElementById('f-status').value = i.status;
    if (i.status === 'lunas' || i.status === 'pending') {
        document.getElementById('f-tanggal_bayar').value = i.tanggal_bayar || new Date().toISOString().split('T')[0];
        document.getElementById('f-tanggal_bayar-group').style.display = '';
    } else {
        document.getElementById('f-tanggal_bayar').value = '';
        document.getElementById('f-tanggal_bayar-group').style.display = 'none';
    }

    showPaymentModal();
}

function showPaymentModal() { document.getElementById('payment-modal').style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function closePaymentModal() { document.getElementById('payment-modal').style.display = 'none'; document.body.style.overflow = ''; }

document.getElementById('payment-modal')?.addEventListener('click', function(e) { if (e.target === this) closePaymentModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeDetail(); closePaymentModal(); } });

let currentFilter = 'all';

function toggleFilterMenu(e) {
    e.stopPropagation();
    const menu = document.getElementById('filter-menu');
    document.querySelectorAll('.filter-menu').forEach(m => { if (m.id !== 'filter-menu') m.style.display = 'none'; });
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

function setFilter(value) {
    currentFilter = value;
    const label = document.querySelector(`.filter-menu button[data-value="${value}"]`).textContent;
    document.getElementById('filter-label').textContent = label;
    document.getElementById('filter-menu').style.display = 'none';
    filterTable();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

function filterTable() {
    const search = (document.getElementById('search-payment')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#payment-tbody tr:not(#empty-row)');
    rows.forEach(row => {
        const rowStatus = row.dataset.status;
        const text = row.textContent.toLowerCase();
        const matchStatus = currentFilter === 'all' || rowStatus === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchStatus && matchSearch ? '' : 'none';
    });
}



function openTokenModal() {
    document.getElementById('token-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-remaining_kwh').focus();
}

function closeTokenModal() {
    document.getElementById('token-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function openInternetUsageModal() {
    document.getElementById('internet-usage-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeInternetUsageModal() {
    document.getElementById('internet-usage-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('token-modal')?.addEventListener('click', function(e) { if (e.target === this) closeTokenModal(); });
document.getElementById('internet-usage-modal')?.addEventListener('click', function(e) { if (e.target === this) closeInternetUsageModal(); });
document.getElementById('topup-modal')?.addEventListener('click', function(e) { if (e.target === this) closeTopupModal(); });

function openTopupModal() {
    document.getElementById('topup-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-amount_kwh').focus();
}

function closeTopupModal() {
    document.getElementById('topup-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function setTopupRange(range) {
    const params = new URLSearchParams(window.location.search);
    params.set('topup_range', range);
    params.delete('reading_range');
    window.location.search = params.toString();
}

function setReadingRange(range) {
    const params = new URLSearchParams(window.location.search);
    params.set('reading_range', range);
    params.delete('topup_range');
    window.location.search = params.toString();
}

function openBulkIplModal() {
    document.getElementById('bulk-ipl-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-bulk-nominal').focus();
}

function closeBulkIplModal() {
    document.getElementById('bulk-ipl-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('bulk-ipl-modal')?.addEventListener('click', function(e) { if (e.target === this) closeBulkIplModal(); });

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTokenModal();
        closeTopupModal();
        closeBulkIplModal();
        closeAlertPopup();
        closeBayarModal();
        document.body.style.overflow = '';
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.form-grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px 24px;
    margin-bottom: 16px;
}
@media (max-width: 640px) {
    .form-grid-2 { grid-template-columns: 1fr; }
}
.field-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.field-req { color: #f87171; }
.form-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 16px;
    margin-top: 8px;
    border-top: 1px solid var(--border-color);
}
.btn-form {
    padding: 8px 22px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
}
.btn-form-batal {
    background: transparent;
    border: 1px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.7);
}
.btn-form-batal:hover {
    border-color: rgba(255,255,255,0.3);
    color: #fff;
}
.btn-form-simpan {
    background: linear-gradient(135deg, #6c5cff, #8b7bff);
    color: #fff;
    box-shadow: 0 4px 15px rgba(108,92,255,0.3);
}
.btn-form-simpan:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(108,92,255,0.4);
}
</style>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views/admin/pembayaran/index.blade.php ENDPATH**/ ?>