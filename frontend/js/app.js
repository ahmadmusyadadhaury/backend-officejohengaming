let currentPage = 'dashboard';
let statusFilter = 'Semua Status';

document.addEventListener('DOMContentLoaded', () => {
  renderLayout();
  renderSidebar();
  navigate('dashboard');
});

function renderLayout() {
  document.body.innerHTML = `
    <div id="app-root" style="display:flex;min-height:100vh;background:#0f0f1a;color:#e0e0e0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
      <aside id="sidebar" style="width:240px;flex-shrink:0;background:#1a1a2e;border-right:1px solid #2a2a3e;display:flex;flex-direction:column;overflow-y:auto;"></aside>
      <main id="main" style="flex:1;display:flex;flex-direction:column;overflow-y:auto;">
        <header id="topbar" style="height:56px;flex-shrink:0;background:#1a1a2e;border-bottom:1px solid #2a2a3e;display:flex;align-items:center;justify-content:space-between;padding:0 24px;"></header>
        <div id="content" style="flex:1;padding:24px;overflow-y:auto;"></div>
        <div id="modal-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:1000;align-items:center;justify-content:center;" onclick="if(event.target===this)closeModal()"></div>
      </main>
    </div>
  `;
}

function renderSidebar() {
  const sidebar = document.getElementById('sidebar');
  let html = `
    <div style="padding:16px 16px 8px;border-bottom:1px solid #2a2a3e;">
      <div style="display:flex;align-items:center;gap:10px;">
        <div style="width:36px;height:36px;border-radius:8px;background:linear-gradient(135deg,#6C63FF,#a855f7);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;color:#fff;">JO</div>
        <div>
          <div style="font-weight:600;font-size:14px;color:#fff;">${CURRENT_USER.name}</div>
          <div style="font-size:11px;color:#8888aa;">${CURRENT_USER.email}</div>
        </div>
      </div>
    </div>
    <div style="flex:1;padding:8px 0;" id="sidebar-menu">
  `;
  NAV.forEach(item => {
    if (item.adminOnly && !canAccessAll(CURRENT_USER.role)) return;
    if (item.type === 'label') {
      html += `<div style="padding:12px 16px 4px;font-size:10px;font-weight:700;color:#555577;letter-spacing:0.1em;">${item.text}</div>`;
    } else if (item.type === 'item') {
      html += renderNavItem(item, null);
    } else if (item.type === 'group') {
      if (item.adminOnly && !canAccessAll(CURRENT_USER.role)) return;
      html += `<div style="margin-bottom:2px;">`;
      html += `<div onclick="toggleGroup('${item.id}')" style="display:flex;align-items:center;justify-content:space-between;padding:8px 16px;cursor:pointer;color:#8888aa;font-size:13px;font-weight:500;transition:0.2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color='#8888aa'">
        <span>${item.text}</span>
        <span id="caret-${item.id}" style="transition:transform 0.2s;font-size:10px;">▾</span>
      </div>`;
      html += `<div id="group-${item.id}" style="display:none;">`;
      (item.children || []).forEach(child => {
        if (child.adminOnly && !canAccessAll(CURRENT_USER.role)) return;
        html += renderNavItem(child, item.id);
      });
      html += `</div></div>`;
    }
  });
  html += `</div>`;
  sidebar.innerHTML = html;
}

function renderNavItem(item, groupId) {
  const id = item.id || item.text?.toLowerCase().replace(/\s+/g, '-');
  return `<div onclick="navigate('${id}')" id="nav-${id}" style="display:flex;align-items:center;gap:8px;padding:8px 16px 8px ${groupId ? '28px' : '16px'};cursor:pointer;color:#8888aa;font-size:13px;transition:0.2s;border-left:3px solid transparent;" onmouseover="this.style.color='#fff';this.style.background='rgba(108,99,255,0.08)'" onmouseout="this.style.color='#8888aa';this.style.background='transparent'">
    <span>${item.icon ? iconSvg(item.icon) : '<span style="width:14px;"></span>'}</span>
    <span>${item.text}</span>
  </div>`;
}

