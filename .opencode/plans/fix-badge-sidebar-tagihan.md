# Rencana: Sinkronisasi Badge Sidebar (Tagihan & Approval) dengan Data Nyata

## Masalah
Badge merah sidebar tidak sama dengan isi menu Tagihan (mis. halaman 7 item, badge angka lain) karena ada 3 logika hitung berbeda:

1. **Render awal** — blok `@php` di `resources/views/partials/sidebar-{admin,leader,user}.blade.php`: 5 model, exclude hanya `lunas/rejected`, jatuh tempo `≤ hari ini+7` (ikut masa depan), tanpa pajak kendaraan, admin tanpa scoping PIC.
2. **Polling JS** — `RealtimeController::notifCount()` baris 142: menghitung baris tabel `notifications` (type=tagihan/approval, belum dibaca). Notifikasi dibuat lazy (jendela ±7 hari, cache 5 menit) dan tetap terhitung walau tagihan sudah lunas sampai dibaca manual.
3. **Halaman Tagihan** — `PaymentApprovalController::tagihan()` baris 215: 6 jenis termasuk pajak kendaraan, internet/IPL/TIM/MES wajib lewat jatuh tempo (`< today`), aset digital & pajak tanpa filter tanggal, scoping PIC non-full-access. → inilah patokan yang benar.

## Solusi: satu sumber kebenaran

### 1. Service baru `app/Services/TagihanService.php`
- `JENIS_MODELS` map 6 jenis → model (internet/aset_digital/pajak_kendaraan/ipl_ruko/aset_tim/aset_mes)
- `syncVehiclePajakRequests()` — logika auto-buat pengajuan pajak kendaraan (dipindah utuh dari `tagihan()` baris 225-257)
- `itemsQuery(string $jenis): Builder` — query persis seperti halaman:
  - base: `whereNull('requested_by')`, `whereNotIn('status', ['lunas','rejected','menunggu'])`
  - internet/IPL/TIM/MES: `where($dateField, '<', today())` (`masa_tenggang` untuk internet)
  - aset_digital & pajak_kendaraan: tanpa filter tanggal + scoping PIC untuk non-full-access
  - aset_tim/mes: `whereIn` aset milik user
- `tagihanCount(): int` — jumlah count 6 jenis (badge Tagihan)
- `approvalCount(): int` — jumlah `status='pending'` di 6 model (badge Approval)
- `cleanupStaleNotifications(int $userId)` — notifikasi belum-dibaca type tagihan/approval:
  - dedup_key cocok `^(tagihan|approval)_(tabel)_(id)$` → cek record masih relevan (tagihan: requested_by null & status bukan lunas/rejected/menunggu; approval: status pending); jika tidak → tandai dibaca
  - legacy tanpa dedup_key → langsung ditandai dibaca

### 2. `PaymentApprovalController::tagihan()`
- Ganti loop vehicle inline → `TagihanService::syncVehiclePajakRequests()`
- Ganti query builder per jenis → `TagihanService::itemsQuery($jenis)` (pemetaan/format data tetap sama)

### 3. `RealtimeController::notifCount()`
- Awal method: `TagihanService::cleanupStaleNotifications(auth()->id())` + `TagihanService::syncVehiclePajakRequests()`
- `'total_tagihan' => TagihanService::tagihanCount()`
- `'total_pending_approvals' => in_array(role, ['admin','head_of_store','hr','gm','ceo']) ? TagihanService::approvalCount() : 0`
- `checkDueTagihan()` / `checkPendingApprovals()` tetap jalan khusus feed dropdown notifikasi

### 4. Partial sidebar (3 file)
- `sidebar-admin.blade.php`: `$totalTagihan = TagihanService::tagihanCount()`; `$totalApproval` = approver-gated `approvalCount()`
- `sidebar-leader.blade.php` & `sidebar-user.blade.php`: `$totalTagihan = TagihanService::tagihanCount()`

## Verifikasi
- `php -l` semua file PHP yang diubah
- `php artisan view:cache` + `view:clear`
- Uji tinker: `TagihanService::tagihanCount()` vs jumlah item aktual; pastikan cleanup tidak menandai notif valid

## Efek
- Badge merah = persis jumlah item halaman, render awal maupun polling
- Badge hilang otomatis ≤1 siklus polling setelah tagihan dibayar/diproses
- Dropdown notifikasi ikut bersih dari notif basi
