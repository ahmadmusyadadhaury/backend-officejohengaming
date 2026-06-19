# 📅 Tutorial Cron Job — Laravel Scheduler

> Panduan lengkap menjalankan Laravel Scheduler untuk Meeting Room Booking System,
> mulai dari lokal (Laragon/Windows) hingga production (Hostinger).

---

## 📖 Apa itu Cron Job?

**Cron Job** adalah tugas yang dijadwalkan untuk berjalan otomatis pada waktu tertentu,
tanpa perlu dijalankan manual.

Contoh penggunaannya di project ini:
- Generate sesi meeting mingguan setiap hari secara otomatis
- Menyelesaikan (complete) sesi meeting yang sudah lewat waktunya
- Mengirim undangan otomatis ke semua user aktif

---

## 🔄 Cara Kerja Laravel Scheduler

```
Setiap 1 menit
     │
     ▼
php artisan schedule:run
     │
     ▼
Cek routes/console.php
     │
     ▼
Jalankan: php artisan weekly:process
     │
     ├── completeExpiredSessions()  → Selesaikan sesi yang sudah lewat waktu
     └── generateTodaySessions()   → Buat sesi baru untuk hari ini
```

---

## 💻 A. Menjalankan di Lokal (Laragon / Windows)

### Cara 1 — Manual (untuk testing)

Jalankan sekali saja, cocok untuk test apakah command berjalan dengan benar:

```bash
cd c:\laragon\www\meeting-room
php artisan weekly:process
```

**Kekurangan:** Harus dijalankan manual setiap kali ingin diproses.

---

### Cara 2 — `schedule:work` (development)

Laravel menyediakan perintah khusus yang mensimulasikan cron job setiap menit:

```bash
cd c:\laragon\www\meeting-room
php artisan schedule:work
```

**Output yang muncul:**
```
Running scheduled command: weekly:process
Weekly meetings processed.
```

> ⚠️ **Penting:** Perintah ini akan **berhenti** jika:
> - Terminal ditutup
> - PC dimatikan / restart
> - Koneksi terputus

**Kekurangan:** Tidak cocok untuk production, hanya untuk development lokal.

---

### Cara 3 — Windows Task Scheduler (lokal permanen)

Agar scheduler tetap jalan meski terminal ditutup (tapi tetap mati kalau PC mati):

1. Buka **Task Scheduler** (cari di Start Menu)
2. Klik **Create Basic Task**
3. Isi nama: `Laravel Meeting Room Scheduler`
4. Trigger: **Daily**, ulangi setiap **1 menit**
5. Action: **Start a program**
6. Program: `php`
7. Arguments: `artisan schedule:run`
8. Start in: `c:\laragon\www\meeting-room`

> ⚠️ Tetap akan mati jika PC dimatikan.

---

## 🌐 B. Menjalankan di Hostinger (Production)

Di Hostinger, cron job berjalan di **server mereka** — bukan di PC kamu.
Artinya **tetap jalan 24/7 meski PC kamu mati**.

### Langkah 1 — Upload Project ke Hostinger

Pastikan project Laravel sudah ter-deploy di Hostinger.
File berada di direktori seperti:
```
/home/u123456789/public_html/
```

### Langkah 2 — Cari Path PHP di Hostinger

Login ke Hostinger via **SSH** (Terminal):

```bash
# Login SSH (cek di hPanel > SSH Access)
ssh u123456789@your-domain.com

# Cek versi dan path PHP
which php
# Output contoh: /usr/bin/php

php -v
# Pastikan versi PHP 8.3+
```

> Atau cek di **hPanel → PHP Configuration** untuk melihat versi PHP aktif.

### Langkah 3 — Cari Path Project

Masih di SSH, jalankan:

```bash
# Cek posisi project kamu
ls /home/u123456789/public_html/

# Pastikan ada file artisan
ls /home/u123456789/public_html/artisan
```

### Langkah 4 — Setup Cron Job di hPanel