function toggleGroup(id) {
  const el = document.getElementById('group-' + id);
  const caret = document.getElementById('caret-' + id);
  if (!el) return;
  const isOpen = el.style.display !== 'none';
  el.style.display = isOpen ? 'none' : 'block';
  if (caret) caret.style.transform = isOpen ? '' : 'rotate(180deg)';
}

function setActiveNav(id) {
  document.querySelectorAll('[id^="nav-"]').forEach(el => {
    el.style.color = '#8888aa';
    el.style.background = 'transparent';
    el.style.borderLeftColor = 'transparent';
  });
  const active = document.getElementById('nav-' + id);
  if (active) {
    active.style.color = '#fff';
    active.style.background = 'rgba(108,99,255,0.12)';
    active.style.borderLeftColor = '#6C63FF';
  }
}

function statusClass(status) {
  const map = {
    'Menunggu':'warning','Pending':'warning','Jatuh Tempo':'warning','Segera Habis':'warning','Maintenance':'warning',
    'Disetujui':'info','Dipinjam':'info','Dijadwalkan':'info',
    'Selesai':'success','Aktif':'success','Lunas':'success','Tersedia':'success','Baik':'success',
    'Ditolak':'danger','Nonaktif':'danger','Terlambat':'danger','Rusak':'danger','Expired':'danger','Mati':'danger','Tidak Aktif':'danger','Habis':'danger','Perlu Servis':'warning'
  };
  const type = map[status] || 'default';
  const colors = { warning:'#f59e0b', success:'#10b981', info:'#3b82f6', danger:'#ef4444', default:'#8888aa' };
  const bg = { warning:'rgba(245,158,11,0.15)', success:'rgba(16,185,129,0.15)', info:'rgba(59,130,246,0.15)', danger:'rgba(239,68,68,0.15)', default:'rgba(136,136,170,0.15)' };
  return `style="display:inline-block;padding:2px 8px;border-radius:999px;font-size:11px;font-weight:600;color:${colors[type]};background:${bg[type]};"`;
}

function iconSvg(name) {
  const icons = {
    'layout-grid':'<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
    'users':'<path d="M17 20v-1a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v1"/><circle cx="12" cy="7" r="4"/><path d="M23 20v-1a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
    'box':'<path d="M21 16v-4a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 12v4a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><path d="M3.27 6.96L12 12.01l8.73-5.05"/>',
    'credit-card':'<rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/>',
    'user-cog':'<circle cx="18" cy="15" r="3"/><circle cx="9" cy="7" r="4"/><path d="M10 15H6a4 4 0 0 0-4 4v1"/><path d="M21.7 16.4l-.9-.3"/><path d="M15.3 13.6l-.9-.3"/><path d="M16.7 18.1l-.3.9"/><path d="M21.2 12.4l-.3.9"/>',
    'circle-user':'<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/>',
    'calendar-days':'<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/>',
    'clock':'<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
    'check':'<polyline points="20 6 9 17 4 12"/>',
    'x':'<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>',
    'inbox':'<polyline points="22 12 16 12 14 15 10 15 8 12 2 12"/><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"/>',
    'calendar':'<rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>',
    'door-open':'<path d="M15 3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>',
    'door-closed':'<path d="M15 3h4a1 1 0 0 1 1 1v16a1 1 0 0 1-1 1h-4"/><path d="M3 3h8v18H3z"/>',
    'file-text':'<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/>',
    'check-check':'<path d="M18 6L7 17l-4-4"/><path d="M22 10l-7.5 7.5L13 16"/>',
    'car':'<path d="M14 16H9m10 0h3V9l-4-4H6L3 9v7h3m0 0a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm12 0a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/><path d="M3 9h18"/><path d="M9 4h6l3 5"/>',
    'laptop':'<path d="M20 16V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v9m16 0H4m16 0l2 3H2l2-3"/>',
    'smartphone':'<rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/>',
    'package':'<line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>',
    'wifi':'<path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><circle cx="12" cy="20" r="1"/>',
    'zap':'<polygon points="13 2 3 14 12 14 11 22 21 10 12 10"/>',
    'building-2':'<rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><line x1="8" y1="6" x2="10" y2="6"/><line x1="14" y1="6" x2="16" y2="6"/><line x1="8" y1="10" x2="10" y2="10"/><line x1="14" y1="10" x2="16" y2="10"/><line x1="8" y1="14" x2="10" y2="14"/><line x1="14" y1="14" x2="16" y2="14"/>',
    'bell':'<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
    'wallet':'<path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/>',
    'user':'<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
    'shield-check':'<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>',
    'user-x':'<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="17" y1="8" x2="22" y2="13"/><line x1="22" y1="8" x2="17" y2="13"/>',
    'search':'<circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>',
    'plus':'<line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>',
    'eye':'<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
    'eye-off':'<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>',
  };
  const svg = icons[name] || '<circle cx="12" cy="12" r="10"/>';
  return `<svg style="width:14px;height:14px;flex-shrink:0;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">${svg}</svg>`;
}

