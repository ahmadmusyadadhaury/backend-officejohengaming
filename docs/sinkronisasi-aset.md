# Panduan Sinkronisasi Aset (JSA ← Database Office)

Sistem **backend-johen-jsa** (JSA) menarik data aset dari database sistem
office (yang di-hosting di Hostinger) melalui **koneksi MySQL langsung** —
pola yang sama dengan sinkronisasi jadwal meeting (`meetings:sync`).
Sinkronisasi ini **hanya membaca data (read-only)** — tidak mengubah data di
database sumber.

Berjalan otomatis setiap jam via `Schedule::command('assets:sync')->hourly()`,
dan dapat dijalankan manual dengan `php artisan assets:sync`.

---

## 1. Prasyarat: SSH Tunnel ke Database Office

Hostinger shared hosting tidak mengizinkan koneksi MySQL dari luar, jadi
gunakan SSH tunnel agar DB office "terlihat" di port lokal 3307:

```bash
ssh -p 65002 -N -L 3307:127.0.0.1:3306 u623380726@153.92.11.22
```

> Jaga jendela tunnel tetap terbuka selama JSA berjalan. File `tunnel.bat` di
> repo JSA berisi perintah yang sama.

### 1.1 Koneksi `office` di `.env` JSA

```env
DB_OFFICE_HOST=127.0.0.1
DB_OFFICE_PORT=3307
DB_OFFICE_DATABASE=u623380726_meeting_db
DB_OFFICE_USERNAME=u623380726_meeting
DB_OFFICE_PASSWORD=...
```

Config ini sudah dipakai bersama oleh `meetings:sync` dan `assets:sync`
(lihat `config/database.php` → koneksi `office`).

---

## 2. Data yang Disinkronkan

JSA membaca 9 tabel office dan menyimpannya ke tabel `assets` lokal:

| Tabel office | Kategori JSA | Kode di JSA | Keterangan |
|--------------|--------------|-------------|------------|
| `peralatan_kantor` | Peralatan Kantor / Kendaraan | `PK-<kode>` | `jumlah > 1` di-expand per unit (`PK-xxx-2`, `-3`, dst) |
| `aset_tim` | Aset Tim | `TIM-<id>` | expand per unit bila `jumlah > 1` |
| `aset_mes` | Aset Mes | `MES-<id>` | expand per unit bila `jumlah > 1` |
| `aset_saya` (fallback `aset_daya`) | Aset Saya | `SAYA-<id>` | fallback otomatis jika migrasi rename belum di-deploy |
| `assets` | Peralatan Kantor | `AST-<id>` | aset general |
| `vehicles` | Kendaraan | `VEH-<plat_nomor>` | |
| `sim_cards` | SIM Card | `SIM-<nomor_sim_card>` | |
| `digital_assets` | Digital | `DIG-<id>` | |
| `users` | — | — | referensi PIC (`id`, `name`, `username`, `nik`, `role`) |

> Catatan: di database office, tabel `aset_daya` sudah di-rename menjadi
> `aset_saya` (perbaikan typo). Jika rename belum dijalankan di server,
> sinkronisasi otomatis memakai `aset_daya`.

---

## 3. Cara Kerja `assets:sync`

1. **Koneksi** ke koneksi `office`; gagal → error berisi petunjuk SSH tunnel.
2. **Lookup PIC**: baca tabel `users` office, lalu petakan
   `employees.nik` → `user_id` JSA dan `employees.nama` / `users.name` →
   `user_id` JSA (normalisasi: lowercase, spasi rapat).
3. **Kategori**: 8 kategori JSA dibuat otomatis bila belum ada
   (Kendaraan, SIM Card, Peralatan Kantor, Asset Ruko, Aset Tim, Aset Mes,
   Aset Saya, Digital).
4. **Upsert by code**: kode sudah ada → update; belum ada → insert
   (`status = 'tersedia'`, `created_by` dari resolusi PIC).
5. **Prune**: kode yang ada di cache (30 hari) tapi tidak muncul lagi →
   dihapus dari tabel `assets` JSA.

### Resolusi `created_by`

Prioritas:

1. `penanggung_jawab` (id user office) → `users.nik` office → cocok ke
   `employees.nik` JSA → `user_id`.
2. Nama PIC (normalisasi) → cocok ke `employees.nama` atau `users.name` JSA.
3. Gagal semua → `JOHEN_OFFICE_DEFAULT_USER` (id user JSA, default `1`).

### Verifikasi hasil

```bash
php artisan assets:sync
```

Output:

```
Sinkronisasi aset selesai. Total: 888
- peralatan-kantor: 867
- aset-tim: 2
- aset-mes: 4
- aset-saya: 3
- assets: 6
- vehicles: 1
- sim-cards: 1
- digital-assets: 4
```

---

## 4. Service & Command Terkait

| File (repo JSA) | Peran |
|-----------------|-------|
| `app/Services/OfficeAssets.php` | Membaca tabel office via koneksi `office` (dipakai juga oleh halaman UI aset) |
| `app/Services/SyncAssets.php` | Mapping, expand qty, upsert, prune, resolusi `created_by` |
| `app/Console/Commands/SyncAssetsCommand.php` | Command `assets:sync` |
| `routes/console.php` | `Schedule::command('assets:sync')->hourly()` |

---

## 5. Troubleshooting

| Masalah | Solusi |
|---------|--------|
| `Gagal terhubung ke database office` | SSH tunnel belum aktif — jalankan `tunnel.bat` atau perintah ssh di atas. |
| Data kosong / 0 aset | Pastikan tabel aset ada di DB office (`aset_saya` / fallback `aset_daya`). |
| `created_by` banyak fallback ke default | Nama PIC di office tidak cocok dengan `employees.nama`/`users.name` di JSA. Perbaiki data PIC atau sesuaikan `JOHEN_OFFICE_DEFAULT_USER`. |
| Data hilang setelah sinkron | Aset yang dihapus di office ikut terhapus di JSA pada sinkronisasi berikutnya (prune). |
