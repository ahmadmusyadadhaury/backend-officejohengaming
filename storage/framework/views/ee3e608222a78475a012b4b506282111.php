<?php $__env->startSection('title', $room->name); ?>
<?php $__env->startSection('page-title', $room->name); ?>
<?php $__env->startSection('sidebar-menu'); ?>
    <?php if(auth()->user()->hasFullAccess()): ?>
        <?php echo $__env->make('partials.sidebar-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php elseif(auth()->user()->role === 'koordinator'): ?>
        <?php echo $__env->make('partials.sidebar-leader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        <?php echo $__env->make('partials.sidebar-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 max-w-4xl animate-fade-in">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        
        <div class="space-y-4">
            <div class="gaming-card p-5">
                <p class="font-gaming font-semibold text-sm mb-3" style="color:var(--text-primary);letter-spacing:0.05em;">INFO RUANGAN</p>
                <div class="space-y-2">
                    <div class="flex items-center gap-2 p-2 rounded-lg" style="background:var(--bg-surface-2);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-accent-light);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span class="text-sm" style="color:var(--text-primary);">Kapasitas: <strong><?php echo e($room->capacity); ?> orang</strong></span>
                    </div>
                    <?php if($room->location): ?>
                    <div class="flex items-center gap-2 p-2 rounded-lg" style="background:var(--bg-surface-2);">
                        <svg class="w-4 h-4 flex-shrink-0" style="color:var(--color-neon-blue);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        </svg>
                        <span class="text-sm" style="color:var(--text-primary);"><?php echo e($room->location); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if($room->description): ?>
                    <p class="text-sm p-2" style="color:var(--text-muted);"><?php echo e($room->description); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="gaming-card overflow-hidden">
                <div class="px-5 py-4" style="border-bottom:1px solid var(--border-color);">
                    <p class="font-gaming font-semibold text-sm" style="color:var(--text-primary);letter-spacing:0.05em;">BOOKING MENDATANG</p>
                </div>
                <div class="divide-y" style="border-color:var(--border-color);">
                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="px-5 py-3">
                        <p class="text-sm font-medium" style="color:var(--text-primary);"><?php echo e($booking->title); ?></p>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted);">
                            <?php echo e($booking->start_time->format('d M Y H:i')); ?> – <?php echo e($booking->end_time->format('H:i')); ?>

                        </p>
                        <p class="text-xs" style="color:var(--text-muted);">Oleh: <?php echo e($booking->user->name); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="px-5 py-6 text-center">
                        <p class="text-sm" style="color:var(--text-muted);">Tidak ada booking mendatang</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="gaming-card p-5">
            <p class="font-gaming font-semibold text-sm mb-4" style="color:var(--text-primary);letter-spacing:0.05em;">BOOKING RUANGAN INI</p>
            <form method="POST" action="<?php echo e(route('bookings.store')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="room_id" value="<?php echo e($room->id); ?>">
                <div>
                    <label class="gaming-label">Judul Meeting <span style="color:#f87171;">*</span></label>
                    <input type="text" name="title" required class="gaming-input" placeholder="Contoh: Rapat Tim">
                </div>
                <div>
                    <label class="gaming-label">Peserta <span style="color:var(--text-muted);font-weight:400;">(Opsional)</span></label>
                    <textarea name="participants" rows="3" placeholder="john@example.com&#10;jane@example.com" class="gaming-input" style="resize:vertical;"></textarea>
                </div>
                <div>
                    <label class="gaming-label">Waktu Mulai <span style="color:#f87171;">*</span></label>
                    <input type="text" name="start_time" id="booking-start" required class="gaming-input" placeholder="YYYY-MM-DD HH:MM" autocomplete="off">
                </div>
                <div>
                    <label class="gaming-label">Waktu Selesai <span style="color:#f87171;">*</span></label>
                    <input type="text" name="end_time" id="booking-end" required class="gaming-input" placeholder="YYYY-MM-DD HH:MM" autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary w-full">Book Ruangan</button>
            </form>
        </div>
    </div>

    <a href="<?php echo e(route('rooms.index')); ?>" class="inline-flex items-center gap-1.5 text-sm mt-4" style="color:var(--text-muted);">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Kembali
    </a>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const bookingStart = document.getElementById('booking-start');
    const bookingEnd = document.getElementById('booking-end');

    if (bookingStart) {
        const startFp = flatpickr(bookingStart, {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            time_24hr: true,
            minDate: 'today',
            minTime: nowTime(),
            defaultDate: new Date(),
            onChange: function(selectedDates, dateStr) {
                if (endFp) {
                    endFp.set('minDate', dateStr.slice(0, 10));
                    endFp.set('minTime', dateStr.slice(11, 16));
                    if (endFp.selectedDates.length && endFp.selectedDates[0] <= selectedDates[0]) {
                        const d = new Date(selectedDates[0].getTime() + 3600000);
                        endFp.setDate(d);
                    }
                }
            }
        });

        const endFp = flatpickr(bookingEnd, {
            enableTime: true,
            dateFormat: 'Y-m-d H:i',
            time_24hr: true,
            minDate: 'today',
            minTime: nowTime(),
            defaultDate: new Date(Date.now() + 3600000),
        });
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\rooms\show.blade.php ENDPATH**/ ?>