function navigate(page) {
  currentPage = page;
  setActiveNav(page);
  const content = document.getElementById('content');
  const topbar = document.getElementById('topbar');
  const meta = PAGE_META[page];

  let breadcrumb = 'Overview';
  let pageTitle = 'Dashboard';
  if (meta) {
    breadcrumb = meta.crumb || 'Overview';
    pageTitle = meta.title;
  }

  topbar.innerHTML = `
    <div style="display:flex;align-items:center;gap:12px;">
      <span style="font-size:12px;color:#555577;">${breadcrumb}</span>
      <span style="color:#333355;">/</span>
      <span style="font-size:14px;font-weight:600;color:#fff;">${pageTitle}</span>
    </div>
    <div style="display:flex;align-items:center;gap:16px;">
      <span style="font-size:12px;color:#8888aa;">${CURRENT_USER.name}</span>
      <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#6C63FF,#a855f7);display:flex;align-items:center;justify-content:center;font-weight:600;font-size:12px;color:#fff;cursor:pointer;">${CURRENT_USER.avatar}</div>
    </div>
  `;

  if (page === 'dashboard') {
    renderDashboard(content);
  } else if (DATASETS[page]) {
    renderDataPage(content, page);
  } else {
    content.innerHTML = `<div style="text-align:center;padding:60px 20px;color:#555577;"><h2 style="font-size:24px;margin-bottom:8px;color:#8888aa;">${pageTitle}</h2><p>Halaman sedang dalam pengembangan</p></div>`;
  }
}

function renderDashboard(container) {
  let html = `<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:16px;margin-bottom:24px;">`;
  Object.values(DASHBOARD_SUMMARY).forEach(cat => {
    html += `
      <div style="background:#1a1a2e;border-radius:12px;border:1px solid #2a2a3e;padding:20px;cursor:pointer;transition:0.2s;" onclick="navigate('${cat.goTo}')" onmouseover="this.style.borderColor='#6C63FF'" onmouseout="this.style.borderColor='#2a2a3e'">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
          ${iconSvg(cat.icon)}
          <div>
            <div style="font-weight:600;font-size:14px;color:#fff;">${cat.title}</div>
            <div style="font-size:11px;color:#8888aa;">${cat.subtitle}</div>
          </div>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:12px;">
          ${cat.stats.map(s => `
            <div style="background:rgba(108,99,255,0.06);border-radius:8px;padding:8px 10px;">
              <div style="font-size:18px;font-weight:700;color:#${s.color === 'accent' ? '6C63FF' : s.color === 'warning' ? 'f59e0b' : s.color === 'success' ? '10b981' : s.color === 'info' ? '3b82f6' : '8888aa'};">${s.value}</div>
              <div style="font-size:10px;color:#8888aa;">${s.label}</div>
            </div>
          `).join('')}
        </div>
        <div style="font-size:11px;color:#555577;font-weight:600;">${cat.tableTitle}</div>
        <div style="margin-top:6px;">
          ${cat.rows.map(r => `
            <div style="display:flex;justify-content:space-between;padding:4px 0;font-size:12px;border-bottom:1px solid #2a2a3e;">
              <span style="color:#ccc;">${r.cols[0]}</span>
              <span ${statusClass(r.status)}>${r.status}</span>
            </div>
          `).join('')}
        </div>
      </div>`;
  });
  html += `</div>`;
  container.innerHTML = html;
}

