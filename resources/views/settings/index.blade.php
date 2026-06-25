@extends('layouts.app')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')
@section('page-subtitle', 'Kelola pengaturan akun kamu')

@section('sidebar-menu')
    @if(auth()->user()->hasFullAccess())
        @include('partials.sidebar-admin')
    @elseif(auth()->user()->role === 'koordinator')
        @include('partials.sidebar-leader')
    @else
        @include('partials.sidebar-user')
    @endif
@endsection

@push('styles')
<style>
    .toggle-wrap {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        user-select: none;
    }
    .toggle-wrap input { display: none; }
    .toggle-track {
        position: relative;
        width: 44px;
        height: 24px;
        border-radius: 12px;
        background: var(--border-color);
        transition: background 0.2s;
        flex-shrink: 0;
    }
    .toggle-track::after {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        transition: transform 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }
    .toggle-wrap input:checked + .toggle-track {
        background: var(--color-accent);
    }
    .toggle-wrap input:checked + .toggle-track::after {
        transform: translateX(20px);
    }
    .toggle-label {
        font-size: 0.875rem;
        color: var(--text-primary);
    }
    .toggle-desc {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 1px;
    }
</style>
@endpush

@section('content')
<div class="w-full pt-4 space-y-4 animate-fade-in">
    {{-- Form untuk setting yang bisa diubah --}}
    <form method="POST" action="{{ route('settings.update') }}" id="settings-form" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Section 3: Tampilan --}}
        <div class="gaming-card overflow-hidden" id="tampilan-section">
            <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">TAMPILAN</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium" style="color:var(--text-primary);">Mode {{ $user->theme === 'dark' ? 'Gelap' : 'Terang' }}</p>
                        <p class="text-xs" style="color:var(--text-muted);">Ganti tema antarmuka gelap atau terang</p>
                    </div>
                    <label class="toggle-wrap">
                        <input type="hidden" name="theme" value="light">
                        <input type="checkbox" name="theme" value="dark" id="theme-toggle-input"
                            {{ $user->theme === 'dark' ? 'checked' : '' }}
                            onchange="previewTheme(this.checked)">
                        <span class="toggle-track"></span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Section 4: Notifikasi (Preferensi) --}}
        <div class="gaming-card overflow-hidden">
            <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">NOTIFIKASI</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="toggle-label">Notifikasi Email</p>
                        <p class="toggle-desc">Terima pembaruan melalui email</p>
                    </div>
                    <label class="toggle-wrap">
                        <input type="checkbox" name="email_notifications" value="1"
                            {{ $user->email_notifications ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="toggle-label">Notifikasi Aplikasi</p>
                        <p class="toggle-desc">Terima pemberitahuan di dalam aplikasi</p>
                    </div>
                    <label class="toggle-wrap">
                        <input type="checkbox" name="app_notifications" value="1"
                            {{ $user->app_notifications ? 'checked' : '' }}>
                        <span class="toggle-track"></span>
                    </label>
                </div>
            </div>
        </div>

        {{-- Section 5: Tentang Aplikasi --}}
        <div class="gaming-card overflow-hidden">
            <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">TENTANG APLIKASI</h3>
            </div>
            <div class="p-6 space-y-0">
                @php
                    $aboutInfos = [
                        ['label' => 'Nama Aplikasi', 'value' => 'Johen Office'],
                        ['label' => 'Versi',         'value' => '2.0.0'],
                        ['label' => 'Pengguna',      'value' => $user->name . ' (' . $user->role_label . ')'],
                    ];
                @endphp
                @foreach($aboutInfos as $info)
                    <div class="flex items-center justify-between py-3" style="border-bottom:1px solid var(--border-color);">
                        <span class="text-sm" style="color:var(--text-muted);">{{ $info['label'] }}</span>
                        <span class="text-sm font-medium" style="color:var(--text-primary);">{{ $info['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Tombol Simpan --}}
        <div class="flex justify-end pt-2 pb-8">
            <button type="submit" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </form>

</div>
@endsection

@push('scripts')
<script>
    // Preview theme when toggle changes (without saving to server yet)
    function previewTheme(isDark) {
        const theme = isDark ? 'dark' : 'light';
        const body = document.body;
        body.classList.toggle('dark', isDark);
        body.classList.toggle('light', !isDark);
        // Update label text
        const label = document.querySelector('#tampilan-section .text-sm.font-medium');
        if (label) {
            label.textContent = 'Mode ' + (isDark ? 'Gelap' : 'Terang');
        }
    }

    // On page load, apply user's saved theme from DB (overrides localStorage)
    document.addEventListener('DOMContentLoaded', function () {
        const savedTheme = '{{ $user->theme }}';
        if (savedTheme === 'dark' || savedTheme === 'light') {
            const body = document.body;
            body.classList.toggle('dark', savedTheme === 'dark');
            body.classList.toggle('light', savedTheme === 'light');
            // Sync localStorage so topbar toggle stays consistent
            try { localStorage.setItem('johenTheme', savedTheme); } catch (e) {}
            // Update topbar button
            if (window.updateThemeButton) {
                window.updateThemeButton(savedTheme);
            }
            // Sync checkbox
            const chk = document.getElementById('theme-toggle-input');
            if (chk) chk.checked = savedTheme === 'dark';
        }
    });
</script>
@endpush
