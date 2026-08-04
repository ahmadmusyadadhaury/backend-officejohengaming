@php
    $modalCategories = $modalCategories ?? \App\Models\TicketCategory::orderBy('name')->get();
@endphp

<style>
    .tkt-drop {
        display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px;
        padding: 22px 16px; border: 1.5px dashed var(--border-color); border-radius: 12px;
        background: var(--bg-surface-2); cursor: pointer; text-align: center;
        transition: border-color .15s ease, background .15s ease;
    }
    .tkt-drop:hover { border-color: var(--tk-accent); background: color-mix(in srgb, var(--tk-accent) 5%, var(--bg-surface-2)); }
    .tkt-drop input { position: absolute; opacity: 0; pointer-events: none; }
    .tkt-drop.active { border-color: var(--tk-accent); }

    .tkt-file-chip {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 8px; border-radius: 8px; font-size: 11px;
        background: var(--tk-accent-soft); border: 1px solid var(--tk-accent-border); color: var(--tk-accent);
    }
    .tkt-file-chip svg { width: 10px; height: 10px; flex-shrink: 0; }
</style>

<div id="create-ticket-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;background:var(--bg-overlay);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);" onclick="if(event.target===this)closeModal('create-ticket-modal')">
    <div class="w-full max-w-lg rounded-2xl flex flex-col" style="max-height:92vh;background:var(--bg-surface);border:1px solid var(--border-color);box-shadow:0 24px 60px -12px rgba(0,0,0,.28),0 8px 24px -12px rgba(0,0,0,.18);" onclick="event.stopPropagation()">

        <div class="flex items-center gap-3 px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl flex-shrink-0" style="background:var(--tk-accent-soft);color:var(--tk-accent);">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="text-base font-bold leading-tight" style="color:var(--tk-text);">Buat Ticket</h3>
                <p class="text-xs mt-0.5 leading-snug" style="color:var(--tk-muted);">Sampaikan kebutuhan IT dengan detail agar dapat ditangani lebih cepat</p>
            </div>
            <button type="button" onclick="closeModal('create-ticket-modal')" class="p-1.5 rounded-lg transition flex-shrink-0" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form method="POST" action="{{ route('ticket.store') }}" enctype="multipart/form-data" class="px-6 py-5 overflow-y-auto flex-1 space-y-5">
            @csrf

            <div>
                <label for="tkt-title" class="block text-[0.7rem] font-bold uppercase tracking-wider mb-1.5" style="color:var(--tk-muted);">Judul Permintaan <span style="color:var(--tk-over);">*</span></label>
                <input id="tkt-title" type="text" name="title" value="{{ old('title') }}" required maxlength="100" placeholder="Contoh: Laptop tidak dapat menyala" class="gaming-input">
                @error('title') <p class="text-xs mt-1" style="color:var(--tk-over);">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="tkt-category" class="block text-[0.7rem] font-bold uppercase tracking-wider mb-1.5" style="color:var(--tk-muted);">Kategori</label>
                    <select id="tkt-category" name="category_id" class="gaming-select">
                        <option value="">— Pilih Kategori —</option>
                        @foreach($modalCategories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-xs mt-1" style="color:var(--tk-over);">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="tkt-priority" class="block text-[0.7rem] font-bold uppercase tracking-wider mb-1.5" style="color:var(--tk-muted);">Prioritas <span style="color:var(--tk-over);">*</span></label>
                    <select id="tkt-priority" name="priority" required class="gaming-select">
                        @foreach(\App\Support\Ticket::priorities() as $priority)
                        <option value="{{ $priority }}" {{ old('priority') === $priority ? 'selected' : '' }}>{{ \App\Support\Ticket::priorityLabel($priority) }}</option>
                        @endforeach
                    </select>
                    @error('priority') <p class="text-xs mt-1" style="color:var(--tk-over);">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="tkt-description" class="block text-[0.7rem] font-bold uppercase tracking-wider" style="color:var(--tk-muted);">Detail Kebutuhan <span style="color:var(--tk-over);">*</span></label>
                    <span id="tkt-desc-count" class="text-[0.65rem] tk-mono" style="color:var(--tk-muted);">0 / 5000</span>
                </div>
                <textarea id="tkt-description" name="description" required rows="4" maxlength="5000" placeholder="Jelaskan kendala yang Anda alami, kapan mulai terjadi, dan apa yang sudah Anda coba..." class="gaming-input">{{ old('description') }}</textarea>
                @error('description') <p class="text-xs mt-1" style="color:var(--tk-over);">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="tkt-attachments" class="block text-[0.7rem] font-bold uppercase tracking-wider mb-1.5" style="color:var(--tk-muted);">Bukti Kendala</label>
                <label for="tkt-attachments" class="tkt-drop">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--tk-muted);">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm font-semibold" style="color:var(--tk-text);">Klik untuk melampirkan bukti</span>
                    <span class="text-[0.7rem]" style="color:var(--tk-muted);">Screenshot atau foto kendala · maks. {{ config('ticket.max_attachment_size') }} KB, {{ config('ticket.max_attachments', 5) }} file</span>
                    <input id="tkt-attachments" type="file" name="attachments[]" multiple accept=".{{ implode(',.', config('ticket.allowed_extensions')) }}">
                </label>
                <div id="tkt-attachment-list" class="flex flex-wrap gap-1.5 mt-2"></div>
                <p class="text-[0.65rem] mt-1.5" style="color:var(--tk-muted);">Format: {{ implode(', ', config('ticket.allowed_extensions')) }}</p>
                @error('attachments.*') <p class="text-xs mt-1" style="color:var(--tk-over);">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-1 flex-shrink-0" style="border-top:1px solid var(--border-color);margin-top:8px;padding-top:14px;">
                <button type="button" onclick="closeModal('create-ticket-modal')" class="btn btn-secondary btn-sm">Batal</button>
                <button type="submit" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Ticket
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var desc = document.getElementById('tkt-description');
    if (desc) {
        var count = document.getElementById('tkt-desc-count');
        var update = function () { count.textContent = desc.value.length + ' / 5000'; };
        desc.addEventListener('input', update);
        update();
    }

    var fileInput = document.getElementById('tkt-attachments');
    var fileList = document.getElementById('tkt-attachment-list');
    if (fileInput && fileList) {
        fileInput.addEventListener('change', function () {
            fileList.innerHTML = '';
            Array.from(fileInput.files).forEach(function (file) {
                var chip = document.createElement('span');
                chip.className = 'tkt-file-chip';
                chip.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>';
                chip.appendChild(document.createTextNode(file.name));
                fileList.appendChild(chip);
            });
        });
    }
});
</script>

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', function () {
    var el = document.getElementById('create-ticket-modal');
    if (el) openModal('create-ticket-modal');
});
</script>
@endif
