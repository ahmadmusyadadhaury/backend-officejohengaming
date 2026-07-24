{{-- Modal Preview File — include di halaman yang butuh --}}
<div id="file-preview-modal" style="display:none;position:fixed;inset:0;z-index:50;align-items:center;justify-content:center;padding:16px;overflow-y:auto;background:var(--bg-overlay);backdrop-filter:blur(4px);-webkit-backdrop-filter:blur(4px);" onclick="if(event.target===this)closeModal('file-preview-modal')">
    <div class="w-full max-w-[600px] lg:max-w-[800px]" style="max-height:90vh;background:var(--bg-surface);border:1px solid var(--border-color);border-radius:22px;box-shadow:0 25px 60px rgba(0,0,0,0.3);display:flex;flex-direction:column;animation:fpFadeIn 0.25s ease;" onclick="event.stopPropagation()">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0" style="background:rgba(16,185,129,0.18);">
                    <svg class="w-4.5 h-4.5" style="color:#10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-base font-bold truncate" style="color:var(--text-primary);" id="fp-modal-title">Preview Dokumen</h3>
            </div>
            <button type="button" onclick="closeModal('file-preview-modal')" class="p-1.5 rounded-lg transition flex-shrink-0" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body: PDF Preview --}}
        <div class="flex-1 min-h-0" id="fp-pdf-wrapper" style="display:none;">
            <iframe id="fp-pdf-frame" src="" style="width:100%;height:100%;min-height:400px;border:none;"></iframe>
        </div>

        {{-- Body: Non-PDF info --}}
        <div class="p-6 flex-1" id="fp-info-wrapper" style="display:none;">
            <div class="flex flex-col items-center text-center py-4">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4" style="background:rgba(124,58,237,0.12);">
                    <svg class="w-8 h-8" style="color:#a78bfa;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <p class="text-sm font-semibold mb-1" style="color:var(--text-primary);" id="fp-file-name">—</p>
                <p class="text-xs mb-4" style="color:var(--text-muted);">File ini tidak dapat di-preview langsung di browser.</p>
                <a id="fp-download-btn" href="#" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-medium transition" style="background:rgba(16,185,129,0.15);color:#10b981;border:1px solid rgba(16,185,129,0.4);" onmouseover="this.style.background='rgba(16,185,129,0.25)'" onmouseout="this.style.background='rgba(16,185,129,0.15)'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download File
                </a>
            </div>
        </div>

        {{-- Footer --}}
        <div class="flex items-center justify-end px-6 py-4 flex-shrink-0" style="border-top:1px solid var(--border-color);">
            <button type="button" onclick="closeModal('file-preview-modal')" class="px-5 py-2 rounded-xl text-sm font-medium transition" style="color:var(--text-secondary);border:1px solid var(--border-color);background:var(--bg-surface-2);" onmouseover="this.style.background='var(--bg-surface)'" onmouseout="this.style.background='var(--bg-surface-2)'">Tutup</button>
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes fpFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endpush

@push('scripts')
<script>
function openFilePreviewModal(filePath, fileUrl) {
    const ext = (filePath || '').split('.').pop().toLowerCase();
    const isPdf = ext === 'pdf';
    const fileName = (filePath || '').split('/').pop();

    document.getElementById('fp-modal-title').textContent = 'Preview — ' + fileName;

    if (isPdf) {
        document.getElementById('fp-pdf-frame').src = fileUrl + '?inline=1';
        document.getElementById('fp-pdf-wrapper').style.display = '';
        document.getElementById('fp-info-wrapper').style.display = 'none';
    } else {
        document.getElementById('fp-file-name').textContent = fileName;
        document.getElementById('fp-download-btn').href = fileUrl;
        document.getElementById('fp-info-wrapper').style.display = '';
        document.getElementById('fp-pdf-wrapper').style.display = 'none';
    }
    openModal('file-preview-modal');
}

function closeFilePreviewModal() {
    document.getElementById('fp-pdf-frame').src = '';
    closeModal('file-preview-modal');
}
</script>
@endpush