function renderDataPage(container, page) {
  const ds = DATASETS[page];
  if (!ds) return;

  let html = '';

  // Stats cards
  if (ds.stats) {
    html += `<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:12px;margin-bottom:20px;">`;
    ds.stats.forEach(s => {
      const sc = s.color || 'accent';
      const colorMap = { accent:'#6C63FF', warning:'#f59e0b', success:'#10b981', info:'#3b82f6', danger:'#ef4444' };
      html += `
        <div style="background:#1a1a2e;border-radius:10px;border:1px solid #2a2a3e;padding:14px 16px;">
          <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
            ${iconSvg(s.icon || 'layout-grid')}
            <span style="font-size:22px;font-weight:700;color:${colorMap[sc]};">${s.value}</span>
          </div>
          <div style="font-size:11px;color:#8888aa;">${s.label}</div>
        </div>`;
    });
    html += `</div>`;
  }

  // Header
  html += `
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
      <div>
        <div style="font-weight:600;font-size:16px;color:#fff;">${ds.panelTitle || ''}</div>
        <div style="font-size:12px;color:#8888aa;margin-top:2px;">${ds.panelSub || ''}</div>
      </div>
      ${!ds.hideAddButton ? `<button onclick="alert('Fitur tambah data')" style="background:#6C63FF;color:#fff;border:none;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:500;cursor:pointer;display:flex;align-items:center;gap:6px;">${iconSvg('plus')} ${ds.addLabel || 'Tambah'}</button>` : ''}
    </div>`;

  // Search & filter
  html += `<div style="display:flex;gap:10px;margin-bottom:16px;align-items:center;">`;
  html += `<div style="position:relative;flex:1;max-width:360px;">
    <span style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#555577;">${iconSvg('search')}</span>
    <input type="text" placeholder="${ds.searchPlaceholder || 'Cari...'}" id="search-input" oninput="renderTable('${page}')" style="width:100%;padding:8px 12px 8px 32px;background:#1a1a2e;border:1px solid #2a2a3e;border-radius:8px;color:#e0e0e0;font-size:13px;outline:none;">
  </div>`;
  if (page === 'meeting-permintaan') {
    const filters = [
      { label:'Semua Status', match:'Semua Status' },
      { label:'Menunggu Review', match:'Menunggu' },
      { label:'Disetujui', match:'Disetujui' },
      { label:'Ditolak', match:'Ditolak' },
    ];
    html += `<div style="display:flex;gap:6px;margin-left:auto;">`;
    filters.forEach(f => {
      const active = statusFilter === f.match;
      html += `<button onclick="setStatusFilter('${f.match}','${page}')" id="filter-${f.match}" style="padding:8px 14px;border-radius:8px;font-size:12px;font-weight:500;cursor:pointer;border:1px solid #2a2a3e;background:${active ? '#6C63FF' : '#1a1a2e'};color:${active ? '#fff' : '#8888aa'};">${f.label}</button>`;
    });
    html += `</div>`;
  }
  html += `</div>`;

  // Table panel
  html += `<div style="background:#1a1a2e;border-radius:12px;border:1px solid #2a2a3e;overflow:hidden;">`;

  if (ds.columns && ds.rows) {
    // Simple table (meeting-permintaan style)
    html += `<div style="overflow-x:auto;"><table style="width:100%;border-collapse:collapse;font-size:13px;">`;
    html += `<thead><tr style="border-bottom:1px solid #2a2a3e;">`;
    ds.columns.forEach(col => {
      html += `<th style="text-align:left;padding:12px 16px;color:#8888aa;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:0.05em;">${col}</th>`;
    });
    html += `</tr></thead><tbody id="table-body-${page}">`;
    html += `</tbody></table></div>`;
  } else if (ds.tableColumns && ds.records) {
    // Advanced table
    const cols = ds.tableColumns;
    html += `<div style="overflow-x:auto;"><table style="width:100%;border-collapse:collapse;font-size:13px;">`;
    html += `<thead><tr style="border-bottom:1px solid #2a2a3e;">`;
    cols.forEach(col => {
      html += `<th style="text-align:left;padding:12px 16px;color:#8888aa;font-weight:600;font-size:11px;text-transform:uppercase;letter-spacing:0.05em;">${col}</th>`;
    });
    html += `</tr></thead><tbody id="table-body-${page}">`;
    html += `</tbody></table></div>`;
  }
  html += `</div>`;
  container.innerHTML = html;

  // Render table rows
  renderTable(page);
}

