# 📦 Auto Backup Database MySQL - Sistem Pelanggaran Siswa

## 📋 Spesifikasi

- **Database**: `sistem_pelanggaran`
- **Direktori Backup**: `/backup/database`
- **Format File**: `backup_YYYYMMDD_HHMMSS.sql.gz`
- **Retensi**: 30 hari (otomatis hapus file lama)

## 🕐 Jadwal Backup

| Jenis Backup | Jadwal | Deskripsi |
|--------------|--------|-----------|
| **Daily** | Setiap hari 00:00 | Incremental backup harian |
| **Weekly** | Minggu 02:00 | Full backup mingguan |
| **Monthly** | Akhir bulan 03:00 | Archive backup bulanan |

## 🚀 Instalasi

### 1. Persiapan

```bash
# Buat direktori backup
sudo mkdir -p /backup/database
sudo chmod 755 /backup/database

# Berikan permission execute pada script
chmod +x backup_database.sh
chmod +x restore_database.sh
chmod +x setup_cron.sh
```

### 2. Konfigurasi Database

Edit file `backup_database.sh` dan sesuaikan kredensial database:

```bash
DB_NAME="sistem_pelanggaran"
DB_USER="root"
DB_PASS="your_password"
DB_HOST="localhost"
```

### 3. Setup Cron Jobs

```bash
# Jalankan script setup
./setup_cron.sh

# Verifikasi cron jobs terinstall
crontab -l
```

## 📝 Penggunaan Manual

### Backup Manual

```bash
# Daily backup
./backup_database.sh daily

# Weekly backup
./backup_database.sh weekly

# Monthly backup
./backup_database.sh monthly
```

### Restore Database

```bash
# Restore dari file backup
./restore_database.sh /backup/database/backup_daily_20250112_000000.sql.gz

# Atau dengan path relatif
./restore_database.sh backup_daily_20250112_000000.sql.gz
```

### Lihat Log

```bash
# Lihat log backup
tail -f /backup/database/backup.log

# Lihat log restore
tail -f /backup/database/restore.log
```

## 📂 Struktur File Backup

```
/backup/database/
├── backup_daily_20250112_000000.sql.gz
├── backup_daily_20250113_000000.sql.gz
├── backup_weekly_20250112_020000.sql.gz
├── backup_monthly_20250131_030000.sql.gz
├── backup.log
└── restore.log
```

## 🔧 Troubleshooting

### Error: Permission Denied

```bash
sudo chmod +x backup_database.sh
sudo chmod +x restore_database.sh
```

### Error: mysqldump command not found

```bash
# Install MySQL client
sudo apt-get install mysql-client
```

### Error: Directory not writable

```bash
sudo chown -R $USER:$USER /backup/database
sudo chmod -R 755 /backup/database
```

## 🛡️ Keamanan

1. **Jangan commit file dengan password** ke repository
2. Gunakan environment variable untuk password:
   ```bash
   export DB_PASS="your_password"
   ```
3. Set permission yang tepat:
   ```bash
   chmod 600 backup_database.sh
   ```

## 📊 Monitoring

### Cek Status Backup

```bash
# Lihat backup terbaru
ls -lht /backup/database/*.sql.gz | head -5

# Cek ukuran total backup
du -sh /backup/database/

# Hitung jumlah file backup
ls -1 /backup/database/*.sql.gz | wc -l
```

### Cek Cron Jobs

```bash
# Lihat cron jobs aktif
crontab -l

# Lihat log cron
grep CRON /var/log/syslog
```

## 🔄 Restore Otomatis

Untuk restore otomatis ke database testing:

```bash
#!/bin/bash
LATEST_BACKUP=$(ls -t /backup/database/backup_daily_*.sql.gz | head -1)
./restore_database.sh "$LATEST_BACKUP"
```

## 📧 Notifikasi Email (Opsional)

Tambahkan notifikasi email di script backup:

```bash
# Di akhir backup_database.sh
if [ $? -eq 0 ]; then
    echo "Backup berhasil: $BACKUP_FILE" | mail -s "Backup Success" admin@example.com
else
    echo "Backup gagal!" | mail -s "Backup Failed" admin@example.com
fi
```

## 🗑️ Hapus Backup Manual

```bash
# Hapus backup lebih dari 30 hari
find /backup/database -name "backup_*.sql.gz" -type f -mtime +30 -delete

# Hapus semua backup daily
rm /backup/database/backup_daily_*.sql.gz

# Hapus backup spesifik
rm /backup/database/backup_daily_20250112_000000.sql.gz
```

## 📌 Tips

1. **Test restore secara berkala** untuk memastikan backup berfungsi
2. **Simpan backup di lokasi berbeda** (cloud storage, external drive)
3. **Monitor disk space** untuk menghindari disk penuh
4. **Dokumentasikan prosedur restore** untuk disaster recovery

## 🆘 Support

Jika ada masalah, cek:
1. Log file: `/backup/database/backup.log`
2. Cron log: `/var/log/syslog`
3. MySQL error log: `/var/log/mysql/error.log`

## 📄 License

MIT License - Free to use and modify
