@extends('layouts.app')
@section('title', 'Buat Ticket')
@section('page-title', 'Buat Ticket Baru')
@section('page-subtitle', 'Laporkan masalah IT Anda di sini')
@section('sidebar-menu')
@if(auth()->user()->isTicketTeam())
    @include('partials.sidebar-admin')
@elseif(in_array(auth()->user()->role, ['koordinator', 'head_of_store', 'gm', 'hr', 'ceo']))
    @include('partials.sidebar-leader')
@else
    @include('partials.sidebar-user')
@endif
@endsection

@section('content')
<div class="tk tk-stack">

    {{-- Header --}}
    <div>
        <p class="tk-eyebrow mb-1">Help Desk · Laporkan Masalah</p>
        <h2 class="text-base font-bold" style="color:var(--tk-text);">Buat Ticket Baru</h2>
        <p class="text-xs" style="color:var(--tk-muted);">Tim IT akan merespons sesuai prioritas dan target SLA.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
        {{-- Form --}}
        <form method="POST" action="{{ route('ticket.store') }}" enctype="multipart/form-data" class="tk-card p-5 lg:col-span-2">
            @csrf

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--tk-text);">Judul Masalah <span style="color:var(--tk-over);">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required maxlength="100" placeholder="Contoh: Laptop tidak dapat menyala" class="gaming-input">
                    @error('title') <p class="text-xs mt-1" style="color:var(--tk-over);">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color:var(--tk-text);">Kategori</label>
                        <select name="category_id" class="gaming-select">
                            <option value="">— Pilih Kategori —</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="text-xs mt-1" style="color:var(--tk-over);">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold mb-1.5" style="color:var(--tk-text);">Prioritas <span style="color:var(--tk-over);">*</span></label>
                        <select name="priority" required class="gaming-select">
                            @foreach(\App\Support\Ticket::priorities() as $priority)
                            <option value="{{ $priority }}" {{ old('priority') === $priority ? 'selected' : '' }}>{{ $priority }}</option>
                            @endforeach
                        </select>
                        @error('priority') <p class="text-xs mt-1" style="color:var(--tk-over);">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--tk-text);">Lokasi / Ruangan <span style="color:var(--tk-over);">*</span></label>
                    <select name="location" required class="gaming-select">
                        @foreach(\App\Support\Ticket::locations() as $location)
                        <option value="{{ $location }}" {{ old('location') === $location ? 'selected' : '' }}>{{ $location }}</option>
                        @endforeach
                    </select>
                    @error('location') <p class="text-xs mt-1" style="color:var(--tk-over);">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--tk-text);">Deskripsi Masalah <span style="color:var(--tk-over);">*</span></label>
                    <textarea name="description" required rows="5" maxlength="5000" placeholder="Jelaskan masalah secara detail..." class="gaming-input">{{ old('description') }}</textarea>
                    @error('description') <p class="text-xs mt-1" style="color:var(--tk-over);">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1.5" style="color:var(--tk-text);">Lampiran (maks. {{ config('ticket.max_attachment_size') }} KB, maks. 5 file)</label>
                    <input type="file" name="attachments[]" multiple accept=".{{ implode(',.', config('ticket.allowed_extensions')) }}" class="gaming-input">
                    <p class="text-[0.65rem] mt-1" style="color:var(--tk-muted);">Format: {{ implode(', ', config('ticket.allowed_extensions')) }}</p>
                    @error('attachments.*') <p class="text-xs mt-1" style="color:var(--tk-over);">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6">
                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">Batal</a>
                <button type="submit" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Kirim Ticket
                </button>
            </div>
        </form>

        {{-- SLA guide --}}
        @php
            $slas = \App\Models\TicketSla::pluck('duration_minutes', 'priority')->toArray();
        @endphp
        <div class="tk-card p-4 lg:sticky lg:top-4">
            <p class="tk-eyebrow mb-1">SLA Target</p>
            <h3 class="tk-h mb-3">Target Penyelesaian</h3>
            <div class="space-y-3">
                @foreach(\App\Support\Ticket::priorities() as $priority)
                @php
                    $color = \App\Support\Ticket::priorityColor($priority);
                    $mins = $slas[$priority] ?? config('ticket.default_sla')[$priority] ?? 1440;
                    $barPct = round(min(100, max(15, (config('ticket.default_sla')['low'] ?? 4320) / max(1, $mins) * 20)));
                @endphp
                <div>
                    <div class="flex items-center justify-between text-xs mb-1">
                        <span class="tk-chip" style="background:{{ $color }}1a;color:{{ $color }};border-color:{{ $color }}40;">
                            <span class="tk-chip-dot" style="background:{{ $color }};"></span>
                            {{ \App\Support\Ticket::priorityLabel($priority) }}
                        </span>
                        <span class="tk-mono" style="color:var(--tk-muted);">{{ (new \App\Models\TicketSla)->durationLabel($mins) }}</span>
                    </div>
                    <div class="tk-rail"><i style="width:{{ $barPct }}%;background:{{ $color }};"></i></div>
                </div>
                @endforeach
            </div>
            <hr class="tk-divider my-4">
            <p class="tk-note">SLA dihitung sejak ticket dibuat dan berhenti saat ticket ditandai <strong>resolved</strong>. Ticket yang melewati batas akan ditandai <strong style="color:var(--tk-over);">OVER SLA</strong>.</p>
        </div>
    </div>
</div>
@endsection
