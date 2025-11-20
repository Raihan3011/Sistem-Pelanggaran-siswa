# Sistem Backup Database

## Fitur Backup Otomatis

### 1. Daily Incremental Backup
- **Jadwal**: Setiap hari pukul 00:00 WIB
- **Lokasi**: `storage/app/backups/daily/`
- **Format**: `daily_backup_YYYYMMDD_HHMMSS.sql.gz`
- **Retensi**: 30 hari (otomatis dihapus setelah 30 hari)

### 2. Weekly Full Backup
- **Jadwal**: Setiap Minggu pukul 02:00 WIB
- **Lokasi**: `storage/app/backups/weekly/`
- **Format**: `weekly_full_backup_YYYYMMDD_HHMMSS.sql.gz`
- **Retensi**: Manual (tidak otomatis dihapus)

### 3. Monthly Archive Backup
- **Jadwal**: Setiap akhir bulan pukul 23:00 WIB
- **Lokasi**: `storage/app/backups/monthly/`
- **Format**: `monthly_archive_YYYY_MM_YYYYMMDD_HHMMSS.sql.gz`
- **Retensi**: Manual (tidak otomatis dihapus)

## Cara Mengaktifkan Backup Otomatis

### Windows (Task Scheduler)

1. Buka Command Prompt sebagai Administrator
2. Jalankan perintah:
```cmd
php artisan schedule:work
```

Atau tambahkan ke Task Scheduler:
- Program: `php`
- Arguments: `artisan schedule:run`
- Start in: `C:\path\to\sistem-pelanggaran-siswa`
- Trigger: Setiap 1 menit

### Linux (Cron Job)

Tambahkan ke crontab:
```bash
* * * * * cd /path/to/sistem-pelanggaran-siswa && php artisan schedule:run >> /dev/null 2>&1
```

## Manual Backup

### Via Web Interface
1. Login sebagai Admin
2. Buka menu **Backup Database**
3. Pilih tipe backup (Daily/Weekly/Monthly)
4. Klik tombol **Buat Backup Sekarang**

### Via Command Line

**Daily Backup:**
```bash
php artisan backup:daily
```

**Weekly Backup:**
```bash
php artisan backup:weekly
```

**Monthly Backup:**
```bash
php artisan backup:monthly
```

**Clean Old Backups:**
```bash
php artisan backup:clean
```

### Via Batch Script (Windows)
Double-click file `backup_restore.bat`

## Restore Database

### Via Web Interface
1. Login sebagai Admin
2. Buka menu **Backup Database**
3. Pilih file backup yang ingin di-restore
4. Klik tombol **Restore**
5. Konfirmasi restore

### Via Command Line

**Decompress backup:**
```bash
gzip -d storage/app/backups/daily/backup_file.sql.gz
```

**Restore database:**
```bash
mysql -u root -p sistem_pelanggaran < storage/app/backups/daily/backup_file.sql
```

**Verification:**
```sql
USE sistem_pelanggaran;
SHOW TABLES;
SELECT COUNT(*) FROM pelanggaran;
```

## Download Backup

1. Login sebagai Admin
2. Buka menu **Backup Database**
3. Klik tombol **Download** pada file backup yang diinginkan
4. File akan terdownload dalam format `.sql.gz`

## Hapus Backup

1. Login sebagai Admin
2. Buka menu **Backup Database**
3. Klik tombol **Hapus** pada file backup yang ingin dihapus
4. Konfirmasi penghapusan

## Struktur Direktori Backup

```
storage/app/backups/
├── daily/
│   ├── daily_backup_20250114_000000.sql.gz
│   ├── daily_backup_20250115_000000.sql.gz
│   └── ...
├── weekly/
│   ├── weekly_full_backup_20250112_020000.sql.gz
│   ├── weekly_full_backup_20250119_020000.sql.gz
│   └── ...
└── monthly/
    ├── monthly_archive_2025_01_20250131_230000.sql.gz
    ├── monthly_archive_2025_02_20250228_230000.sql.gz
    └── ...
```

## Konfigurasi Database

Pastikan konfigurasi database di file `.env` sudah benar:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_pelanggaran
DB_USERNAME=root
DB_PASSWORD=
```

## Troubleshooting

### Backup gagal dibuat
- Pastikan MySQL/MariaDB sudah terinstall
- Pastikan `mysqldump` command tersedia di PATH
- Periksa permission folder `storage/app/backups/`
- Periksa konfigurasi database di `.env`

### Restore gagal
- Pastikan file backup tidak corrupt
- Pastikan database sudah dibuat
- Pastikan user database memiliki permission yang cukup

### Schedule tidak berjalan
- Pastikan `php artisan schedule:work` atau cron job sudah berjalan
- Periksa log Laravel di `storage/logs/laravel.log`

## Keamanan

- Backup file disimpan di folder `storage/app/backups/` yang tidak dapat diakses publik
- Hanya user dengan role Admin yang dapat mengakses fitur backup
- Gunakan password yang kuat untuk database
- Backup file sebaiknya di-copy ke storage eksternal secara berkala

## Best Practices

1. **Backup Reguler**: Pastikan backup otomatis berjalan setiap hari
2. **Verifikasi Backup**: Test restore backup secara berkala
3. **Offsite Backup**: Copy backup ke lokasi lain (cloud storage, external drive)
4. **Monitor Space**: Pantau kapasitas disk untuk backup
5. **Dokumentasi**: Catat setiap restore yang dilakukan
