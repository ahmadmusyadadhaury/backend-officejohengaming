<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOHEN OFFICE Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/gaming.css') }}">
</head>
<body class="login-bg grid-pattern flex items-center justify-center min-h-screen p-4">

    <div class="particle" style="width:6px;height:6px;background:rgba(124,58,237,0.4);top:15%;left:10%;position:absolute;border-radius:50%;animation:float 6s ease-in-out infinite;"></div>
    <div class="particle" style="width:4px;height:4px;background:rgba(0,212,255,0.4);top:70%;left:5%;position:absolute;border-radius:50%;animation:float 6s ease-in-out infinite;animation-delay:1s;"></div>
    <div class="particle" style="width:8px;height:8px;background:rgba(124,58,237,0.2);top:30%;right:8%;position:absolute;border-radius:50%;animation:float 6s ease-in-out infinite;animation-delay:2s;"></div>
    <div class="particle" style="width:5px;height:5px;background:rgba(0,212,255,0.3);top:80%;right:12%;position:absolute;border-radius:50%;animation:float 6s ease-in-out infinite;animation-delay:0.5s;"></div>

    <div class="w-full max-w-sm relative z-10">
        <div class="text-center mb-8 animate-fade-in">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-4 relative animate-float"
                style="background:linear-gradient(135deg,rgba(124,58,237,0.2),rgba(0,212,255,0.1));border:1px solid rgba(124,58,237,0.3);">
                <img src="{{ asset('images/logo/logo_web.png') }}" alt="JOHEN OFFICE" class="w-12 h-12 object-contain">
                <div class="absolute inset-0 rounded-2xl animate-glow-pulse" style="box-shadow:0 0 20px rgba(124,58,237,0.4);"></div>
            </div>
            <h1 class="font-gaming text-3xl font-bold tracking-wider"
                style="background:linear-gradient(135deg,#e2e8f0,#a78bfa,#00d4ff);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                JOHEN OFFICE
            </h1>
            <p style="color:var(--text-muted);font-size:0.8rem;letter-spacing:0.15em;text-transform:uppercase;margin-top:4px;">
                Management System
            </p>
        </div>

        <div class="login-card p-8">
            <h2 class="font-gaming text-xl font-semibold mb-1" style="color:var(--text-primary);">Selamat Datang</h2>
            <p style="color:var(--text-muted);font-size:0.8rem;margin-bottom:1.5rem;">Sistem booking ruang meeting JOHEN OFFICE</p>

            <div class="space-y-3">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        Masuk
                    </a>
                @else
                    <a href="{{ route('rooms.index') }}" class="btn btn-success w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/>
                        </svg>
                        Lihat Ruangan
                    </a>
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary w-full">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Booking Saya
                    </a>
                @endguest
            </div>
        </div>

        <p style="text-align:center;font-size:0.7rem;color:var(--text-muted);margin-top:1.5rem;opacity:0.6;">
            &copy; {{ date('Y') }} JOHEN OFFICE. All rights reserved.
        </p>
    </div>
</body>
</html>
