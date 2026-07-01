const C = window.__PAYMENT_CONFIG;
const paymentData = C.paymentData;
const internetUsageData = C.internetUsageData;
const currentJenis = C.currentJenis;
const dueField = currentJenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
const jenisLabel = C.jenisLabel;
let detailId = null;

function showAlertPopup(type) {
    const overlay = document.getElementById('alert-overlay');
    const title = document.getElementById('alert-popup-title');
    const body = document.getElementById('alert-popup-body');
    const today = new Date(); today.setHours(0,0,0,0);
    const color = type === 'danger' ? '#ef4444' : '#f59e0b';
    const bgColor = type === 'danger' ? 'rgba(239,68,68,0.1)' : 'rgba(245,158,11,0.1)';
    const borderColor = type === 'danger' ? 'rgba(239,68,68,0.25)' : 'rgba(245,158,11,0.25)';
    const label = currentJenis === 'internet' ? 'Masa Tenggang' : 'Jatuh Tempo';

    const items = paymentData.filter(function(item) {
        if (!item[dueField]) return false;
        if (item.status !== 'jatuh_tempo') return false;
        const due = new Date(item[dueField]); due.setHours(0,0,0,0);
        if (type === 'danger') return due <= today;
        const in3 = new Date(today); in3.setDate(in3.getDate() + 3);
        return due > today && due <= in3;
    });

    title.textContent = type === 'danger' ? 'Tagihan Lewat Jatuh Tempo' : 'Tagihan Segera Jatuh Tempo';
    title.style.color = color;
    body.innerHTML = '';

    if (items.length === 0) {
        body.innerHTML = '<div style="text-align:center;padding:20px;color:var(--text-muted);">Tidak ada data.</div>';
    } else {
        items.forEach(function(item, idx) {
            const due = new Date(item[dueField]); due.setHours(0,0,0,0);
            const diffDays = Math.round((today - due) / (1000 * 60 * 60 * 24));
            let badgeText = '';
            if (type === 'danger') {
                badgeText = diffDays === 0 ? 'Hari Ini' : diffDays + ' Hari Lewat';
            } else {
                badgeText = diffDays + ' Hari Lagi';
            }
            const name = currentJenis === 'internet' ? (item.nama_internet + ' (' + item.provider + ')') : item.periode;
            const nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.nominal);

            var row = document.createElement('div');
            row.setAttribute('data-id', item.id);
            row.style.cssText = 'display:flex;align-items:center;justify-content:space-between;padding:12px 0;cursor:pointer;transition:background 0.15s;' + (idx < items.length - 1 ? 'border-bottom:1px solid var(--border-color);' : '');
            row.onmouseover = function() { this.style.background = 'rgba(255,255,255,0.02)'; };
            row.onmouseout = function() { this.style.background = 'none'; };
            row.onclick = function() { goToEdit(item.id); };

            row.innerHTML =
                '<div class="min-w-0" style="flex:1;">' +
                    '<div style="font-weight:600;font-size:13px;color:var(--text-primary);">' + name + '</div>' +
                    '<div style="font-size:12px;color:var(--text-muted);margin-top:2px;">' + label + ': ' + badgeText + ' &middot; ' + nominal + '</div>' +
                '</div>' +
                '<div style="display:flex;align-items:center;gap:6px;flex-shrink:0;margin-left:12px;">' +
                    '<span style="padding:3px 8px;border-radius:6px;font-size:11px;font-weight:600;background:' + (type === 'danger' ? 'rgba(239,68,68,0.15)' : 'rgba(245,158,11,0.15)') + ';color:' + color + ';border:1px solid ' + (type === 'danger' ? 'rgba(239,68,68,0.3)' : 'rgba(245,158,11,0.3)') + ';">' + badgeText + '</span>' +
                    '<svg style="width:14px;height:14px;color:var(--text-muted);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>' +
                '</div>';

            body.appendChild(row);
        });
    }
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function goToEdit(id) {
    closeAlertPopup();
    openBayarModal(id);
}

