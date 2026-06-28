# Panduan Fitur Approval Pembayaran

> Dokumen ini menjelaskan alur kerja **(workflow)** approval pembayaran yang melibatkan Staff/Koordinator sebagai pengaju dan GM/CEO sebagai pemberi persetujuan.

---

## 1. Alur Lengkap

```
Staff bayar tagihan ➔ Upload bukti via form ➔ Status "Menunggu Persetujuan"
    ➔ Notifikasi ke GM & CEO
    ➔ GM/CEO buka halaman Persetujuan ➔ Setujui / Tolak
    ➔ Notifikasi ke Staff (hasil approval)
```

---

## 2. Untuk Staff / Koordinator / HR

### A. Melihat & Membayar Tagihan (Daftar yang Sudah Tercatat)

> **Staff / Koordinator / HR** bisa melihat tagihan yang sudah tercatat di sistem dan langsung membayarnya.

1. **Sidebar kiri** ➔ klik **"Tagihan"**
2. Tabel menampilkan semua tagihan dengan status **Jatuh Tempo** (belum dibayar)
3. Klik tombol **"Bayar"** pada tagihan yang ingin dibayar
4. Akan muncul modal:
   - Detail tagihan (nama/periode + nominal)
   - **Tanggal Bayar** — otomatis hari ini, bisa diubah
   - **Upload Bukti Bayar** — pilih file gambar (JPEG/PNG, maks 2MB)
5. Klik **"Kirim"**
6. Status berubah menjadi **"Menunggu"** (`pending`)
7. Notifikasi otomatis terkirim ke GM & CEO

### B. Mengajukan Pembayaran Baru (Tagihan Belum Tercatat)

> Untuk tagihan yang **belum ada** di sistem, bisa dibuat baru.

1. **Sidebar kiri** ➔ klik **"Ajukan Pembayaran"**
2. **Pilih Jenis Pembayaran** (Internet / Listrik / Aset Digital / IPL Ruko)
3. **Isi detail tagihan** — form akan menyesuaikan dengan jenis yang dipilih:
   - **Internet**: Nama Internet, Provider, PIC, Jabatan, Masa Tenggang, Biaya
   - **Listrik / Aset Digital / IPL Ruko**: Periode, Nominal, Tanggal Tagihan, Jatuh Tempo
4. **Tanggal Bayar** — isi tanggal saat kamu melakukan pembayaran
5. **Upload Bukti Bayar** — pilih file gambar (JPEG/PNG, maks 2MB)
6. Klik tombol **"Ajukan Pembayaran"**
7. Status pengajuan akan menjadi **"Menunggu"** (`pending`)
8. Notifikasi otomatis terkirim ke seluruh user dengan role **GM** dan **CEO**

### B. Cek Status Pengajuan

1. **Sidebar kiri** ➔ klik **"Status Pengajuan"**
2. Tabel menampilkan semua pengajuan milik kamu yang login
3. Warna status:
   - 🟢 **Disetujui** (`lunas`) — sudah di-approve oleh GM/CEO
   - 🟡 **Menunggu** (`pending`) — masih menunggu approval
   - 🔴 **Ditolak** (`rejected`) — ditolak oleh GM/CEO, lihat kolom **Approval** untuk alasan
4. Klik **"Lihat"** pada kolom Bukti untuk preview gambar bukti bayar
5. Klik tombol **"Ajukan Baru"** di pojok kanan atas untuk pengajuan berikutnya

---

## 3. Untuk GM / CEO

### A. Melihat Daftar Pengajuan

1. **Login** akun **GM** atau **CEO**
2. **Sidebar kiri** ➔ **Pembayaran ➔ Persetujuan**
3. Semua pengajuan dengan status **"Menunggu"** akan tampil otomatis
4. Urutan dari yang terbaru (paling atas)

### B. Menyetujui Pembayaran

1. Klik tombol **"Setujui"** (hijau) pada baris pengajuan
2. Kotak konfirmasi muncul ➔ klik **OK**
3. Status berubah menjadi **"Lunas"** (`lunas`)
4. Staff pengaju mendapat notifikasi bahwa pembayaran disetujui

### C. Menolak Pembayaran

1. Klik tombol **"Tolak"** (merah) pada baris pengajuan
2. Akan muncul modal **"Tolak Pengajuan"**
3. Isi **Alasan Ditolak** (wajib diisi, maks 1000 karakter)
4. Klik **"Tolak"** untuk konfirmasi
5. Status berubah menjadi **"Ditolak"** (`rejected`)
6. Staff pengaju mendapat notifikasi + alasan penolakan

