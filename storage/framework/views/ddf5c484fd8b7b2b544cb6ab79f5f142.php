<?php $__env->startSection('title', 'Profil Saya'); ?>
<?php $__env->startSection('page-title', 'Profil Saya'); ?>
<?php $__env->startSection('page-subtitle', 'Kelola informasi akun kamu'); ?>

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<style>
    #crop-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 999;
        background: rgba(0,0,0,0.75);
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    #crop-modal.show { display: flex; }
    #crop-container {
        max-height: 60vh;
        overflow: hidden;
    }
    #crop-container img {
        max-width: 100%;
        display: block;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full pt-4 space-y-4 animate-fade-in">

    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        
        <div class="gaming-card overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">FOTO PROFIL</h3>
            </div>
            <div class="p-6 flex-1 flex items-center justify-center">
                <form method="POST" action="<?php echo e(route('profile.update')); ?>" id="avatar-form" class="w-full">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <input type="hidden" name="avatar_cropped" id="avatar_cropped">

                    <div class="flex flex-col items-center gap-4">
                        
                        <div class="relative flex-shrink-0">
                            <div class="w-28 h-28 rounded-2xl overflow-hidden flex items-center justify-center"
                                style="background:linear-gradient(135deg,var(--color-accent),var(--color-primary-light));box-shadow:0 4px 16px rgba(124,58,237,0.3);">
                                <?php if($user->avatar_url): ?>
                                    <img id="avatar-preview" src="<?php echo e($user->avatar_url); ?>" alt="Avatar" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <span id="avatar-initials" class="font-gaming font-bold text-4xl text-white">
                                        <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                    </span>
                                    <img id="avatar-preview" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                                <?php endif; ?>
                            </div>
                            <label for="avatar-input" class="absolute -bottom-1 -right-1 w-8 h-8 rounded-full flex items-center justify-center cursor-pointer"
                                style="background:var(--color-accent);box-shadow:0 2px 8px rgba(124,58,237,0.4);">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </label>
                            <input type="file" id="avatar-input" accept="image/*" class="hidden">
                        </div>

                        
                        <div class="text-center min-w-0">
                            <p class="font-semibold text-base" style="color:var(--text-primary);"><?php echo e($user->name); ?></p>
                            <p class="text-sm" style="color:var(--text-muted);"><?php echo e($user->role_label); ?></p>
                            <?php if($user->team): ?>
                                <p class="text-xs mt-1" style="color:var(--text-muted);"><?php echo e($user->team->name); ?></p>
                            <?php endif; ?>
                            <p class="text-xs mt-3" style="color:var(--text-muted);">Klik ikon kamera untuk ganti foto. JPG, PNG, WEBP.</p>
                            <div id="save-avatar-btn" class="hidden mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Simpan Foto
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        
        <div class="gaming-card overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">INFORMASI AKUN</h3>
            </div>
            <div class="p-6 space-y-0 flex-1 flex flex-col justify-center">
                <?php
                    $infos = [
                        ['label' => 'Nama Lengkap', 'value' => $user->name],
                        ['label' => 'Username',     'value' => $user->username],
                        ['label' => 'Role',         'value' => $user->role_label],
                        ['label' => 'Tim',          'value' => $user->team?->name ?? '-'],
                        ['label' => 'Status',       'value' => $user->is_active ? 'Aktif' : 'Nonaktif'],
                    ];
                ?>
                <?php $__currentLoopData = $infos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between py-3" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-sm" style="color:var(--text-muted);"><?php echo e($info['label']); ?></span>
                    <span class="text-sm font-medium" style="color:var(--text-primary);"><?php echo e($info['value']); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>

    
    <div class="gaming-card overflow-hidden" id="password-section">
        <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">UBAH KATA SANDI</h3>
        </div>
        <form method="POST" action="<?php echo e(route('profile.password')); ?>" class="p-6 space-y-4">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label class="gaming-label">Kata Sandi Lama</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password"
                        class="gaming-input pr-10 <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Masukkan kata sandi lama">
                    <button type="button" onclick="togglePass('current_password')"
                        class="absolute right-3 top-1/2 -translate-y-1/2" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs mt-1" style="color:#f87171;"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="gaming-label">Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="password" id="new_password"
                        class="gaming-input pr-10 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Minimal 6 karakter">
                    <button type="button" onclick="togglePass('new_password')"
                        class="absolute right-3 top-1/2 -translate-y-1/2" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-xs mt-1" style="color:#f87171;"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="gaming-label">Konfirmasi Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="confirm_password"
                        class="gaming-input pr-10"
                        placeholder="Ulangi kata sandi baru">
                    <button type="button" onclick="togglePass('confirm_password')"
                        class="absolute right-3 top-1/2 -translate-y-1/2" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Kata Sandi
            </button>
        </form>
    </div>

</div>


<div id="crop-modal">
    <div class="w-full max-w-md rounded-2xl overflow-hidden" style="background:var(--bg-surface);box-shadow:var(--shadow-lg);">
        
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,var(--color-primary-dark),var(--color-accent));">
            <p class="font-gaming font-bold text-white tracking-wide">CROP FOTO</p>
            <button onclick="closeCropModal()" style="color:rgba(255,255,255,0.6);background:none;border:none;cursor:pointer;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        
        <div class="p-4">
            <div id="crop-container" class="rounded-xl overflow-hidden" style="background:#000;max-height:55vh;">
                <img id="crop-image" src="" alt="Crop">
            </div>
        </div>

        
        <div class="flex gap-3 px-4 pb-4">
            <button onclick="closeCropModal()" class="btn btn-secondary flex-1">Batal</button>
            <button onclick="applyCrop()" class="btn btn-primary flex-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Gunakan Foto
            </button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
<script>
    let cropper = null;

    // Saat file dipilih → buka modal crop
    document.getElementById('avatar-input').addEventListener('change', function () {
        if (!this.files || !this.files[0]) return;
        const reader = new FileReader();
        reader.onload = e => {
            const cropImg = document.getElementById('crop-image');
            cropImg.src = e.target.result;

            // Destroy cropper lama jika ada
            if (cropper) { cropper.destroy(); cropper = null; }

            document.getElementById('crop-modal').classList.add('show');

            // Init cropper setelah modal tampil
            setTimeout(() => {
                cropper = new Cropper(cropImg, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.9,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: false,
                });
            }, 100);
        };
        reader.readAsDataURL(this.files[0]);
        // Reset input agar bisa pilih file yang sama lagi
        this.value = '';
    });

    function applyCrop() {
        if (!cropper) return;

        const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });
        const base64 = canvas.toDataURL('image/jpeg', 0.85);

        // Set ke hidden input & preview
        document.getElementById('avatar_cropped').value = base64;
        const preview = document.getElementById('avatar-preview');
        const initials = document.getElementById('avatar-initials');
        preview.src = base64;
        preview.classList.remove('hidden');
        if (initials) initials.classList.add('hidden');
        document.getElementById('save-avatar-btn').classList.remove('hidden');

        closeCropModal();
    }

    function closeCropModal() {
        document.getElementById('crop-modal').classList.remove('show');
        if (cropper) { cropper.destroy(); cropper = null; }
    }

    // Tutup modal klik overlay
    document.getElementById('crop-modal').addEventListener('click', function (e) {
        if (e.target === this) closeCropModal();
    });

    function togglePass(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\profile\edit.blade.php ENDPATH**/ ?>