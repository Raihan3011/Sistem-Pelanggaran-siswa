#!/bin/bash

# ============================================
# MySQL Database Auto Backup Script
# Database: sistem_pelanggaran
# ============================================

# Konfigurasi Database
DB_NAME="sistem_pelanggaran"
DB_USER="root"
DB_PASS=""
DB_HOST="localhost"

# Direktori Backup
BACKUP_DIR="/backup/database"
LOG_FILE="$BACKUP_DIR/backup.log"

# Buat direktori jika belum ada
mkdir -p "$BACKUP_DIR"

# Fungsi logging
log_message() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Fungsi backup
backup_database() {
    local BACKUP_TYPE=$1
    local TIMESTAMP=$(date +%Y%m%d_%H%M%S)
    local BACKUP_FILE="$BACKUP_DIR/backup_${BACKUP_TYPE}_${TIMESTAMP}.sql.gz"
    
    log_message "Starting $BACKUP_TYPE backup..."
    
    # Export database dengan mysqldump dan kompres dengan gzip
    mysqldump -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" | gzip > "$BACKUP_FILE"
    
    if [ $? -eq 0 ]; then
        local FILE_SIZE=$(du -h "$BACKUP_FILE" | cut -f1)
        log_message "✓ $BACKUP_TYPE backup completed successfully: $BACKUP_FILE (Size: $FILE_SIZE)"
    else
        log_message "✗ $BACKUP_TYPE backup failed!"
        exit 1
    fi
}

# Fungsi hapus backup lama
cleanup_old_backups() {
    log_message "Cleaning up backups older than 30 days..."
    find "$BACKUP_DIR" -name "backup_*.sql.gz" -type f -mtime +30 -delete
    log_message "✓ Cleanup completed"
}

# Main execution
case "$1" in
    daily)
        backup_database "daily"
        cleanup_old_backups
        ;;
    weekly)
        backup_database "weekly"
        cleanup_old_backups
        ;;
    monthly)
        backup_database "monthly"
        cleanup_old_backups
        ;;
    *)
        echo "Usage: $0 {daily|weekly|monthly}"
        exit 1
        ;;
esac

log_message "Backup process finished"
