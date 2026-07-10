<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    .analytics-wrapper { font-family: 'Poppins', sans-serif; }
    .analytics-wrapper * { font-family: inherit; }
    .analytics-card { background:var(--bg-surface); border-radius:20px; padding:20px; box-shadow:var(--shadow-md); transition:all .3s ease; border:1px solid var(--border-color); }
    .analytics-card:hover { transform:translateY(-4px); box-shadow:var(--shadow-lg); }
    .analytics-stat-card { background:var(--bg-surface); border-radius:18px; padding:16px; box-shadow:var(--shadow-md); transition:all .3s ease; border:1px solid var(--border-color); }
    .analytics-stat-card:hover { transform:translateY(-4px); box-shadow:var(--shadow-lg); }
    .filter-btn { transition:all .3s ease; cursor:pointer; border-radius:10px; border:none; font-weight:600; }
    .filter-btn:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(124,58,237,0.3); }
    #month-select option { background:var(--bg-surface); color:var(--text-primary); }
    .chart-loading { position:relative; }
    .chart-loading::after { content:''; position:absolute; inset:0; background:linear-gradient(90deg,transparent,rgba(255,255,255,.05),transparent); animation:shimmer 1.5s infinite; border-radius:20px; pointer-events:none; }
    @keyframes shimmer { 0%{transform:translateX(-100%)} 100%{transform:translateX(100%)} }
    .currency-text { font-size:1.1rem; font-weight:700; color:var(--text-primary); overflow-wrap:break-word; }
    @media (min-width:768px) { .currency-text { font-size:1.25rem; } }
</style>

