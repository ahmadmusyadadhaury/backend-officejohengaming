@extends('layouts.app')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun kamu')

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
@endpush

@section('content')
<div class="w-full pt-4 space-y-4 animate-fade-in">

    {{-- 2 Column: Foto Profil + Informasi Akun --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Card Foto Profil --}}
        <div class="gaming-card overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">FOTO PROFIL</h3>
            </div>
            <div class="p-6 flex-1 flex items-center justify-center">
                <form method="POST" action="{{ route('profile.update') }}" id="avatar-form" class="w-full">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="avatar_cropped" id="avatar_cropped">

                    <div class="flex flex-col items-center gap-4">
                        {{-- Avatar Preview --}}
                        <div class="relative flex-shrink-0">
                            <div class="w-28 h-28 rounded-2xl overflow-hidden flex items-center justify-center"
                                style="background:linear-gradient(135deg,var(--color-accent),var(--color-primary-light));box-shadow:0 4px 16px rgba(124,58,237,0.3);">
                                @if($user->avatar_url)
                                    <img id="avatar-preview" src="{{ $user->avatar_url }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <span id="avatar-initials" class="font-gaming font-bold text-4xl text-white">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                    <img id="avatar-preview" src="" alt="Avatar" class="w-full h-full object-cover hidden">
                                @endif
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

                        {{-- Info --}}
                        <div class="text-center min-w-0">
                            <p class="font-semibold text-base" style="color:var(--text-primary);">{{ $user->name }}</p>
                            <p class="text-sm" style="color:var(--text-muted);">{{ $user->role_label }}</p>
                            @if($user->team)
                                <p class="text-xs mt-1" style="color:var(--text-muted);">{{ $user->team->name }}</p>
                            @endif
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

        {{-- Card Info Akun --}}
        <div class="gaming-card overflow-hidden flex flex-col h-full">
            <div class="px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
                <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">INFORMASI AKUN</h3>
            </div>
            <div class="p-6 space-y-0 flex-1 flex flex-col justify-center">
                @php
                    $infos = [
                        ['label' => 'Nama Lengkap', 'value' => $user->name],
                        ['label' => 'Username',     'value' => $user->username],
                        ['label' => 'Role',         'value' => $user->role_label],
                        ['label' => 'Tim',          'value' => $user->team?->name ?? '-'],
                        ['label' => 'Status',       'value' => $user->is_active ? 'Aktif' : 'Nonaktif'],
                    ];
                @endphp
                @foreach($infos as $info)
                <div class="flex items-center justify-between py-3" style="border-bottom:1px solid var(--border-color);">
                    <span class="text-sm" style="color:var(--text-muted);">{{ $info['label'] }}</span>
                    <span class="text-sm font-medium" style="color:var(--text-primary);">{{ $info['value'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Card Ubah Kata Sandi --}}
    <div class="gaming-card overflow-hidden" id="password-section">
        <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);">
            <h3 class="font-gaming font-semibold" style="color:var(--text-primary);letter-spacing:0.05em;">UBAH KATA SANDI</h3>
        </div>
        <form method="POST" action="{{ route('profile.password') }}" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="gaming-label">Kata Sandi Lama</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password"
                        class="gaming-input pr-10 @error('current_password') border-red-500 @enderror"
                        placeholder="Masukkan kata sandi lama">
                    <button type="button" onclick="togglePass('current_password')"
                        class="absolute right-3 top-1/2 -translate-y-1/2" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('current_password')
                    <p class="text-xs mt-1" style="color:#f87171;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="gaming-label">Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="password" id="new_password"
                        class="gaming-input pr-10 @error('password') border-red-500 @enderror"
                        placeholder="Minimal 6 karakter">
                    <button type="button" onclick="togglePass('new_password')"
                        class="absolute right-3 top-1/2 -translate-y-1/2" style="color:var(--text-muted);background:none;border:none;cursor:pointer;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="text-xs mt-1" style="color:#f87171;">{{ $message }}</p>
                @enderror
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

{{-- Modal Crop --}}
<div id="crop-modal">
    <div class="w-full max-w-md rounded-2xl overflow-hidden" style="background:var(--bg-surface);box-shadow:var(--shadow-lg);">
        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,var(--color-primary-dark),var(--color-accent));">
            <p class="font-gaming font-bold text-white tracking-wide">CROP FOTO</p>
            <button onclick="closeCropModal()" style="color:rgba(255,255,255,0.6);background:none;border:none;cursor:pointer;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Crop Area --}}
        <div class="p-4">
            <div id="crop-container" class="rounded-xl overflow-hidden" style="background:#000;max-height:55vh;">
                <img id="crop-image" src="" alt="Crop">
            </div>
        </div>

        {{-- Actions --}}
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
@endsection

@push('scripts')
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
@endpush
