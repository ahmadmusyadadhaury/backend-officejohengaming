<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Register — JOHEN OFFICE MANAGEMENT SYSTEM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?php echo e(asset('css/gaming.css')); ?>">
</head>
<body class="login-bg grid-pattern flex items-center justify-center min-h-screen p-4">

    <div style="width:6px;height:6px;background:rgba(124,58,237,0.4);top:15%;left:10%;position:absolute;border-radius:50%;animation:float 6s ease-in-out infinite;"></div>
    <div style="width:4px;height:4px;background:rgba(0,212,255,0.4);top:70%;left:5%;position:absolute;border-radius:50%;animation:float 6s ease-in-out infinite;animation-delay:1s;"></div>
    <div style="width:8px;height:8px;background:rgba(124,58,237,0.2);top:30%;right:8%;position:absolute;border-radius:50%;animation:float 6s ease-in-out infinite;animation-delay:2s;"></div>

    <div class="w-full max-w-sm relative z-10">
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-4 relative animate-float"
                style="background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(0,212,255,0.1));border:1px solid rgba(124,58,237,0.3);">
                <img src="<?php echo e(asset('images/logo/logo_web.png')); ?>" alt="JOHEN OFFICE" class="w-12 h-12 object-contain">
                <div class="absolute inset-0 rounded-2xl animate-glow-pulse" style="box-shadow:0 0 20px rgba(124,58,237,0.4);"></div>
            </div>
            <h1 class="font-gaming text-3xl font-bold tracking-wider"
                style="background:linear-gradient(135deg,#e2e8f0,#a78bfa,#00d4ff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                JOHEN OFFICE
            </h1>
            <p style="color:var(--text-muted);font-size:0.8rem;letter-spacing:0.15em;text-transform:uppercase;margin-top:4px;">
                MANAGEMENT SYSTEM
            </p>
        </div>

        <div class="login-card p-8">
            <h2 class="font-gaming text-xl font-semibold mb-1" style="color:var(--text-primary);">Buat Akun</h2>
            <p style="color:var(--text-muted);font-size:0.8rem;margin-bottom:1.5rem;">Daftarkan akun baru kamu</p>

            <?php if($errors->any()): ?>
            <div class="mb-4 p-3 rounded-lg flex items-start gap-2"
                style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171;font-size:0.8rem;">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <ul class="space-y-0.5">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="gaming-label">Nama <span style="color:#f87171;">*</span></label>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" required autofocus class="gaming-input" placeholder="Nama lengkap">
                </div>
                <div>
                    <label class="gaming-label">Email <span style="color:#f87171;">*</span></label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required class="gaming-input" placeholder="email@example.com">
                </div>
                <div>
                    <label class="gaming-label">Password <span style="color:#f87171;">*</span></label>
                    <input type="password" name="password" required class="gaming-input" placeholder="Minimal 8 karakter">
                </div>
                <div>
                    <label class="gaming-label">Konfirmasi Password <span style="color:#f87171;">*</span></label>
                    <input type="password" name="password_confirmation" required class="gaming-input" placeholder="Ulangi password">
                </div>
                <button type="submit" class="btn btn-primary w-full" style="padding:0.75rem;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    DAFTAR
                </button>
            </form>

            <div class="gaming-divider" style="margin-top:1.5rem;"></div>
            <p style="text-align:center;font-size:0.75rem;color:var(--text-muted);">
                Sudah punya akun?
                <a href="<?php echo e(route('login')); ?>" style="color:var(--color-accent-light);font-weight:600;">Masuk di sini</a>
            </p>
        </div>

        <p style="text-align:center;font-size:0.7rem;color:var(--text-muted);margin-top:1.5rem;opacity:0.6;">
            &copy; <?php echo e(date('Y')); ?> JOHEN OFFICE. All rights reserved.
        </p>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\auth\register.blade.php ENDPATH**/ ?>