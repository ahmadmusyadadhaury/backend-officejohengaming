{{-- Modal Upload File — include di halaman yang butuh --}}
<div id="file-upload-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;overflow-y:auto;background:var(--bg-overlay);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);" onclick="if(event.target===this)closeModal('file-upload-modal')">
    <div class="w-full max-w-[420px]" style="max-height:90vh;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:22px;box-shadow:0 25px 60px rgba(0,0,0,0.3);display:flex;flex-direction:column;animation:fuFadeIn 0.25s ease;" onclick="event.stopPropagation()">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(245,158,11,0.18);">
                    <svg class="w-4.5 h-4.5" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-base font-bold" style="color:var(--text-primary);">Dokumen Belum Diupload</h3>
            </div>
            <button type="button" onclick="closeModal('file-upload-modal')" class="p-1.5 rounded-lg transition" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="p-6 flex-1 overflow-y-auto">
            <p class="text-sm text-center mb-4" style="color:var(--text-muted);">File lampiran belum tersedia di server. Silakan upload file terlebih dahulu.</p>

            <form id="fu-upload-form" enctype="multipart/form-data">
                @csrf
                <div id="fu-dropzone" class="relative flex flex-col items-center justify-center py-8 rounded-xl cursor-pointer transition" style="border:2px dashed var(--border-color);background:var(--bg-surface-2);" onclick="document.getElementById('fu-file-input').click()" ondragover="event.preventDefault();this.style.borderColor='#8b5cf6';this.style.background='rgba(139,92,246,0.06)'" ondragleave="this.style.borderColor='var(--border-color)';this.style.background='var(--bg-surface-2)'" ondrop="event.preventDefault();this.style.borderColor='var(--border-color)';this.style.background='var(--bg-surface-2)';handleFuDrop(event)">
                    <svg class="w-10 h-10 mb-2" style="color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <p class="text-xs font-medium mb-1" style="color:var(--text-primary);">Klik atau drag file ke sini</p>
                    <p class="text-[11px]" style="color:var(--text-muted);">PDF, DOC, DOCX, XLS, XLSX (Maks 10MB)</p>
                    <input type="file" id="fu-file-input" accept=".pdf,.doc,.docx,.xls,.xlsx" class="hidden" onchange="handleFuFileSelect(this)">
                </div>

                <div id="fu-selected-file" class="hidden mt-3 flex items-center gap-2 p-3 rounded-lg" style="background:var(--bg-surface-2);border:1px solid var(--border-color);">
                    <svg class="w-5 h-5 flex-shrink-0" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="text-xs truncate flex-1" style="color:var(--text-primary);" id="fu-selected-name">—</span>
                    <button type="button" onclick="resetFuForm()" class="text-xs font-medium px-2 py-0.5 rounded" style="color:#ef4444;background:none;border:none;cursor:pointer;">Hapus</button>
                </div>

                <div id="fu-progress-wrapper" class="hidden mt-3">
                    <div class="w-full h-2 rounded-full overflow-hidden" style="background:var(--bg-surface-2);">
                        <div id="fu-progress-bar" class="h-full rounded-full transition-all" style="width:0%;background:linear-gradient(90deg,#8b5cf6,#10b981);"></div>
                    </div>
                    <p class="text-[11px] mt-1 text-center" style="color:var(--text-muted);" id="fu-progress-text">Mengupload...</p>
                </div>
            </form>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end gap-2 px-6 py-4 flex-shrink-0" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeModal('file-upload-modal')" class="px-4 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-secondary);border:1px solid var(--border-color);background:var(--bg-surface-2);" onmouseover="this.style.background='var(--bg-surface)'" onmouseout="this.style.background='var(--bg-surface-2)'">Batal</button>
            <button type="button" id="fu-submit-btn" onclick="submitFuUpload()" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="background:rgba(16,185,129,0.15);color:#10b981;border:1px solid rgba(16,185,129,0.4);cursor:pointer;" onmouseover="this.style.background='rgba(16,185,129,0.25)'" onmouseout="this.style.background='rgba(16,185,129,0.15)'">Upload & Buka</button>
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes fuFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endpush

@push('scripts')
<script>
let _fuUploadUrl = '';
let _fuFilePath = '';

function openFileUploadModal(uploadUrl, filePath) {
    _fuUploadUrl = uploadUrl;
    _fuFilePath = filePath;
    resetFuForm();
    openModal('file-upload-modal');
}

function resetFuForm() {
    document.getElementById('fu-file-input').value = '';
    document.getElementById('fu-selected-file').classList.add('hidden');
    document.getElementById('fu-dropzone').classList.remove('hidden');
    document.getElementById('fu-progress-wrapper').classList.add('hidden');
    document.getElementById('fu-submit-btn').disabled = false;
    document.getElementById('fu-submit-btn').textContent = 'Upload & Buka';
}

function handleFuFileSelect(input) {
    if (input.files && input.files[0]) {
        showFuSelectedFile(input.files[0]);
    }
}

function handleFuDrop(event) {
    const files = event.dataTransfer.files;
    if (files && files[0]) {
        document.getElementById('fu-file-input').files = files;
        showFuSelectedFile(files[0]);
    }
}

function showFuSelectedFile(file) {
    const allowed = ['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
    if (!allowed.includes(file.type)) {
        alert('Format file tidak didukung. Hanya PDF, DOC, DOCX, XLS, XLSX.');
        return;
    }
    if (file.size > 10 * 1024 * 1024) {
        alert('Ukuran file maksimal 10MB.');
        return;
    }
    document.getElementById('fu-selected-name').textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(2) + ' MB)';
    document.getElementById('fu-selected-file').classList.remove('hidden');
    document.getElementById('fu-dropzone').classList.add('hidden');
}

function submitFuUpload() {
    const fileInput = document.getElementById('fu-file-input');
    if (!fileInput.files || !fileInput.files[0]) {
        alert('Pilih file terlebih dahulu.');
        return;
    }

    const formData = new FormData();
    formData.append('file', fileInput.files[0]);

    const btn = document.getElementById('fu-submit-btn');
    btn.disabled = true;
    btn.textContent = 'Mengupload...';
    document.getElementById('fu-progress-wrapper').classList.remove('hidden');

    let progress = 0;
    const bar = document.getElementById('fu-progress-bar');
    const text = document.getElementById('fu-progress-text');
    const interval = setInterval(() => {
        progress = Math.min(progress + Math.random() * 15, 90);
        bar.style.width = progress + '%';
        text.textContent = 'Mengupload... ' + Math.round(progress) + '%';
    }, 200);

    fetch(_fuUploadUrl, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: formData
    }).then(r => r.json()).then(data => {
        clearInterval(interval);
        bar.style.width = '100%';
        text.textContent = 'Upload selesai!';
        if (data.success) {
            setTimeout(() => {
                closeModal('file-upload-modal');
                openFilePreviewModal(data.file_path, data.file_url);
            }, 500);
        } else {
            alert(data.message || 'Gagal mengupload file.');
            resetFuForm();
        }
    }).catch(() => {
        clearInterval(interval);
        alert('Terjadi kesalahan saat mengupload file.');
        resetFuForm();
    });
}
</script>
@endpush
