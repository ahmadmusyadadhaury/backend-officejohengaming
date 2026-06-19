@extends('layouts.app')
@section('title', 'Ubah Kata Sandi')
@section('page-title', 'Ubah Kata Sandi')
@section('page-subtitle', 'Perbarui kata sandi akun kamu')

@section('sidebar-menu')
    @if(auth()->user()->hasFullAccess())
        @include('partials.sidebar-admin')
    @elseif(auth()->user()->role === 'koordinator')
        @include('partials.sidebar-leader')
    @else
        @include('partials.sidebar-user')
    @endif
@endsection

@section('content')
<div class="max-w-md mx-auto pt-4 animate-fade-in">
    <div class="gaming-card overflow-hidden">
        <div class="px-6 py-4" style="border-bottom:1px solid var(--border-color);background:linear-gradient(135deg,var(--color-primary-dark),var(--color-accent));">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                    style="background:rgba(255,255,255,0.15);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-gaming font-bold text-white text-base tracking-wide">UBAH KATA SANDI</p>
                    <p class="text-xs" style="color:rgba(255,255,255,0.6);">{{ auth()->user()->name }}</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            {{-- Kata Sandi Lama --}}
            <div>
                <label class="gaming-label">Kata Sandi Lama</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password"
                        class="gaming-input pr-10 @error('current_password') border-red-500 @enderror"
                        placeholder="Masukkan kata sandi lama" autocomplete="current-password">
                    <button type="button" onclick="togglePassword('current_password', this)"
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

            {{-- Kata Sandi Baru --}}
            <div>
                <label class="gaming-label">Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="gaming-input pr-10 @error('password') border-red-500 @enderror"
                        placeholder="Minimal 6 karakter" autocomplete="new-password">
                    <button type="button" onclick="togglePassword('password', this)"
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

            {{-- Konfirmasi Kata Sandi Baru --}}
            <div>
                <label class="gaming-label">Konfirmasi Kata Sandi Baru</label>
                <div class="relative">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="gaming-input pr-10"
                        placeholder="Ulangi kata sandi baru" autocomplete="new-password">
                    <button type="button" onclick="togglePassword('password_confirmation', this)"
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
@endsection

@push('scripts')
<script>
    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endpush
