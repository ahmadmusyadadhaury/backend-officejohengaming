# Panduan Setup Realtime di Hostinger

## 1. Setup Cron Job di Hostinger (WAJIB)

### Langkah-langkah:

1. Login ke **hPanel Hostinger**
2. Cari menu **Advanced** → **Cron Jobs**
3. Klik **Create New Cron Job**
4. Isi form:
   - **Type**: Common Settings → **Every Minute**
   - **Command**:
     ```bash
     cd /home/u123456789/domains/meetingroom.johengaming.store/public_html && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
     ```
     
     **PENTING**: Ganti `/home/u123456789/` dengan path hosting kamu yang sebenarnya!
     
     Cara cek path:
     - Buka **File Manager** di hPanel
     - Lihat path di address bar, contoh: `/home/u987654321/`

5. Klik **Create**

### Verifikasi Cron Job Jalan:

Setelah 1-2 menit, cek log:
```bash
tail -f storage/logs/laravel.log
```

Atau tambahkan log manual di `routes/console.php`:
```php
Schedule::command('weekly:process')->everyMinute()
    ->appendOutputTo(storage_path('logs/scheduler.log'));
```

---

## 2. Verifikasi Queue Connection

Di file `.env` production, pastikan:
```env
QUEUE_CONNECTION=database
```

Jika belum ada tabel `jobs`, jalankan:
```bash
php artisan queue:table
php artisan migrate
```

---

## 3. Testing Realtime

### Test Weekly Meeting Auto-Generate:
1. Buat weekly meeting di admin panel untuk hari ini
2. Tunggu 1-2 menit
3. Buka `/weekly-undangan` → harus muncul sesi otomatis

### Test Status Realtime:
1. Buka kalender
2. Lihat status meeting berubah otomatis setiap 30 detik
3. Cek "Last Update" di pojok kanan bawah kalender

---

## 4. Monitoring & Troubleshooting

### Cek Cron Job Jalan:
```bash
# Di terminal hosting
grep CRON /var/log/syslog
```

### Cek Laravel Log:
```bash
tail -100 storage/logs/laravel.log
```

### Force Run Scheduler Manual (untuk testing):
```bash
php artisan schedule:run
```

### Force Generate Weekly Sessions:
```bash
php artisan weekly:process
```

---

## 5. Optimasi Performance

### Cache Config di Production:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Clear Cache (jika ada masalah):
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

---

## 6. Fitur Realtime yang Sudah Aktif

✅ Kalender - polling 30 detik
✅ Status meeting (Berlangsung, Antrian, dll)
✅ Weekly meeting auto-generate (via cron)
✅ Dashboard admin - auto-refresh 60 detik
✅ Dashboard leader - auto-refresh 60 detik
✅ Dashboard user - auto-refresh 60 detik
✅ Notifikasi topbar - auto-refresh 60 detik
✅ List meeting - auto-refresh 30 detik

---

## 7. Catatan Penting

- **Cron job WAJIB** untuk weekly meeting otomatis
- Polling interval bisa disesuaikan (30s, 60s, dll)
- Jangan set terlalu cepat (< 10s) agar tidak overload server
- Monitor resource usage di hPanel

---

## 8. Kontak Support

Jika ada masalah:
1. Cek `storage/logs/laravel.log`
2. Cek cron job di hPanel
3. Test manual: `php artisan schedule:run`