<div class="analytics-wrapper space-y-6">
    
    <div class="rounded-[18px] p-6 flex items-center justify-between flex-wrap gap-4" style="background:var(--bg-surface);box-shadow:var(--shadow-md);border:1px solid var(--border-color);">
        <div class="flex items-center gap-3">
            <svg class="w-6 h-6 shrink-0" style="color:#bf5fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
            </svg>
            <h1 style="color:var(--text-primary);font-weight:700;" class="text-sm sm:text-base lg:text-lg break-words">Dashboard Analisis Data Penjualan</h1>
        </div>
        <div class="flex flex-wrap gap-1.5 sm:gap-2">
            <button class="filter-btn px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold" style="background:#3b82f6;color:#fff;border:none;" onclick="setFilter('topup')">Top Up</button>
            <button class="filter-btn px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold" style="background:#00d4ff;color:#fff;border:none;" onclick="setFilter('joki')">Joki</button>
            <button class="filter-btn px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold" style="background:#7c3aed;color:#fff;border:none;" onclick="setFilter('jual beli akun')">Jual Beli Akun</button>
        </div>
    </div>

    
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-5">
        <div class="xl:col-span-3 grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-5">
            <div class="analytics-stat-card">
                <p class="text-sm font-medium truncate" style="color:var(--text-muted);">Total Penjualan</p>
                <p class="currency-text mt-1">Rp892.450.000</p>
            </div>
            <div class="analytics-stat-card">
                <p class="text-sm font-medium truncate" style="color:var(--text-muted);">Total Profit</p>
                <div class="flex items-baseline gap-2 mt-1">
                    <p class="currency-text">Rp215.300.000</p>
                    <span class="text-xs sm:text-sm font-semibold shrink-0" style="color:#10b981;">+24,1%</span>
                </div>
            </div>
            <div class="analytics-stat-card">
                <p class="text-sm font-medium truncate" style="color:var(--text-muted);">Total Pesanan</p>
                <p class="currency-text">2.847 <span class="text-sm font-medium" style="color:var(--text-muted);">Orders</span></p>
            </div>
        </div>
        <div class="analytics-card">
            <p class="text-xs font-bold tracking-widest mb-3" style="color:var(--text-muted);">BULAN</p>
            <select id="month-select" onchange="setMonth(this.value)" class="w-full px-3 py-2.5 rounded-xl text-sm font-semibold" style="background:var(--bg-surface-2);border:1px solid var(--border-color);color:var(--text-primary);outline:none;cursor:pointer;">
                <option value="0">Januari</option>
                <option value="1">Februari</option>
                <option value="2">Maret</option>
                <option value="3">April</option>
                <option value="4">Mei</option>
                <option value="5">Juni</option>
                <option value="6">Juli</option>
                <option value="7">Agustus</option>
                <option value="8">September</option>
                <option value="9">Oktober</option>
                <option value="10">November</option>
                <option value="11">Desember</option>
            </select>
        </div>
    </div>

    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <div class="lg:col-span-2 analytics-card chart-loading" id="chart1-container">
            <h3 class="text-sm font-bold mb-4" style="color:var(--text-primary);">Bulanan</h3>
            <div id="chart-bulanan"></div>
        </div>

        
        <div class="analytics-card chart-loading" id="chart2-container">
            <h3 class="text-sm font-bold mb-4" style="color:var(--text-primary);">Jenis Penjualan</h3>
            <div id="chart-jenis-penjualan"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <div class="lg:col-span-2 analytics-card chart-loading" id="chart3-container">
            <h3 class="text-sm font-bold mb-4" style="color:var(--text-primary);">10 Produk Terlaris</h3>
            <div id="chart-produk-terlaris"></div>
        </div>

        
        <div class="analytics-card chart-loading" id="chart4-container">
            <h3 class="text-sm font-bold mb-4" style="color:var(--text-primary);">Penjualan / Tahun</h3>
            <div id="chart-tahunan"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        
        <div class="lg:col-span-2 analytics-card chart-loading" id="chart5-container">
            <h3 class="text-sm font-bold mb-4" style="color:var(--text-primary);">Penjualan / Kategori</h3>
            <div id="chart-kategori"></div>
        </div>

        
        <div class="analytics-card chart-loading" id="chart6-container">
            <h3 class="text-sm font-bold mb-4" style="color:var(--text-primary);">Cara Pembayaran</h3>
            <div id="chart-pembayaran"></div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    var analyticsCharts = {};

    function getChartTheme() {
        var isDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        var body = document.body;
        if (body.classList.contains('dark')) isDark = true;
        if (body.classList.contains('light')) isDark = false;
        return {
            isDark: isDark,
            muted: isDark ? '#94a3b8' : '#888',
            border: isDark ? 'rgba(255,255,255,0.08)' : '#f0f0f0',
            tooltipBg: isDark ? '#1a1f40' : '#fff',
        };
    }

    function chartHeight() {
        return window.innerWidth < 640 ? 220 : 300;
    }

    function initAnalytics() {
        setTimeout(function() {
            renderBulananChart();
            renderJenisPenjualanChart();
            renderProdukTerlarisChart();
            renderTahunanChart();
            renderKategoriChart();
            renderPembayaranChart();
            removeChartLoaders();
        }, 200);
    }

    function removeChartLoaders() {
        document.querySelectorAll('.chart-loading').forEach(function(el) {
            el.classList.remove('chart-loading');
        });
    }

    function renderBulananChart() {
        var t = getChartTheme();
        var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        var options = {
            series: [
                { name: 'Penjualan', type: 'bar', data: [52000000,48000000,58000000,62000000,71000000,68000000,75000000,82000000,89000000,95000000,105000000,120000000] },
                { name: 'Profit', type: 'line', data: [12500000,11500000,14000000,15000000,17000000,16500000,18000000,20000000,21500000,23000000,25500000,29000000] },
                { name: 'Profit %', type: 'line', data: [24.0,24.0,24.1,24.2,23.9,24.3,24.0,24.4,24.2,24.2,24.3,24.2] }
            ],
            chart: { type: 'line', height: chartHeight(), toolbar: { show: false }, fontFamily: 'Poppins, sans-serif', animations: { enabled: true, easing: 'easeinout' }, background: 'transparent' },
            colors: ['#7c3aed', '#3b82f6', '#00d4ff'],
            stroke: { width: [0, 3, 3], curve: 'smooth', dashArray: [0, 0, 5] },
            fill: { opacity: [0.9, 1, 1], gradient: { type: 'vertical', shadeIntensity: 0.2, opacityFrom: 0.9, opacityTo: 0.9 } },
            labels: months,
            markers: { size: [0, 4, 0], strokeWidth: 0, hover: { size: 6 } },
            yaxis: [
                { title: { text: 'Rupiah', style: { fontSize: '11px', color: t.muted } }, labels: { formatter: function(v) { return 'Rp' + (v/1000000).toFixed(0) + 'jt'; }, style: { colors: t.muted, fontSize: '10px' } } },
                { opposite: true, title: { text: 'Persentase', style: { fontSize: '11px', color: t.muted } }, labels: { formatter: function(v) { return v + '%'; }, style: { colors: t.muted, fontSize: '10px' } }, max: 30 }
            ],
            xaxis: { labels: { style: { colors: t.muted, fontSize: '10px' } } },
            grid: { borderColor: t.border, strokeDashArray: 4 },
            tooltip: { shared: true, intersect: false, theme: t.isDark ? 'dark' : 'light', y: { formatter: function(v, o) { return o.seriesIndex === 2 ? v + '%' : 'Rp ' + v.toLocaleString('id-ID'); } } },
            legend: { position: 'top', horizontalAlign: 'center', fontSize: '12px', fontFamily: 'Poppins', labels: { colors: t.muted }, markers: { width: 10, height: 10, radius: 2 }, itemMargin: { horizontal: 10 } }
        };
        analyticsCharts.bulanan = new ApexCharts(document.querySelector('#chart-bulanan'), options);
        analyticsCharts.bulanan.render();
    }

    function renderJenisPenjualanChart() {
        var t = getChartTheme();
        var options = {
            series: [50, 30, 20],
            chart: { type: 'donut', height: chartHeight(), fontFamily: 'Poppins, sans-serif', animations: { enabled: true, easing: 'easeinout' }, background: 'transparent' },
            labels: ['Jual Beli Akun', 'Top Up', 'Joki'],
            colors: ['#7c3aed', '#3b82f6', '#00d4ff'],
            dataLabels: { enabled: true, formatter: function(v) { return v.toFixed(1) + '%'; }, style: { fontSize: '13px', fontWeight: 600, colors: ['#fff'] } },
            plotOptions: { pie: { donut: { size: '60%', labels: { show: true, total: { show: true, label: 'Total', formatter: function() { return '100%'; }, fontSize: '14px', fontWeight: 600, color: t.muted } } } } },
            legend: { position: 'bottom', fontSize: '12px', fontFamily: 'Poppins', labels: { colors: t.muted }, itemMargin: { horizontal: 8 } },
            responsive: [{ breakpoint: 480, options: { chart: { height: 250 }, legend: { position: 'bottom' } } }]
        };
        analyticsCharts.jenis = new ApexCharts(document.querySelector('#chart-jenis-penjualan'), options);
        analyticsCharts.jenis.render();
    }

    function renderProdukTerlarisChart() {
        var t = getChartTheme();
        var products = [
            'Johen MLBB', 'Johen PUBG', 'Johen Free Fire', 'Johen Valorant',
            'Johen Roblox', 'Johen E-Football', 'Monkey PUBG',
            'Top Up Packages', 'Joki Services', 'Bundle Promo'
        ];
        var values = [485, 420, 385, 340, 295, 260, 230, 520, 180, 145];
        var colors = ['#7c3aed', '#7c3aed', '#7c3aed', '#7c3aed', '#7c3aed', '#7c3aed', '#7c3aed', '#3b82f6', '#00d4ff', '#3b82f6'];
        var options = {
            series: [{ data: values }],
            chart: { type: 'bar', height: chartHeight() + 50, fontFamily: 'Poppins, sans-serif', toolbar: { show: false }, animations: { enabled: true, easing: 'easeinout' }, background: 'transparent' },
            colors: colors,
            plotOptions: { bar: { horizontal: true, borderRadius: 4, dataLabels: { position: 'top' }, distributed: true } },
            dataLabels: { enabled: true, formatter: function(v) { return 'Rp ' + v.toLocaleString('id-ID') + 'jt'; }, offsetX: 8, style: { fontSize: '11px', colors: [t.muted], fontWeight: 500 } },
            yaxis: { categories: products.reverse(), labels: { style: { colors: t.muted, fontSize: '11px', fontWeight: 500 } } },
            xaxis: { labels: { formatter: function(v) { return 'Rp ' + v.toLocaleString('id-ID') + 'jt'; }, style: { colors: t.muted, fontSize: '10px' } } },
            grid: { borderColor: t.border, strokeDashArray: 4 }
        };
        options.series[0].data = values.reverse();
        options.colors = colors.reverse();
        analyticsCharts.produk = new ApexCharts(document.querySelector('#chart-produk-terlaris'), options);
        analyticsCharts.produk.render();
    }

    function renderTahunanChart() {
        var t = getChartTheme();
        var options = {
            series: [
                { name: '2024', data: [45000000, 52000000, 48000000, 58000000, 62000000, 71000000, 68000000, 75000000, 82000000, 89000000, 95000000, 105000000] },
                { name: '2025', data: [65000000, 72000000, 78000000, 85000000, 92000000, 98000000, 105000000, 115000000, 120000000, 130000000, 145000000, 160000000] }
            ],
            chart: { type: 'area', height: chartHeight(), fontFamily: 'Poppins, sans-serif', toolbar: { show: false }, animations: { enabled: true, easing: 'easeinout' }, background: 'transparent' },
            colors: ['#7c3aed', '#3b82f6'],
            fill: { type: 'gradient', gradient: { shadeIntensity: 0.8, opacityFrom: 0.6, opacityTo: 0.1, stops: [0, 90, 100] } },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            markers: { size: 4, strokeWidth: 0, hover: { size: 6 } },
            xaxis: { categories: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'], labels: { style: { colors: t.muted, fontSize: '10px' } } },
            yaxis: { labels: { formatter: function(v) { return 'Rp' + (v/1000000).toFixed(0) + 'jt'; }, style: { colors: t.muted, fontSize: '10px' } } },
            grid: { borderColor: t.border, strokeDashArray: 4 },
            tooltip: { theme: t.isDark ? 'dark' : 'light', y: { formatter: function(v) { return 'Rp ' + v.toLocaleString('id-ID'); } } },
            legend: { position: 'top', horizontalAlign: 'center', fontSize: '12px', fontFamily: 'Poppins', labels: { colors: t.muted }, itemMargin: { horizontal: 10 } }
        };
        analyticsCharts.tahunan = new ApexCharts(document.querySelector('#chart-tahunan'), options);
        analyticsCharts.tahunan.render();
    }

    function renderKategoriChart() {
        var t = getChartTheme();
        var options = {
            series: [
                { data: [{ x: 'Jual Beli Akun', y: 50 }, { x: 'Top Up', y: 30 }, { x: 'Joki', y: 20 }] }
            ],
            chart: { type: 'treemap', height: chartHeight(), fontFamily: 'Poppins, sans-serif', toolbar: { show: false }, animations: { enabled: true, easing: 'easeinout' }, background: 'transparent' },
            colors: ['#7c3aed', '#3b82f6', '#00d4ff'],
            plotOptions: { treemap: { distributed: true, enableShades: true, shadeIntensity: 0.3 } },
            dataLabels: { enabled: true, formatter: function(v, o) { return o.series.x + '\n' + v + '%'; }, style: { fontSize: '13px', fontWeight: 600, colors: ['#fff'] } },
            legend: { show: true, position: 'bottom', fontSize: '12px', fontFamily: 'Poppins', labels: { colors: t.muted }, itemMargin: { horizontal: 8 } }
        };
        analyticsCharts.kategori = new ApexCharts(document.querySelector('#chart-kategori'), options);
        analyticsCharts.kategori.render();
    }

    function renderPembayaranChart() {
        var t = getChartTheme();
        var options = {
            series: [78, 22],
            chart: { type: 'donut', height: chartHeight(), fontFamily: 'Poppins, sans-serif', animations: { enabled: true, easing: 'easeinout' }, background: 'transparent' },
            labels: ['Transfer Bank (78%)', 'E-Wallet (22%)'],
            colors: ['#3b82f6', '#7c3aed'],
            dataLabels: { enabled: true, formatter: function(v) { return v.toFixed(0) + '%'; }, style: { fontSize: '16px', fontWeight: 700, colors: ['#fff'] } },
            plotOptions: { pie: { donut: { size: '60%', labels: { show: true, total: { show: true, label: 'Total', formatter: function() { return '100%'; }, fontSize: '14px', fontWeight: 600, color: t.muted } } } } },
            legend: { position: 'bottom', fontSize: '12px', fontFamily: 'Poppins', labels: { colors: t.muted }, itemMargin: { horizontal: 8 } },
            responsive: [{ breakpoint: 480, options: { chart: { height: 250 }, legend: { position: 'bottom' } } }]
        };
        analyticsCharts.pembayaran = new ApexCharts(document.querySelector('#chart-pembayaran'), options);
        analyticsCharts.pembayaran.render();
    }

    function setFilter(type) {
        document.querySelectorAll('.filter-btn').forEach(function(b) { b.style.opacity = '0.5'; });
        event.target.style.opacity = '1';
        showFloatingNotification('Filter: ' + type.charAt(0).toUpperCase() + type.slice(1), '#7c3aed');
    }

    function setMonth(month) {
        showFloatingNotification('Bulan: ' + document.getElementById('month-select').options[month].text, '#7c3aed');
    }

    function showFloatingNotification(msg, color) {
        var el = document.createElement('div');
        el.style.cssText = 'position:fixed;bottom:24px;right:24px;z-index:9999;padding:12px 20px;border-radius:12px;background:' + color + ';color:#fff;font-size:13px;font-weight:500;font-family:Poppins,sans-serif;box-shadow:0 4px 20px rgba(0,0,0,0.2);opacity:0;transform:translateY(10px);transition:all 0.3s ease;';
        el.textContent = msg;
        document.body.appendChild(el);
        requestAnimationFrame(function() { el.style.opacity = '1'; el.style.transform = 'translateY(0)'; });
        setTimeout(function() { el.style.opacity = '0'; el.style.transform = 'translateY(10px)'; setTimeout(function() { el.remove(); }, 300); }, 2500);
    }
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\backend-johenofficesystem\resources\views\admin\partials\analytics-tab.blade.php ENDPATH**/ ?>