### D. Langsung Set Lunas (Tanpa Proses Approval)

> **Khusus GM/CEO**: Lewat halaman **Pembayaran ➔ [jenis]** (misal Internet), kamu bisa langsung mengubah status tanpa melalui form approval.

**Via Detail Modal:**
1. Klik baris tagihan ➔ muncul detail
2. Klik tombol **"Bayar / Lunaskan"** ➔ status langsung jadi Lunas

**Via Edit:**
1. Klik ikon **titik tiga** pada baris ➔ **Edit**
2. Ubah dropdown **Status** menjadi **"Lunas"**
3. Pastikan **Tanggal Bayar** terisi
4. Klik **"Simpan Perubahan"**

**Via Tombol Bayar Langsung (di baris tabel):**
1. Klik tombol **Bayar** (ikon Rp) pada baris tagihan
2. Isi **Tanggal Bayar**
3. Klik **"Lunaskan"** ➔ status langsung jadi Lunas

---

## 4. Untuk Admin (Full Access)

| Role | Bisa Lihat Persetujuan? | Bisa Approve/Reject? |
|------|------------------------|---------------------|
| Admin | ✅ Ya | ❌ Tidak |
| Head of Store | ✅ Ya | ❌ Tidak |
| HR | ✅ Ya | ❌ Tidak |

Admin tetap bisa **mengelola tagihan** langsung (tambah/edit/hapus/set lunas) melalui menu **Pembayaran** seperti biasa.

---

## 5. Daftar Status Pembayaran

| Status | Badge | Arti |
|--------|-------|------|
| `lunas` | 🟢 Lunas | Sudah dibayar dan sudah disetujui |
| `jatuh_tempo` | 🟡 Jatuh Tempo / Terlambat | Belum dibayar |
| `pending` | 🔵 Menunggu | Sudah diajukan, menunggu persetujuan GM/CEO |
| `rejected` | 🔴 Ditolak | Ditolak oleh GM/CEO (ada alasan di catatan) |

---

## 6. Data & Kolom Database

Setiap tabel pembayaran (`wifi_payments`, `payments`, `pembayaran_aset_digital`, `pembayaran_ipl_ruko`) mendapat tambahan kolom:

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `requested_by` | FK → `users.id` | ID user yang mengajukan (staff/koordinator) |
| `approved_by` | FK → `users.id` | ID user yang menyetujui (GM/CEO) |
| `approved_at` | timestamp | Waktu persetujuan |
| `bukti_bayar` | string (path) | Path file gambar bukti bayar |
| `notes` | text | Alasan penolakan (jika ditolak) |

---

## 7. Reset Data Existing

Saat fitur ini pertama kali dijalankan, semua data pembayaran yang sebelumnya berstatus **"Lunas"** di-reset menjadi **"Menunggu"** (`pending`). Hal ini dilakukan agar seluruh pembayaran mendapatkan persetujuan dari GM/CEO.

GM/CEO dapat:
- Menyetujui satu per satu dari halaman **Persetujuan**
- Atau langsung mengubah status dari halaman **Pembayaran ➔ [jenis]** ➔ klik baris ➔ **Bayar / Lunaskan**

---

## 8. Notifikasi

| Kejadian | Penerima | Isi Notifikasi |
|----------|----------|----------------|
| Staff mengajukan pembayaran | Semua user role **GM** & **CEO** | "Pengajuan pembayaran [jenis]: [detail] menunggu approval." |
| GM/CEO menyetujui | **Staff pengaju** | "Pembayaran [jenis] ([detail]) telah disetujui oleh [nama]." |
| GM/CEO menolak | **Staff pengaju** | "Pembayaran [jenis] ([detail]) ditolak. Alasan: [alasan]." |

---

## 9. Catatan Penting

- **GM** dan **CEO** adalah satu-satunya role yang bisa approve/reject
- File bukti bayar disimpan di `storage/app/public/payment-bukti/`
- Token listrik **tidak** termasuk dalam flow approval — tetap langsung seperti biasa
- Staff hanya bisa melihat pengajuan miliknya sendiri
- GM/CEO bisa melihat semua pengajuan yang menunggu
- Semua role full-access bisa melihat halaman Persetujuan, tapi hanya GM/CEO yang tombolnya muncul
