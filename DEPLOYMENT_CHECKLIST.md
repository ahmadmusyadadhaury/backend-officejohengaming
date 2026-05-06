# Deployment Checklist - Hostinger

## ✅ Checklist Sebelum Deploy

### 1. File & Folder
- [ ] Upload semua file project ke `/public_html`
- [ ] Pastikan folder `storage/` dan `bootstrap/cache/` writable (chmod 775)
- [ ] Copy `.env.example` ke `.env` dan sesuaikan

### 2. Environment (.env)
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://meetingroom.johengaming.store

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_meeting_room
DB_USERNAME=u123456789_user
DB_PASSWORD=your_password

QUEUE_CONNECTION=database
SESSION_DRIVER=database
CACHE_STORE=database
```

### 3. Database
- [ ] Buat database di hPanel
- [ ] Jalankan migration:
  ```bash
  php artisan migrate --force
  ```
- [ ] Jalankan seeder (opsional):
  ```bash
  php artisan db:seed --force
  ```

### 4. Permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 5. Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 6. Setup Cron Job (WAJIB!)
Di hPanel → Advanced → Cron Jobs:

**Type**: Every Minute
**Command**:
```bash
cd /home/u123456789/domains/meetingroom.johengaming.store/public_html && /usr/bin/php artisan schedule:run >> /dev/null 2>&1
```

**PENTING**: Ganti path sesuai hosting kamu!

### 7. Test Cron Job
Tunggu 1-2 menit, lalu cek:
```bash
tail -f storage/logs/laravel.log
```

Atau test manual:
```bash
php artisan schedule:run
php artisan weekly:process
```

### 8. Verifikasi Realtime
- [ ] Buka kalender → cek status update setiap 30 detik
- [ ] Buka dashboard → cek stats update setiap 60 detik
- [ ] Cek badge notifikasi topbar update otomatis
- [ ] Buat weekly meeting → tunggu 1-2 menit → cek auto-generate sesi

---

## 🔧 Troubleshooting

### Cron Job Tidak Jalan
1. Cek path di cron command benar
2. Cek permission `artisan` file (chmod +x artisan)
3. Test manual: `php artisan schedule:run`
4. Cek log: `tail -f storage/logs/laravel.log`

### Error 500
1. Cek `.env` sudah benar
2. Cek permission storage & bootstrap/cache
3. Clear cache: `php artisan cache:clear`
4. Cek log: `tail -100 storage/logs/laravel.log`

### Database Connection Error
1. Cek DB credentials di `.env`
2. Cek database sudah dibuat di hPanel
3. Cek user database punya akses

### CSS Tidak Muncul
1. Pastikan `public/css/gaming.css` ada
2. Jalankan: `php artisan optimize:clear`
3. Hard refresh browser (Ctrl+Shift+R)

---

## 📊 Monitoring

### Cek Resource Usage
- Login hPanel → Metrics → Resource Usage
- Monitor CPU, RAM, I/O usage
- Jika tinggi, kurangi polling interval

### Cek Logs
```bash
# Laravel log
tail -f storage/logs/laravel.log

# Cron log (jika ada)
tail -f storage/logs/scheduler.log

# PHP error log
tail -f /home/u123456789/logs/error_log
```

---

## 🚀 Optimasi Performance

### 1. Reduce Polling Interval (jika server lambat)
Edit di file view:
- Kalender: 30s → 60s
- Dashboard: 60s → 120s
- Notifikasi: 60s → 120s

### 2. Enable OPcache
Di hPanel → PHP Configuration → Enable OPcache

### 3. Use Redis (jika tersedia)
```env
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

---

## 📝 Catatan Penting

1. **Cron job WAJIB** untuk weekly meeting auto-generate
2. Polling interval bisa disesuaikan sesuai kebutuhan
3. Monitor resource usage secara berkala
4. Backup database secara rutin
5. Update Laravel & dependencies secara berkala

---

## 🆘 Support

Jika ada masalah:
1. Cek file `REALTIME_SETUP_GUIDE.md`
2. Cek logs di `storage/logs/`
3. Test manual command: `php artisan weekly:process`
4. Hubungi support Hostinger jika masalah server
