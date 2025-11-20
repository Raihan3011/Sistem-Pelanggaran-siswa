#!/bin/bash

# ============================================
# MySQL Database Restore Script
# Database: sistem_pelanggaran
# ============================================

# Konfigurasi Database
DB_NAME="sistem_pelanggaran"
DB_USER="root"
DB_PASS=""
DB_HOST="localhost"

# Direktori Backup
BACKUP_DIR="/backup/database"
LOG_FILE="$BACKUP_DIR/restore.log"

# Fungsi logging
log_message() {
    echo "[$(date '+%Y-%m-%d %H:%M:%S')] $1" | tee -a "$LOG_FILE"
}

# Fungsi restore
restore_database() {
    local BACKUP_FILE=$1
    
    if [ ! -f "$BACKUP_FILE" ]; then
        log_message "✗ Backup file not found: $BACKUP_FILE"
        exit 1
    fi
    
    log_message "Starting database restore from: $BACKUP_FILE"
    
    # Decompress dan restore database
    gunzip < "$BACKUP_FILE" | mysql -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME"
    
    if [ $? -eq 0 ]; then
        log_message "✓ Database restored successfully!"
    else
        log_message "✗ Database restore failed!"
        exit 1
    fi
}

# Main execution
if [ -z "$1" ]; then
    echo "Usage: $0 <backup_file.sql.gz>"
    echo "Example: $0 /backup/database/backup_daily_20250112_000000.sql.gz"
    exit 1
fi

restore_database "$1"
log_message "Restore process finished"
