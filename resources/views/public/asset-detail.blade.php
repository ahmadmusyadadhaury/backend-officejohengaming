<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>{{ $item->nama_barang }} - {{ $item->kode_aset }} | JOHEN OFFICE</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-base: #f7f7f7;
            --bg-surface: #ffffff;
            --bg-surface-2: #f3f4f6;
            --text-primary: #0f172a;
            --text-secondary: #334155;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --color-accent: #7c3aed;
            --color-accent-light: #a78bfa;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.10);
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --bg-base: #0d0f1a;
                --bg-surface: #141832;
                --bg-surface-2: #1a1f40;
                --text-primary: #e2e8f0;
                --text-secondary: #cbd5e1;
                --text-muted: #94a3b8;
                --border-color: rgba(255,255,255,0.08);
                --shadow-sm: 0 1px 3px rgba(0,0,0,0.3);
                --shadow-md: 0 4px 16px rgba(0,0,0,0.4);
                --shadow-lg: 0 8px 32px rgba(0,0,0,0.5);
            }
        }
        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background: var(--bg-base);
            color: var(--text-primary);
            margin: 0;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }
        .asset-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            max-width: 480px;
            margin: 0 auto;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
            gap: 12px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.8rem;
            color: var(--text-muted);
            flex-shrink: 0;
        }
        .info-label svg { width: 16px; height: 16px; flex-shrink: 0; opacity: 0.6; }
        .info-value {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-primary);
            text-align: right;
            word-break: break-word;
        }
        .section-title {
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--color-accent);
            padding: 12px 0 4px;
        }
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 14px;
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.03em;
        }
        .badge-status::before {
            content: '';
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
        }
        .foto-container {
            width: 100%;
            aspect-ratio: 16/10;
            background: var(--bg-surface-2);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        .foto-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .foto-placeholder svg { width: 64px; height: 64px; opacity: 0.2; }
        .footer-bar {
            text-align: center;
            padding: 16px;
            font-size: 0.65rem;
            color: var(--text-muted);
        }
        .footer-bar a { color: var(--color-accent); text-decoration: none; font-weight: 600; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in { animation: fadeInUp 0.5s ease forwards; }
    </style>
</head>
<body>
    <div class="px-4 py-6 sm:py-10">
        <div class="asset-card animate-in">

            {{-- Foto --}}
            <div class="foto-container">
                @if($fotoUrl)
                    <img src="{{ $fotoUrl }}" alt="{{ $item->nama_barang }}" loading="lazy">
                @else
                    <div class="foto-placeholder">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--text-muted);">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                @endif
            </div>

            {{-- Header --}}
            <div class="px-5 pt-5 pb-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <h1 style="font-size:1.15rem;font-weight:700;color:var(--text-primary);line-height:1.3;margin:0;">
                            {{ $item->nama_barang }}
                        </h1>
                        <p style="font-size:0.75rem;color:var(--text-muted);margin-top:4px;font-family:monospace;letter-spacing:0.05em;">
                            {{ $item->kode_aset }}
                        </p>
                    </div>
                    <span class="badge-status flex-shrink-0" style="color:{{ $status['color'] }};background:{{ $status['bg'] }};border:1px solid {{ $status['border'] }};">
                        {{ $status['label'] }}
                    </span>
                </div>
            </div>

            <div style="height:1px;background:var(--border-color);margin:0 20px;"></div>

            {{-- Info Sections --}}
            <div class="px-5 py-3">

                {{-- Informasi Barang --}}
                <p class="section-title">Informasi Barang</p>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                        Barcode
                    </span>
                    <span class="info-value" style="font-family:monospace;">{{ $item->barcode ?? $item->kode_aset }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Detail
                    </span>
                    <span class="info-value">{{ $item->detail ?: '-' }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                        Keterangan
                    </span>
                    <span class="info-value">{{ $item->keterangan ?: '-' }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Lokasi Unit
                    </span>
                    <span class="info-value">{{ $item->lokasi_unit }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Ruangan
                    </span>
                    <span class="info-value">{{ $item->ruangan }}</span>
                </div>

                {{-- Penanggung Jawab --}}
                <p class="section-title" style="margin-top:8px;">Penanggung Jawab</p>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        PIC
                    </span>
                    <span class="info-value">{{ $item->pic }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Jabatan
                    </span>
                    <span class="info-value">{{ $item->jabatan }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Atasan
                    </span>
                    <span class="info-value">{{ $item->atasan ?: '-' }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        Jab. Atasan
                    </span>
                    <span class="info-value">{{ $item->jabatan_atasan ?: '-' }}</span>
                </div>

                {{-- Pengadaan --}}
                <p class="section-title" style="margin-top:8px;">Pengadaan</p>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Tahun Pengadaan
                    </span>
                    <span class="info-value">{{ $item->pengadaan_tahun }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Tgl. Pembelian
                    </span>
                    <span class="info-value">{{ $item->tanggal_pembelian ? $item->tanggal_pembelian->format('d M Y') : '-' }}</span>
                </div>

                <div class="info-row">
                    <span class="info-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Status
                    </span>
                    <span class="info-value" style="color:{{ $status['color'] }};">{{ $status['label'] }}</span>
                </div>

            </div>

            {{-- Footer --}}
            <div class="footer-bar" style="border-top:1px solid var(--border-color);">
                <a href="{{ route('public.asset.show', $item->kode_aset) }}">JOHEN OFFICE</a> &middot; Sistem Manajemen Aset
            </div>
        </div>
    </div>
</body>
</html>
