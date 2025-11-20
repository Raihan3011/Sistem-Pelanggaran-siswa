#!/bin/bash

# ============================================
# Setup Cron Jobs untuk Auto Backup
# ============================================

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
BACKUP_SCRIPT="$SCRIPT_DIR/backup_database.sh"

echo "Setting up cron jobs for database backup..."

# Buat file crontab temporary
CRON_FILE="/tmp/backup_cron.txt"

# Hapus cron jobs lama jika ada
crontab -l 2>/dev/null | grep -v "backup_database.sh" > "$CRON_FILE"

# Tambahkan cron jobs baru
cat >> "$CRON_FILE" << EOF

# Auto Backup Database - sistem_pelanggaran
# Daily incremental backup setiap pukul 00:00
0 0 * * * $BACKUP_SCRIPT daily

# Weekly full backup setiap hari Minggu pukul 02:00
0 2 * * 0 $BACKUP_SCRIPT weekly

# Monthly archive backup pada akhir bulan (tanggal 28-31)
0 3 28-31 * * [ \$(date -d tomorrow +\%d) -eq 1 ] && $BACKUP_SCRIPT monthly

EOF

# Install crontab
crontab "$CRON_FILE"

# Hapus file temporary
rm "$CRON_FILE"

echo "✓ Cron jobs installed successfully!"
echo ""
echo "Scheduled backups:"
echo "  - Daily backup: Every day at 00:00"
echo "  - Weekly backup: Every Sunday at 02:00"
echo "  - Monthly backup: Last day of month at 03:00"
echo ""
echo "To view cron jobs: crontab -l"
echo "To remove cron jobs: crontab -r"