function renderTable(page) {
  const ds = DATASETS[page];
  if (!ds) return;
  const tbody = document.getElementById('table-body-' + page);
  if (!tbody) return;

  const search = (document.getElementById('search-input')?.value || '').toLowerCase();

  if (ds.columns && ds.rows) {
    // Simple table
    let filtered = ds.rows;
    if (page === 'meeting-permintaan') {
      if (statusFilter !== 'Semua Status') {
        filtered = filtered.filter(r => r.status === statusFilter);
      }
      if (search) {
        filtered = filtered.filter(r => r.cols[0].toLowerCase().includes(search));
      }
    }
    tbody.innerHTML = filtered.map((r, i) => `
      <tr style="border-bottom:1px solid #2a2a3e;transition:0.15s;" onmouseover="this.style.background='rgba(108,99,255,0.04)'" onmouseout="this.style.background='transparent'">
        ${r.cols.map(c => `<td style="padding:12px 16px;color:#ccc;">${c}</td>`).join('')}
        <td style="padding:12px 16px;"><span ${statusClass(r.status)}>${r.status}</span></td>
        <td style="padding:12px 16px;">
          <div style="display:flex;gap:6px;">
            <button onclick="openDetailModal('${page}',${i})" style="padding:4px 10px;border-radius:6px;font-size:11px;cursor:pointer;border:1px solid #2a2a3e;background:transparent;color:#8888aa;transition:0.2s;" onmouseover="this.style.color='#fff';this.style.borderColor='#6C63FF'" onmouseout="this.style.color='#8888aa';this.style.borderColor='#2a2a3e'">${iconSvg('eye')} Lihat Detail</button>
            <button onclick="editData('${page}',${r.id || i})" style="padding:4px 10px;border-radius:6px;font-size:11px;cursor:pointer;border:1px solid #2a2a3e;background:transparent;color:#8888aa;transition:0.2s;" onmouseover="this.style.color='#f59e0b';this.style.borderColor='#f59e0b'" onmouseout="this.style.color='#8888aa';this.style.borderColor='#2a2a3e'">Edit Data</button>
            <button onclick="deleteData('${page}',${r.id || i})" style="padding:4px 10px;border-radius:6px;font-size:11px;cursor:pointer;border:1px solid #2a2a3e;background:transparent;color:#8888aa;transition:0.2s;" onmouseover="this.style.color='#ef4444';this.style.borderColor='#ef4444'" onmouseout="this.style.color='#8888aa';this.style.borderColor='#2a2a3e'">Hapus</button>
          </div>
        </td>
      </tr>
    `).join('');
  } else if (ds.tableColumns && ds.records) {
    // Advanced table
    let filtered = ds.records;
    if (search) {
      const searchFields = ds.searchFields || [];
      filtered = filtered.filter(r => searchFields.some(f => (r[f] || '').toString().toLowerCase().includes(search)));
    }
    const keys = ds.tableFieldKeys || Object.keys(filtered[0] || {}).filter(k => k !== 'id' && k !== 'status');
    tbody.innerHTML = filtered.map((r, i) => `
      <tr style="border-bottom:1px solid #2a2a3e;transition:0.15s;" onmouseover="this.style.background='rgba(108,99,255,0.04)'" onmouseout="this.style.background='transparent'">
        ${keys.map(k => {
          let val = r[k] || '-';
          if (ds.tableFieldFormatters && ds.tableFieldFormatters[k]) {
            val = ds.tableFieldFormatters[k](val);
          }
          if (k.includes('pajak') || k.includes('tgl') || k.includes('tanggal') || k.includes('masa') || k.includes('berakhir') || k.includes('mulai')) {
            if (val && val.includes('-')) {
              const d = new Date(val + 'T00:00:00');
              val = d.toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' });
            }
          }
          return `<td style="padding:12px 16px;color:#ccc;white-space:nowrap;">${val}</td>`;
        }).join('')}
        <td style="padding:12px 16px;"><span ${statusClass(r.status)}>${ds.statusLabels?.[r.status] || r.status}</span></td>
        <td style="padding:12px 16px;">
          <div style="display:flex;gap:6px;">
            <button onclick="openDetailModal('${page}',${i})" style="padding:4px 10px;border-radius:6px;font-size:11px;cursor:pointer;border:1px solid #2a2a3e;background:transparent;color:#8888aa;" onmouseover="this.style.color='#fff';this.style.borderColor='#6C63FF'" onmouseout="this.style.color='#8888aa';this.style.borderColor='#2a2a3e'">${iconSvg('eye')}</button>
          </div>
        </td>
      </tr>
    `).join('');
  }
}

