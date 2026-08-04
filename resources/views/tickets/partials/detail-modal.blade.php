<div id="ticket-detail-modal" style="display:none;position:fixed;inset:0;z-index:99999;align-items:center;justify-content:center;padding:16px;overflow-y:auto;background:var(--bg-overlay);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);" onclick="if(event.target===this)closeTicketDetail()">
    <div class="w-full max-w-[1000px] rounded-2xl flex flex-col min-h-0" style="max-height:92vh;background:var(--bg-surface);border:1px solid var(--border-color);box-shadow:0 24px 60px -12px rgba(0,0,0,.28),0 8px 24px -12px rgba(0,0,0,.18);" onclick="event.stopPropagation()">
        <div class="flex items-center gap-3 px-6 py-4 flex-shrink-0" style="border-bottom:1px solid var(--border-color);">
            <div class="flex items-center justify-center w-10 h-10 rounded-xl flex-shrink-0" style="background:rgba(99,102,241,0.10);color:#6366f1;">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="min-w-0 flex-1">
                <h3 class="text-base font-bold leading-tight" style="color:var(--text-primary);">Detail Ticket</h3>
                <p class="text-xs mt-0.5 truncate" style="color:var(--text-muted);" id="ticket-detail-subtitle">Memuat...</p>
            </div>
            <button type="button" onclick="closeTicketDetail()" class="p-1.5 rounded-lg transition flex-shrink-0" style="color:var(--text-muted);background:none;border:none;cursor:pointer;" onmouseover="this.style.background='var(--bg-surface-2)'" onmouseout="this.style.background='none'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div id="ticket-detail-body" class="tk px-6 py-5 overflow-y-auto flex-1 min-h-0"></div>
    </div>
</div>

<script>
(function () {
    var TICKET_SHOW_BASE = "{{ route('ticket.show', '__ID__') }}";

    function initEmbeddedTicket() {
        var stars = document.querySelectorAll('.rating-star');
        var valueInput = document.getElementById('rating-value');
        if (stars.length && valueInput) {
            function highlight(n) {
                stars.forEach(function (s) {
                    s.classList.toggle('active', parseInt(s.dataset.rating, 10) <= n);
                });
            }
            stars.forEach(function (star) {
                var val = parseInt(star.dataset.rating, 10);
                star.addEventListener('mouseenter', function () { highlight(val); });
                star.addEventListener('click', function () { valueInput.value = val; highlight(val); });
            });
            var starsBox = document.getElementById('rating-stars');
            if (starsBox) starsBox.addEventListener('mouseleave', function () { highlight(valueInput.value || 0); });
        }

        var commentsBox = document.getElementById('ticket-comments');
        if (commentsBox) commentsBox.scrollTop = commentsBox.scrollHeight;
    }

    window.openTicketDetail = function (ticketId, label) {
        var modal = document.getElementById('ticket-detail-modal');
        var body = document.getElementById('ticket-detail-body');
        var sub = document.getElementById('ticket-detail-subtitle');
        if (!modal || !body) return;

        sub.textContent = label || ('Ticket #' + ticketId);
        body.innerHTML = '<div style="padding:48px 0;text-align:center;color:var(--tk-muted);">Memuat detail...</div>';
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        fetch(TICKET_SHOW_BASE.replace('__ID__', ticketId) + '?embed=1', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) {
            if (!r.ok) throw new Error('HTTP ' + r.status);
            return r.text();
        })
        .then(function (html) {
            body.innerHTML = html;
            initEmbeddedTicket();
        })
        .catch(function () {
            body.innerHTML = '<div style="padding:48px 0;text-align:center;color:var(--tk-over);">Gagal memuat detail ticket.</div>';
        });
    };

    window.closeTicketDetail = function () {
        var modal = document.getElementById('ticket-detail-modal');
        if (modal) modal.style.display = 'none';
        document.body.style.overflow = '';
    };

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') window.closeTicketDetail();
    });
})();
</script>
