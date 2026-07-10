<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Login — JOHEN OFFICE MANAGEMENT SYSTEM</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?php echo e(asset('css/gaming.css')); ?>">
    <style>
        /* Floating particles */
        .particle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            animation: float 6s ease-in-out infinite;
        }
        .particle-1 { width:6px; height:6px; background:rgba(124,58,237,0.4); top:15%; left:10%; animation-delay:0s; }
        .particle-2 { width:4px; height:4px; background:rgba(0,212,255,0.4); top:70%; left:5%;  animation-delay:1s; }
        .particle-3 { width:8px; height:8px; background:rgba(124,58,237,0.2); top:30%; right:8%; animation-delay:2s; }
        .particle-4 { width:5px; height:5px; background:rgba(0,212,255,0.3); top:80%; right:12%;animation-delay:0.5s; }
        .particle-5 { width:3px; height:3px; background:rgba(191,95,255,0.5); top:50%; left:50%;animation-delay:1.5s; }

        /* Hex decoration */
        .hex-bg {
            position: absolute;
            width: 300px; height: 300px;
            border: 1px solid rgba(124,58,237,0.1);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: float 8s ease-in-out infinite;
        }

        @media (prefers-color-scheme: dark) {
            .particle-1 { background:rgba(124,58,237,0.6); }
            .particle-2 { background:rgba(0,212,255,0.6); }
            .particle-3 { background:rgba(124,58,237,0.4); }
            .particle-4 { background:rgba(0,212,255,0.5); }
            .hex-bg { border-color: rgba(124,58,237,0.15); }
        }
    </style>
</head>
<body class="login-bg grid-pattern flex items-center justify-center min-h-screen p-4">

    
    <div class="particle particle-1"></div>
    <div class="particle particle-2"></div>
    <div class="particle particle-3"></div>
    <div class="particle particle-4"></div>
    <div class="particle particle-5"></div>
    <div class="hex-bg" style="top:-100px;right:-100px;animation-delay:1s;"></div>
    <div class="hex-bg" style="bottom:-100px;left:-100px;animation-delay:3s;width:200px;height:200px;"></div>

    <div class="w-full max-w-sm relative z-10">

        
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-4 relative animate-float"
                style="background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(0,212,255,0.1));border:1px solid rgba(124,58,237,0.3);">
                <img src="<?php echo e(asset('images/logo/logo_web.png')); ?>" alt="JOHEN OFFICE"
                    class="w-12 h-12 object-contain">
                
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

            <h2 class="font-gaming text-xl font-semibold mb-1" style="color:var(--text-primary);">
                Masuk ke Sistem
            </h2>
            <p style="color:var(--text-muted);font-size:0.8rem;margin-bottom:1.5rem;">
                Masukkan kredensial akun kamu
            </p>

            <?php if($errors->any()): ?>
                <div class="mb-4 p-3 rounded-lg flex items-center gap-2"
                    style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#f87171;font-size:0.8rem;">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <?php echo e($errors->first()); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>

                <div>
                    <label style="display:block;font-size:0.75rem;font-weight:600;color:var(--text-secondary);margin-bottom:6px;letter-spacing:0.05em;text-transform:uppercase;">
                        Username
                    </label>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <input type="text" name="username" value="<?php echo e(old('username')); ?>" required autofocus
                            placeholder="Masukkan username"
                            class="gaming-input" style="padding-left:2.5rem;">
                    </div>
                </div>

                <div>
                    <label style="display:block;font-size:0.75rem;font-weight:600;color:var(--text-secondary);margin-bottom:6px;letter-spacing:0.05em;text-transform:uppercase;">
                        Password
                    </label>
                    <div style="position:relative;">
                        <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:16px;height:16px;color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        <input type="password" name="password" id="password" required
                            placeholder="Masukkan password"
                            class="gaming-input" style="padding-left:2.5rem;padding-right:2.5rem;">
                        <button type="button" onclick="togglePassword()"
                            style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);padding:0;">
                            <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-2" style="margin-top:0.25rem;">
                    <input type="checkbox" name="remember" id="remember"
                        style="width:14px;height:14px;accent-color:var(--color-accent);cursor:pointer;">
                    <label for="remember" style="font-size:0.8rem;color:var(--text-muted);cursor:pointer;">
                        Ingat saya
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-full" style="margin-top:0.5rem;padding:0.75rem;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    MASUK
                </button>
            </form>

            <div class="gaming-divider" style="margin-top:1.5rem;"></div>

            <p style="text-align:center;font-size:0.75rem;color:var(--text-muted);">
                Belum punya akun? Hubungi <span style="color:var(--color-accent-light);font-weight:600;">Admin</span>
            </p>
        </div>

        <p style="text-align:center;font-size:0.7rem;color:var(--text-muted);margin-top:1.5rem;opacity:0.6;">
            &copy; <?php echo e(date('Y')); ?> JOHEN OFFICE. All rights reserved.
        </p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\auth\login.blade.php ENDPATH**/ ?>