1. Login ke **hPanel** → [hpanel.hostinger.com](https://hpanel.hostinger.com)
2. Pilih hosting kamu
3. Pergi ke menu **Advanced → Cron Jobs**
4. Klik **Create New Cron Job**
5. Pilih interval: **Every minute** (atau isi manual)
6. Isi command:

```bash
/usr/bin/php /home/u123456789/public_html/artisan schedule:run >> /dev/null 2>&1
```

> Ganti `u123456789` dengan username Hostinger kamu yang sebenarnya.

7. Klik **Create**

---

### Format Cron Job

```
* * * * * command
│ │ │ │ │
│ │ │ │ └── Hari dalam seminggu (0-7, 0&7=Minggu)
│ │ │ └──── Bulan (1-12)
│ │ └────── Tanggal (1-31)
│ └──────── Jam (0-23)
└────────── Menit (0-59)
```

| Contoh | Artinya |
|--------|---------|
| `* * * * *` | Setiap menit |
| `0 * * * *` | Setiap jam (menit ke-0) |
| `0 0 * * *` | Setiap hari tengah malam |
| `0 8 * * 1` | Setiap Senin jam 08:00 |

Untuk Laravel Scheduler, selalu gunakan **`* * * * *`** (setiap menit),
karena Laravel yang mengatur jadwal lebih detailnya di `routes/console.php`.

---

## ⚖️ Perbandingan Lokal vs Hostinger

| Aspek | Lokal (Laragon) | Hostinger |
|-------|----------------|-----------|
| **PC dimatikan** | ❌ Scheduler mati | ✅ Tetap jalan |
| **Terminal ditutup** | ❌ Mati (schedule:work) | ✅ Tidak berpengaruh |
| **Berjalan 24/7** | ❌ Tidak | ✅ Ya |
| **Setup** | `php artisan schedule:work` | Cron Job di hPanel |
| **Cocok untuk** | Development / Testing | Production |
| **Biaya** | Gratis | Sesuai paket hosting |

---

## 🔍 Cara Cek Apakah Scheduler Berjalan

### Di Lokal
```bash
# Lihat log scheduler
php artisan schedule:list

# Jalankan manual dan lihat output
php artisan weekly:process
```

### Di Hostinger (via SSH)
```bash
# Cek log Laravel
tail -f /home/u123456789/public_html/storage/logs/laravel.log

# Jalankan manual untuk test
php /home/u123456789/public_html/artisan weekly:process
```

---

## 🛠️ Troubleshooting

### ❌ Cron job tidak berjalan di Hostinger

**Kemungkinan penyebab:**
1. Path PHP salah → cek dengan `which php` di SSH
2. Path project salah → pastikan ada file `artisan` di path tersebut
3. Permission error → jalankan `chmod 755 artisan` di SSH

```bash
# Fix permission
chmod 755 /home/u123456789/public_html/artisan

# Test manual
/usr/bin/php /home/u123456789/public_html/artisan weekly:process
```

---

### ❌ Meeting mingguan tidak ter-generate

```bash
# Cek apakah ada weekly meeting yang aktif di database
php artisan tinker
>>> App\Models\WeeklyMeeting::where('is_active', true)->get()

# Jalankan manual
php artisan weekly:process
```

---

### ❌ Error "php not found" di Hostinger

Coba path alternatif PHP:
```bash
# Coba path ini
/usr/local/bin/php artisan schedule:run

# Atau
/opt/cpanel/ea-php83/root/usr/bin/php artisan schedule:run
```

---

## ✅ Checklist Setup Production (Hostinger)

- [ ] Project Laravel sudah di-upload ke Hostinger
- [ ] File `.env` sudah dikonfigurasi (DB, APP_KEY, dll)
- [ ] `php artisan migrate --seed` sudah dijalankan
- [ ] `php artisan storage:link` sudah dijalankan
- [ ] Cron job sudah dibuat di hPanel
- [ ] Test manual `php artisan weekly:process` berhasil
- [ ] Cek log `storage/logs/laravel.log` tidak ada error

---

## 📝 Ringkasan

```
Development (PC Lokal)
└── php artisan schedule:work   ← Jalan selama terminal terbuka

Production (Hostinger)
└── Cron Job di hPanel          ← Jalan 24/7 otomatis
    * * * * * /usr/bin/php /home/username/public_html/artisan schedule:run >> /dev/null 2>&1
```

> 💡 **Tips:** Selalu test command secara manual dulu sebelum setup cron job,
> pastikan tidak ada error, baru aktifkan cron job di Hostinger.
