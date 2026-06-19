# 📋 User Guide — Meeting Room Booking System
### Johen Gaming | Sistem Pemesanan Ruang Meeting

---

## Daftar Isi

1. [Pengenalan Sistem](#1-pengenalan-sistem)
2. [Akses & Login](#2-akses--login)
3. [Peran Pengguna (Role)](#3-peran-pengguna-role)
4. [Dashboard](#4-dashboard)
   - [Admin / HR / Head of Store / GM](#41-dashboard-admin--hr--head-of-store--gm)
   - [Koordinator](#42-dashboard-koordinator)
   - [Karyawan (User)](#43-dashboard-karyawan-user)
5. [Kalender Meeting](#5-kalender-meeting)
6. [Request Meeting (Koordinator & Leader)](#6-request-meeting-koordinator--leader)
7. [Manajemen Meeting (Admin & HR)](#7-manajemen-meeting-admin--hr)
8. [Meeting Mingguan](#8-meeting-mingguan)
9. [Undangan Meeting](#9-undangan-meeting)
10. [Minutes of Meeting (MoM)](#10-minutes-of-meeting-mom)
11. [Kelola Tim](#11-kelola-tim)
12. [Kelola Ruangan](#12-kelola-ruangan)
13. [Kelola Aset](#13-kelola-aset)
14. [Kelola Akun Pengguna](#14-kelola-akun-pengguna)
15. [Profil & Password](#15-profil--password)
16. [Sistem Antrian Meeting](#16-sistem-antrian-meeting)
17. [Status Meeting](#17-status-meeting)

---

## 1. Pengenalan Sistem

Meeting Room Booking System adalah aplikasi berbasis web untuk mengelola pemesanan ruang meeting di Johen Gaming. Sistem ini memungkinkan koordinator dan leader mengajukan permintaan meeting, admin/HR menyetujui, serta seluruh karyawan dapat melihat jadwal meeting melalui kalender.

**Fitur Utama:**
- Pemesanan ruang meeting dengan validasi konflik waktu
- Sistem antrian otomatis jika ruangan bentrok
- Kalender interaktif real-time
- Notifikasi undangan meeting
- Meeting mingguan berulang otomatis
- Minutes of Meeting (MoM / Notulen)
- Manajemen tim, ruangan, aset, dan akun pengguna

---

## 2. Akses & Login

### Cara Login
1. Buka browser dan akses URL aplikasi
2. Masukkan **Username** dan **Password**
3. Klik tombol **Masuk**

> ⚠️ Sistem menggunakan **username**, bukan email.

### Lupa Password
Hubungi Admin Master atau HR untuk mereset password akun Anda.

---

## 3. Peran Pengguna (Role)

Sistem memiliki 6 peran dengan hak akses yang berbeda:

| Role | Sebutan | Hak Akses |
|---|---|---|
| `admin` | Admin Master | Akses penuh ke semua fitur |
| `hr` | HR | Akses penuh + kelola akun karyawan |
| `head_of_store` | Head of Store | Dashboard admin, request meeting, kalender |
| `gm` | General Manager | Dashboard admin, request meeting, kalender |
| `koordinator` | Koordinator | Request & kelola meeting tim, kalender |
| `user` | Karyawan | Dashboard, kalender, lihat undangan |

### Perbedaan Akses Fitur

| Fitur | Admin | HR | Head of Store | GM | Koordinator | Karyawan |
|---|:---:|:---:|:---:|:---:|:---:|:---:|
| Permintaan Meeting (approve) | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Kelola Ruangan | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Meeting Mingguan | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Kelola Tim | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ |
| Kelola Aset | ✅ | ✅ | ✅ | ✅ | ❌ | ❌ |
| Kelola Akun Karyawan | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ |
| Kelola Akun Admin | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ |
| Request Meeting | ✅ | ✅ | ✅ | ✅ | ✅ | ❌ |
| Kalender | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| Undangan Meeting | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |

---

## 4. Dashboard

### 4.1 Dashboard Admin / HR / Head of Store / GM

Dashboard menampilkan ringkasan statistik dan informasi penting:

**Breakdown Akun:**
- Jumlah Karyawan aktif
- Jumlah Koordinator aktif
- Jumlah Head of Store aktif
- Jumlah General Manager aktif
- Jumlah HR aktif

**Statistik Meeting:**
- Total Tim
- Meeting Menunggu Approval
- Meeting Hari Ini
- Meeting Bulan Ini
- Total Ruangan

**Panel Informasi:**
- **Menunggu Approval** — daftar 5 meeting terbaru yang menunggu persetujuan (khusus Admin & HR)
- **Meeting Hari Ini** — daftar meeting yang berlangsung hari ini
- **Undangan Meeting Saya** — undangan aktif untuk Head of Store, GM, dan HR

> 🔄 Statistik diperbarui otomatis setiap **60 detik**.

---

### 4.2 Dashboard Koordinator

Dashboard menampilkan:

**Statistik Meeting Saya:**
- Menunggu persetujuan
- Disetujui
- Selesai
- Dibatalkan

**Panel Informasi:**
- **Meeting Mendatang** — meeting yang sudah disetujui dan akan datang, lengkap dengan status real-time
- **Riwayat Meeting** — 5 meeting terakhir beserta statusnya
- **Tombol Request Meeting** — shortcut untuk mengajukan meeting baru

> 🔄 Status meeting diperbarui otomatis setiap **30 detik**.

---

### 4.3 Dashboard Karyawan (User)

Dashboard menampilkan:
- **Profil** — nama, role, tim, dan username
- **Meeting Saya** — meeting mendatang yang kamu diundang
- **Meeting Hari Ini** — semua meeting yang berlangsung hari ini

---

## 5. Kalender Meeting

Kalender menampilkan semua jadwal meeting secara visual dan interaktif.

### Cara Mengakses
Klik menu **Kalender** di sidebar atau tombol **KALENDER** di topbar.

### Tampilan Kalender

| Tampilan | Keterangan |
|---|---|
| **Minggu** | Tampilan grid per minggu dengan slot waktu |
| **Bulan** | Tampilan grid per bulan |
| **Hari** | Tampilan detail satu hari penuh |
| **List** | Tampilan daftar event per minggu |

### Navigasi
- Tombol **◀ ▶** — pindah periode sebelumnya/berikutnya
- Tombol **Hari Ini** — kembali ke tanggal hari ini
- **Mini Calendar** (sidebar kiri, desktop) — klik tanggal untuk langsung loncat ke hari tersebut

### Filter Tanggal
1. Masukkan tanggal di kolom filter
2. Klik **Cari** — kalender akan loncat ke tanggal tersebut dalam tampilan Hari
3. Klik **Reset** — kembali ke tampilan normal

### Legenda Warna

| Warna | Status |
|---|---|
| 🔵 Biru | Di Booking (belum berlangsung) |
| 🟣 Ungu | Sedang Berlangsung |
| 🟠 Oranye | Dalam Antrian |
| ⚫ Abu-abu | Selesai |
| 🩵 Cyan | Meeting Mingguan |

### Detail Event
Klik event di kalender untuk melihat detail:
- Judul meeting
- Ruangan
- Tim
- Jam mulai & selesai
- Jam selesai aktual (jika sudah selesai)
- Status real-time

> 🔄 Status event diperbarui otomatis setiap **30 detik**.

---

## 6. Request Meeting (Koordinator & Leader)

### Siapa yang Bisa Request?
Koordinator, Head of Store, GM, HR, dan Admin.

### Cara Mengajukan Meeting

1. Klik **Request Meeting** di sidebar
2. Isi formulir berikut:

| Field | Keterangan |
|---|---|
| **Judul Meeting** | Nama/topik meeting |
| **Ruangan** | Pilih ruangan yang tersedia |
| **Tanggal** | Tanggal pelaksanaan (tidak boleh tanggal lampau) |
| **Jam Mulai** | Waktu mulai meeting |
| **Jam Selesai** | Waktu selesai meeting |
| **Tujuan (Why)** | Alasan/latar belakang meeting |
| **Agenda (What)** | Apa yang akan dibahas |
| **Hasil yang Diharapkan (How)** | Target/output meeting |
| **Tim Tambahan** | Tim lain yang diundang (opsional) |
| **Aset** | Peralatan yang dibutuhkan (opsional) |
| **File Lampiran** | Dokumen pendukung PDF/DOC (opsional, maks 10MB) |

3. Klik **Kirim Request**
4. Meeting akan masuk status **Menunggu Persetujuan** dan dikirim ke Admin/HR

### Validasi Otomatis
Sistem akan menolak request jika:
- Kamu sudah memiliki meeting di waktu yang sama
- Ruangan sudah dibooking orang lain di waktu yang sama (dengan status aktif di antrian 0)

### Melihat Daftar Meeting
Klik **Meeting Saya** di sidebar untuk melihat semua meeting yang pernah diajukan beserta statusnya.

### Konfirmasi Kehadiran
Setelah meeting disetujui, kamu bisa klik **Konfirmasi Kehadiran** di halaman detail meeting untuk mengubah status menjadi `confirmed`.

### Membatalkan Meeting
Klik **Batalkan** di halaman detail meeting. Meeting yang sudah dibatalkan tidak bisa diaktifkan kembali.

### Menyelesaikan Meeting
Setelah meeting selesai, klik **Selesaikan Meeting** dan masukkan jam selesai aktual. Sistem akan otomatis menggeser antrian berikutnya.

---

## 7. Manajemen Meeting (Admin & HR)

> ⚠️ Fitur ini hanya untuk **Admin** dan **HR**.

### Melihat Semua Permintaan
1. Klik **Permintaan Meeting** di sidebar
2. Daftar semua meeting dari semua koordinator/leader ditampilkan
3. Klik **Detail** untuk melihat informasi lengkap

### Menyetujui Meeting
1. Buka halaman detail meeting
2. Klik tombol **Setujui**
3. Sistem otomatis:
   - Mengubah status menjadi `approved`
   - Menentukan posisi antrian jika ada konflik waktu
   - Mengirim undangan ke semua anggota tim yang terlibat

### Menolak Meeting
1. Buka halaman detail meeting
2. Klik tombol **Tolak**
3. Isi **alasan penolakan**
4. Klik **Konfirmasi Tolak**

---

## 8. Meeting Mingguan

Meeting mingguan adalah meeting berulang yang terjadwal setiap minggu secara otomatis.

> ⚠️ Kelola Meeting Mingguan hanya untuk **Admin** dan **HR**.

### Membuat Meeting Mingguan
1. Klik **Meeting Mingguan** di sidebar
2. Klik **Tambah Meeting Mingguan**
3. Isi:
   - **Judul** — nama meeting mingguan
   - **Ruangan** — ruangan yang digunakan
   - **Hari** — hari dalam seminggu (Senin–Minggu)
   - **Jam Mulai & Selesai**
4. Klik **Simpan**

### Cara Kerja Otomatis
- Setiap hari, sistem otomatis membuat **sesi** untuk meeting mingguan yang terjadwal hari itu
- Undangan otomatis dikirim ke **semua pengguna aktif**
- Sesi yang sudah lewat waktunya otomatis ditandai **Selesai**

### Fitur Sesi Meeting Mingguan
Pengguna dengan role koordinator, head_of_store, gm, admin, atau hr dapat:

| Aksi | Keterangan |
|---|---|
| **Tambah Kontribusi** | Menambahkan topik/agenda yang ingin dibahas |
| **Perpanjang Waktu** | Menambah durasi meeting (maks 240 menit) |
| **Selesaikan** | Menandai meeting sebagai selesai secara manual |

---

## 9. Undangan Meeting

### Melihat Undangan
Undangan aktif muncul di:
- **Topbar** — ikon amplop dengan badge merah (jumlah undangan belum dibaca)
- **Sidebar** — menu **Undangan** (muncul jika ada undangan aktif)

### Detail Undangan
Klik undangan untuk melihat:
- Judul dan detail meeting
- Ruangan, tim, tanggal, jam
- Status meeting saat ini

> Undangan otomatis hilang dari daftar setelah meeting selesai, dibatalkan, atau ditolak.

### Undangan Meeting Mingguan
Undangan meeting mingguan muncul terpisah dan dapat diakses melalui menu **Undangan** di topbar. Di halaman detail, pengguna yang berwenang dapat menambah kontribusi, memperpanjang waktu, atau menyelesaikan sesi.

---

## 10. Minutes of Meeting (MoM)

MoM adalah notulen resmi hasil meeting yang dibuat oleh koordinator setelah meeting selesai.

### Membuat MoM
1. Buka halaman detail meeting (dari **Meeting Saya**)
2. Klik **Buat MoM**
3. Isi:

| Field | Keterangan |
|---|---|
| **Ringkasan** | Rangkuman jalannya meeting |
| **Keputusan** | Keputusan yang diambil |
| **Rencana Tindak Lanjut** | Action plan ke depan |
| **Penanggung Jawab (PIC)** | Nama yang bertanggung jawab |
| **File Lampiran** | Dokumen MoM (opsional, PDF/DOC) |

4. Klik **Simpan sebagai Draft** atau **Kirim**

### Status MoM
| Status | Keterangan |
|---|---|
| `draft` | Belum dikirim, masih bisa diedit |
| `sent` | Sudah dikirim, tidak bisa diedit |

---

## 11. Kelola Tim

> ⚠️ Fitur ini untuk **Admin**, **HR**, **Head of Store**, dan **GM**.

### Menambah Tim
1. Klik **Kelola Tim** di sidebar
2. Klik **Tambah Tim**
3. Isi nama dan deskripsi tim
4. Klik **Simpan**

### Mengedit / Menghapus Tim
- Klik ikon **Edit** atau **Hapus** pada baris tim yang ingin diubah

---

## 12. Kelola Ruangan

> ⚠️ Fitur ini hanya untuk **Admin** dan **HR**.

### Menambah Ruangan
1. Klik **Kelola Ruangan** di sidebar
2. Klik **Tambah Ruangan**
3. Isi:

| Field | Keterangan |
|---|---|
| **Nama Ruangan** | Nama identifikasi ruangan |
| **Kapasitas** | Jumlah maksimal peserta |
| **Fasilitas** | Daftar fasilitas (Proyektor, AC, dll) |
| **Lokasi** | Lokasi/lantai ruangan |
| **Deskripsi** | Keterangan tambahan |
| **Status Aktif** | Aktif/nonaktif |

4. Klik **Simpan**

### Menonaktifkan Ruangan
Ruangan yang dinonaktifkan tidak akan muncul di pilihan saat request meeting.

---

## 13. Kelola Aset

> ⚠️ Fitur ini untuk **Admin**, **HR**, **Head of Store**, dan **GM**.

Aset adalah peralatan yang bisa dipinjam saat meeting (TV, Speaker, Proyektor, dll).

### Menambah Aset
1. Klik **Kelola Aset** di sidebar
2. Klik **Tambah Aset**
3. Isi nama, jumlah stok, dan status aktif
4. Klik **Simpan**

---

## 14. Kelola Akun Pengguna

### Kelola Akun Karyawan & Koordinator
> ⚠️ Hanya **Admin** dan **HR**.

1. Klik **Kelola Akun** di sidebar
2. Klik **Tambah Akun**
3. Isi:

| Field | Keterangan |
|---|---|
| **Nama** | Nama lengkap pengguna |
| **Username** | Username untuk login (unik) |
| **Password** | Minimal 8 karakter |
| **Role** | Pilih role pengguna |
| **Tim** | Tim yang diikuti (untuk koordinator & karyawan) |
| **Status Aktif** | Aktif/nonaktif |

4. Klik **Simpan**

### Kelola Akun Admin
> ⚠️ Hanya **Admin Master**.

Sama seperti kelola akun karyawan, namun khusus untuk membuat akun dengan role admin, head_of_store, gm, atau hr.

### Menonaktifkan Akun
Akun yang dinonaktifkan tidak bisa login ke sistem.

---

## 15. Profil & Password

### Mengubah Profil
1. Klik nama pengguna atau menu **Profil Saya** di sidebar
2. Ubah **Nama** atau upload **Foto Profil** (JPG/PNG, maks 2MB)
3. Klik **Simpan**

### Mengubah Password
1. Buka halaman **Profil Saya**
2. Masukkan **Password Saat Ini**
3. Masukkan **Password Baru** (minimal 8 karakter)
4. Masukkan **Konfirmasi Password Baru**
5. Klik **Ubah Password**

---

## 16. Sistem Antrian Meeting

Sistem antrian bekerja otomatis ketika ada dua atau lebih meeting yang menggunakan ruangan yang sama di waktu yang berdekatan/overlap.

### Cara Kerja

1. **Meeting pertama disetujui** → posisi antrian `0` (langsung berlangsung)
2. **Meeting kedua disetujui** di ruangan & waktu yang overlap → posisi antrian `1`
3. **Meeting ketiga** → posisi antrian `2`, dst.

### Auto-Trim Waktu
Jika meeting baru overlap dengan meeting yang sudah ada, sistem otomatis **memotong jam selesai** meeting baru agar tidak bentrok dengan meeting yang mulai lebih awal.

### Pergeseran Antrian Otomatis
Ketika meeting dengan posisi `0` diselesaikan:
- Meeting antrian `1` bergeser ke posisi `0`
- Jam mulainya disesuaikan dengan jam selesai aktual meeting sebelumnya
- Durasi meeting tetap dipertahankan

---

## 17. Status Meeting

| Status | Warna | Keterangan |
|---|---|---|
| `pending` | 🟡 Kuning | Menunggu persetujuan Admin/HR |
| `approved` | 🔵 Biru | Disetujui, menunggu pelaksanaan |
| `confirmed` | 🔵 Biru Tua | Koordinator sudah konfirmasi kehadiran |
| `in_progress` | 🟣 Ungu | Sedang berlangsung |
| `completed` | ⚫ Abu-abu | Sudah selesai |
| `cancelled` | 🔴 Merah | Dibatalkan oleh koordinator |
| `rejected` | 🔴 Merah | Ditolak oleh Admin/HR |

### Status Antrian Real-time

| Label | Keterangan |
|---|---|
| Di Booking | Meeting sudah disetujui, belum waktunya |
| Sedang Berlangsung | Meeting sedang berjalan (antrian 0) |
| Dalam Antrian N | Meeting menunggu giliran ke-N |
| Menunggu Antrian N | Giliran hampir tiba (< 10 menit) |
| Selesai | Meeting sudah berakhir |

---

## ℹ️ Catatan Penting

- Semua waktu menggunakan zona waktu **WIB (Asia/Jakarta)**
- Kalender dan status meeting diperbarui otomatis tanpa perlu refresh halaman
- File lampiran yang didukung: **PDF, DOC, DOCX** (maks 10MB)
- Foto profil yang didukung: **JPG, PNG** (maks 2MB)
- Akun yang dinonaktifkan tidak bisa login meskipun password benar

---

*Dokumen ini dibuat untuk keperluan internal Johen Gaming.*
*Versi 1.0 — 2025*