function openBayarModal(id) {
    const i = paymentData.find(function(x) { return x.id === id; });
    if (!i) return;

    document.getElementById('bayar-id').value = i.id;
    document.getElementById('bayar-form').action = C.baseUrl + '/' + i.id;

    const name = currentJenis === 'internet' ? (i.nama_internet + ' (' + i.provider + ')') : i.periode;
    const nominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(i.nominal);
    const dueField = currentJenis === 'internet' ? 'masa_tenggang' : 'jatuh_tempo';
    const dueLabel = currentJenis === 'internet' ? 'Masa Tenggang' : 'Jatuh Tempo';
    const dueDate = i[dueField] ? new Date(i[dueField]).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' }) : '-';

    document.getElementById('bayar-name').textContent = name;
    document.getElementById('bayar-nominal').textContent = 'Nominal: ' + nominal;
    document.getElementById('bayar-due').textContent = dueLabel + ': ' + dueDate;

    if (currentJenis === 'internet') {
        document.getElementById('bayar-nama_internet').value = i.nama_internet;
        document.getElementById('bayar-provider').value = i.provider;
        document.getElementById('bayar-pic').value = i.pic;
        document.getElementById('bayar-jabatan').value = i.jabatan;
        document.getElementById('bayar-masa_tenggang').value = i.masa_tenggang;
        document.getElementById('bayar-biaya').value = i.biaya;
    } else {
        document.getElementById('bayar-periode').value = i.periode;
        document.getElementById('bayar-tanggal_tagihan').value = i.tanggal_tagihan;
        document.getElementById('bayar-jatuh_tempo').value = i.jatuh_tempo;
        document.getElementById('bayar-nominal_val').value = i.nominal;
    }

    document.getElementById('bayar-tanggal_bayar').value = new Date().toISOString().split('T')[0];
    document.getElementById('bayar-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeBayarModal() {
    document.getElementById('bayar-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('bayar-modal')?.addEventListener('click', function(e) { if (e.target === this) closeBayarModal(); });

function closeAlertPopup() {
    document.getElementById('alert-overlay').style.display = 'none';
    document.body.style.overflow = '';
}

function toggleTanggalBayar() {
    const status = document.getElementById('f-status').value;
    const group = document.getElementById('f-tanggal_bayar-group');
    const input = document.getElementById('f-tanggal_bayar');
    if (status === 'lunas' || status === 'pending') {
        group.style.display = '';
        if (!input.value) {
            input.value = new Date().toISOString().split('T')[0];
        }
    } else {
        group.style.display = 'none';
        input.value = '';
    }
}

function openCreateModal() {
    document.getElementById('modal-title').textContent = 'Tambah Tagihan';
    document.getElementById('form-method').value = 'POST';
    document.getElementById('form-id').value = '';
    document.getElementById('payment-form').action = C.storeUrl;
    document.getElementById('form-submit-btn').textContent = 'Tambah';
    document.getElementById('payment-form').querySelectorAll('input, select').forEach(el => {
        if (el.type !== 'hidden' && el.name !== '_token' && el.name !== '_method') el.value = '';
    });
    document.getElementById('f-status').value = 'jatuh_tempo';
    document.getElementById('f-tanggal_bayar-group').style.display = 'none';
    showModal();
}
function showDetail(id) {
    closeAllDropdowns();
    detailId = id;
    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    if (C.currentJenis === 'internet') {
        document.getElementById('detail-title').textContent = i.nama_internet;
    } else {
        document.getElementById('detail-title').textContent = i.periode;
    }

    const fmtDate = (d) => d ? new Date(d + 'T00:00:00') : null;
    const today = new Date(); today.setHours(0,0,0,0);
    let dueDate;
    if (C.currentJenis === 'internet') {
        dueDate = fmtDate(i.masa_tenggang);
    } else {
        dueDate = fmtDate(i.jatuh_tempo);
    }
    let computedLabel, computedBg, computedText, computedBorder;
    if (i.status === 'lunas') {
        computedLabel = 'Lunas'; computedBg = '#ecfdf5'; computedText = '#059669'; computedBorder = '#a7f3d0';
    } else if (i.status === 'pending') {
        computedLabel = 'Menunggu'; computedBg = '#eff6ff'; computedText = '#3b82f6'; computedBorder = '#bfdbfe';
    } else if (i.status === 'rejected') {
        computedLabel = 'Ditolak'; computedBg = '#fef2f2'; computedText = '#dc2626'; computedBorder = '#fecaca';
    } else if (dueDate && dueDate < today) {
        computedLabel = 'Terlambat'; computedBg = '#fef2f2'; computedText = '#dc2626'; computedBorder = '#fecaca';
    } else if (dueDate && dueDate <= new Date(today.getTime() + 3*86400000)) {
        const sisa = Math.round((dueDate - today) / 86400000);
        computedLabel = sisa === 0 ? 'Hari Ini' : 'H - ' + sisa + ' Hari';
        computedBg = '#fff7ed'; computedText = '#c2410c'; computedBorder = '#fed7aa';
    } else {
        computedLabel = 'Jatuh Tempo'; computedBg = '#fff7ed'; computedText = '#c2410c'; computedBorder = '#fed7aa';
    }
    const s = { label: computedLabel, bg: computedBg, text: computedText, border: computedBorder };

    const fmt = (d) => d ? new Date(d).toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '-';

    let rows;
    if (C.currentJenis === 'internet') {
        rows = [
            { label: 'Nama Internet', value: i.nama_internet },
            { label: 'Provider', value: i.provider },
            { label: 'PIC', value: i.pic },
            { label: 'Jabatan', value: i.jabatan },
            { label: 'Masa Tenggang', value: fmt(i.masa_tenggang) },
            { label: 'Biaya', value: 'Rp ' + Number(i.biaya).toLocaleString('id-ID') },
            { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
        ];
    } else {
        const periodeLabel = C.currentJenis === 'aset_digital' ? 'Nama Aset' : 'Periode';
        rows = [
            { label: periodeLabel, value: i.periode },
            { label: 'Tagihan', value: fmt(i.tanggal_tagihan) },
            { label: 'Jatuh Tempo', value: fmt(i.jatuh_tempo) },
            { label: 'Nominal', value: 'Rp ' + Number(i.nominal).toLocaleString('id-ID') },
            { label: 'Tgl Bayar', value: fmt(i.tanggal_bayar) },
        ];
    }

    const bayarBtn = document.getElementById('detail-bayar-btn');
    if (i.status === 'jatuh_tempo' || i.status === 'pending') {
        bayarBtn.style.display = '';
    } else {
        bayarBtn.style.display = 'none';
    }

    document.getElementById('detail-body').innerHTML = `
        <div class="space-y-1">
            ${rows.map((r, idx) => `
                <div class="flex items-center justify-between py-2.5" ${idx < rows.length - 1 ? 'style="border-bottom:1px solid var(--border-color);"' : ''}>
                    <p class="text-sm" style="color:var(--text-muted);">${r.label}</p>
                    <p class="text-sm font-semibold text-right" style="color:var(--text-primary);max-width:55%;">${r.value}</p>
                </div>
            `).join('')}
            <div class="flex items-center justify-between py-2.5">
                <p class="text-sm" style="color:var(--text-muted);">Status</p>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold" style="background:${s.bg};color:${s.text};border:1px solid ${s.border};">${s.label}</span>
            </div>
        </div>
    `;
    document.getElementById('detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function markAsLunas() {
    const id = detailId;
    if (!id) return;
    if (!confirm('Tandai pembayaran ini sebagai Lunas?')) return;

    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    const formData = new FormData();
    formData.append('_token', C.csrfToken);
    formData.append('_method', 'PUT');
    formData.append('jenis', currentJenis);
    formData.append('status', 'lunas');
    formData.append('tanggal_bayar', new Date().toISOString().split('T')[0]);

    if (currentJenis === 'internet') {
        formData.append('nama_internet', i.nama_internet);
        formData.append('provider', i.provider);
        formData.append('pic', i.pic);
        formData.append('jabatan', i.jabatan);
        formData.append('masa_tenggang', i.masa_tenggang);
        formData.append('biaya', i.biaya);
    } else {
        formData.append('periode', i.periode);
        formData.append('tanggal_tagihan', i.tanggal_tagihan);
        formData.append('jatuh_tempo', i.jatuh_tempo);
        formData.append('nominal', i.nominal);
    }

    fetch(C.baseUrl + '/' + id, {
        method: 'POST',
        headers: { 'Accept': 'application/json' },
        body: formData,
    }).then(r => {
        if (r.ok) { location.reload(); }
        else { r.json().then(e => { alert('Gagal: ' + JSON.stringify(e.errors || e)); }); }
    }).catch(() => { location.reload(); });
}

function closeDetail() {
    detailId = null;
    document.getElementById('detail-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function showInternetUsageDetail(id) {
    closeAllDropdowns();
    const u = internetUsageData.find(x => x.id === id);
    if (!u) return;

    document.getElementById('detail-title').textContent = u.ruangan + ' - ' + u.hari;

    const fmt = (d) => d ? new Date(d + 'T00:00:00').toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' }) : '-';

    const rows = [
        { label: 'Ruangan', value: u.ruangan },
        { label: 'Hari', value: u.hari },
        { label: 'Tanggal', value: fmt(u.tanggal) },
        { label: 'Penggunaan Wifi', value: Number(u.penggunaan_wifi).toFixed(2) + ' GB' },
        { label: 'Penggunaan Ethernet', value: Number(u.penggunaan_ethernet).toFixed(2) + ' GB' },
        { label: 'Pengecek', value: u.checker || '-' },
        { label: 'Keterangan', value: u.keterangan || '-' },
    ];

    const body = document.getElementById('detail-body');
    body.innerHTML = '';
    rows.forEach(function(r, i) {
        const div = document.createElement('div');
        div.style.cssText = 'display:flex;justify-content:space-between;align-items:center;padding:10px 0;' + (i < rows.length - 1 ? 'border-bottom:1px solid var(--border-color);' : '');
        div.innerHTML = '<span style="color:var(--text-muted);font-size:13px;">' + r.label + '</span><span style="color:var(--text-primary);font-size:13px;font-weight:600;text-align:right;max-width:55%;">' + r.value + '</span>';
        body.appendChild(div);
    });

    document.getElementById('detail-bayar-btn').style.display = 'none';

    const _eb = document.getElementById('detail-edit-btn');
    if (_eb) _eb.style.display = 'none';

    document.getElementById('detail-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function editFromDetail() {
    const id = detailId;
    closeDetail();
    if (id) openEditModal(id);
}

document.getElementById('detail-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDetail();
});

function toggleDropdown(btn, id) {
    const all = document.querySelectorAll('.dropdown-menu');
    all.forEach(el => { if (el.id !== 'dropdown-' + id) el.style.display = 'none'; });
    const menu = document.getElementById('dropdown-' + id);
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.dropdown-wrap')) {
        document.querySelectorAll('.dropdown-menu').forEach(el => el.style.display = 'none');
    }
});

function openEditModal(id) {
    closeDetail();
    const i = paymentData.find(x => x.id === id);
    if (!i) return;

    document.getElementById('modal-title').textContent = 'Edit Tagihan';
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('form-id').value = i.id;
    document.getElementById('payment-form').action = C.baseUrl + '/' + i.id;
    document.getElementById('form-submit-btn').textContent = 'Simpan Perubahan';

    if (currentJenis === 'internet') {
        document.getElementById('f-nama_internet').value = i.nama_internet;
        document.getElementById('f-provider').value = i.provider;
        document.getElementById('f-pic').value = i.pic;
        document.getElementById('f-jabatan').value = i.jabatan;
        document.getElementById('f-masa_tenggang').value = i.masa_tenggang;
        document.getElementById('f-biaya').value = i.biaya;
    } else {
        document.getElementById('f-periode').value = i.periode;
        document.getElementById('f-tanggal_tagihan').value = i.tanggal_tagihan;
        document.getElementById('f-jatuh_tempo').value = i.jatuh_tempo;
        document.getElementById('f-nominal').value = i.nominal;
    }

    document.getElementById('f-status').value = i.status;
    if (i.status === 'lunas' || i.status === 'pending') {
        document.getElementById('f-tanggal_bayar').value = i.tanggal_bayar || new Date().toISOString().split('T')[0];
        document.getElementById('f-tanggal_bayar-group').style.display = '';
    } else {
        document.getElementById('f-tanggal_bayar').value = '';
        document.getElementById('f-tanggal_bayar-group').style.display = 'none';
    }

    showModal();
}

function closeAllDropdowns() { document.querySelectorAll('.dropdown-menu').forEach(function(el) { el.style.display = 'none'; }); }
function showModal() { closeAllDropdowns(); document.getElementById('payment-modal').style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function closeModal() { document.getElementById('payment-modal').style.display = 'none'; document.body.style.overflow = ''; }

document.getElementById('payment-modal')?.addEventListener('click', function(e) { if (e.target === this) closeModal(); });
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') { closeDetail(); closeModal(); } });

let currentFilter = 'all';

function toggleFilterMenu(e) {
    e.stopPropagation();
    const menu = document.getElementById('filter-menu');
    document.querySelectorAll('.filter-menu').forEach(m => { if (m.id !== 'filter-menu') m.style.display = 'none'; });
    menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
}

function setFilter(value) {
    currentFilter = value;
    const label = document.querySelector(`.filter-menu button[data-value="` + value + `"]`).textContent;
    document.getElementById('filter-label').textContent = label;
    document.getElementById('filter-menu').style.display = 'none';
    filterTable();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.filter-dropdown-wrap')) {
        document.getElementById('filter-menu').style.display = 'none';
    }
});

function filterTable() {
    const search = (document.getElementById('search-payment')?.value || '').toLowerCase();
    const rows = document.querySelectorAll('#payment-tbody tr:not(#empty-row)');
    rows.forEach(row => {
        const rowStatus = row.dataset.status;
        const text = row.textContent.toLowerCase();
        const matchStatus = currentFilter === 'all' || rowStatus === currentFilter;
        const matchSearch = !search || text.includes(search);
        row.style.display = matchStatus && matchSearch ? '' : 'none';
    });
}

function openTokenModal() {
    document.getElementById('token-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-remaining_kwh').focus();
}

function closeTokenModal() {
    document.getElementById('token-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function openInternetUsageModal() {
    document.getElementById('internet-usage-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeInternetUsageModal() {
    document.getElementById('internet-usage-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('token-modal')?.addEventListener('click', function(e) { if (e.target === this) closeTokenModal(); });
document.getElementById('internet-usage-modal')?.addEventListener('click', function(e) { if (e.target === this) closeInternetUsageModal(); });
document.getElementById('topup-modal')?.addEventListener('click', function(e) { if (e.target === this) closeTopupModal(); });

function openTopupModal() {
    document.getElementById('topup-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-amount_kwh').focus();
}

function closeTopupModal() {
    document.getElementById('topup-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function setTopupRange(range) {
    const params = new URLSearchParams(window.location.search);
    params.set('topup_range', range);
    params.delete('reading_range');
    window.location.search = params.toString();
}

function setReadingRange(range) {
    const params = new URLSearchParams(window.location.search);
    params.set('reading_range', range);
    params.delete('topup_range');
    window.location.search = params.toString();
}

function openBulkIplModal() {
    document.getElementById('bulk-ipl-modal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    document.getElementById('f-bulk-nominal').focus();
}

function closeBulkIplModal() {
    document.getElementById('bulk-ipl-modal').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('bulk-ipl-modal')?.addEventListener('click', function(e) { if (e.target === this) closeBulkIplModal(); });

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTokenModal();
        closeTopupModal();
        closeBulkIplModal();
        closeAlertPopup();
        closeBayarModal();
        document.body.style.overflow = '';
    }
});
