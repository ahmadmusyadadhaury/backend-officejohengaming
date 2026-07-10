<?php $__env->startSection('body-class', 'page-leader'); ?>
<?php $__env->startSection('title', 'Edit Meeting'); ?>
<?php $__env->startSection('page-title', 'Edit Meeting'); ?>
<?php $__env->startSection('sidebar-menu'); ?> <?php echo $__env->make(auth()->user()->hasFullAccess() ? 'partials.sidebar-admin' : 'partials.sidebar-leader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="pt-2 max-w-lg">
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
        <p class="text-yellow-700 font-medium">Meeting yang sudah disubmit tidak dapat diedit.</p>
        <p class="text-yellow-600 text-sm mt-1">Batalkan meeting ini dan buat request baru jika perlu perubahan.</p>
        <a href="<?php echo e(route('koordinator.meetings.show', $meeting)); ?>" class="inline-block mt-4 px-4 py-2 bg-primary text-white rounded-lg text-sm hover:bg-primary-light transition">Kembali ke Detail</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\leader\meetings\edit.blade.php ENDPATH**/ ?>