function setStatusFilter(val, page) {
  statusFilter = val;
  document.querySelectorAll('[id^="filter-"]').forEach(el => {
    el.style.background = '#1a1a2e';
    el.style.color = '#8888aa';
  });
  const btn = document.getElementById('filter-' + val);
  if (btn) {
    btn.style.background = '#6C63FF';
    btn.style.color = '#fff';
  }
  renderTable(page);
}

function openDetailModal(page, index) {
  const ds = DATASETS[page];
  if (!ds) return;

  let record;
  if (ds.rows) {
    record = ds.rows[index];
  } else if (ds.records) {
    record = ds.records[index];
  }
  if (!record) return;

  const overlay = document.getElementById('modal-overlay');
  let bodyHtml = '';

  if (page === 'meeting-permintaan') {
    const cols = record.cols || [];
    bodyHtml = `
      <div style="background:#1a1a2e;border-radius:16px;border:1px solid #2a2a3e;padding:32px;max-width:600px;width:90%;position:relative;max-height:80vh;overflow-y:auto;">
        <button onclick="closeModal()" style="position:absolute;top:16px;right:16px;background:transparent;border:none;color:#8888aa;font-size:20px;cursor:pointer;">✕</button>
        <div style="margin-bottom:20px;">
          <div style="font-size:20px;font-weight:700;color:#fff;margin-bottom:4px;">${cols[1] || 'Detail'}</div>
          <div style="display:flex;gap:10px;font-size:12px;color:#8888aa;">
            <span>${cols[0] || ''}</span>
            <span>•</span>
            <span>${cols[2] || ''}</span>
          </div>
        </div>
        <div style="margin-bottom:20px;">
          <span ${statusClass(record.status)}>${record.status}</span>
          <span style="margin-left:8px;font-size:12px;color:#8888aa;">${cols[3] || ''}</span>
        </div>
        ${record.why ? `
        <div style="margin-bottom:16px;">
          <div style="font-size:11px;font-weight:600;color:#f59e0b;margin-bottom:4px;">Why — Kenapa meeting ini diadakan?</div>
          <div style="font-size:13px;color:#ccc;line-height:1.5;background:rgba(245,158,11,0.06);border-radius:8px;padding:12px;">${record.why}</div>
        </div>` : ''}
        ${record.what ? `
        <div style="margin-bottom:16px;">
          <div style="font-size:11px;font-weight:600;color:#3b82f6;margin-bottom:4px;">What — Apa yang akan dibahas?</div>
          <div style="font-size:13px;color:#ccc;line-height:1.5;background:rgba(59,130,246,0.06);border-radius:8px;padding:12px;">${record.what}</div>
        </div>` : ''}
        ${record.how ? `
        <div style="margin-bottom:16px;">
          <div style="font-size:11px;font-weight:600;color:#10b981;margin-bottom:4px;">How — Bagaimana hasil yang diharapkan?</div>
          <div style="font-size:13px;color:#ccc;line-height:1.5;background:rgba(16,185,129,0.06);border-radius:8px;padding:12px;">${record.how}</div>
        </div>` : ''}
        <div style="display:flex;gap:8px;margin-top:24px;padding-top:16px;border-top:1px solid #2a2a3e;">
          <button onclick="closeModal();editData('${page}',${index});" style="flex:1;padding:10px;border-radius:8px;background:#f59e0b;color:#fff;border:none;font-size:13px;font-weight:500;cursor:pointer;">Edit Data</button>
          <button onclick="closeModal();deleteData('${page}',${index});" style="flex:1;padding:10px;border-radius:8px;background:#ef4444;color:#fff;border:none;font-size:13px;font-weight:500;cursor:pointer;">Hapus</button>
        </div>
      </div>`;
  } else if (ds.records && record) {
    bodyHtml = `
      <div style="background:#1a1a2e;border-radius:16px;border:1px solid #2a2a3e;padding:32px;max-width:600px;width:90%;position:relative;max-height:80vh;overflow-y:auto;">
        <button onclick="closeModal()" style="position:absolute;top:16px;right:16px;background:transparent;border:none;color:#8888aa;font-size:20px;cursor:pointer;">✕</button>
        <div style="font-size:18px;font-weight:700;color:#fff;margin-bottom:16px;">Detail</div>
        <div style="display:grid;gap:10px;">
          ${Object.entries(record).filter(([k]) => k !== 'id').map(([k,v]) => `
            <div style="display:flex;gap:8px;font-size:13px;padding:6px 0;border-bottom:1px solid #2a2a3e;">
              <span style="color:#8888aa;min-width:100px;font-weight:500;">${k.replace(/_/g,' ')}</span>
              <span style="color:#ccc;flex:1;">${v || '-'}</span>
            </div>
          `).join('')}
        </div>
      </div>`;
  }

  if (bodyHtml) {
    overlay.innerHTML = bodyHtml;
    overlay.style.display = 'flex';
  }
}

function closeModal() {
  document.getElementById('modal-overlay').style.display = 'none';
}

function editData(page, id) {
  alert('Edit data #' + id + ' di halaman ' + page);
}

function deleteData(page, id) {
  if (confirm('Hapus data ini?')) {
    alert('Data #' + id + ' dihapus dari ' + page);
  }
}

function formatDateID(dateStr) {
  if (!dateStr || !dateStr.includes('-')) return dateStr;
  const d = new Date(dateStr + 'T00:00:00');
  return d.toLocaleDateString('id-ID', { day:'numeric', month:'short', year:'numeric' });
}
