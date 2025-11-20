@echo off
REM ============================================
REM MySQL Database Restore Script (Windows)
REM Database: sistem_pelanggaran
REM ============================================

REM Konfigurasi Database
set DB_NAME=db_pelanggaran_siswa
set DB_USER=root
set DB_PASS=
set DB_HOST=localhost

REM Path MySQL (sesuaikan dengan instalasi Anda)
set MYSQL_PATH=C:\xampp\mysql\bin

REM Direktori Backup
set BACKUP_DIR=C:\backup\database
set LOG_FILE=%BACKUP_DIR%\restore.log

REM Cek parameter
if "%1"=="" (
    echo Usage: restore_database.bat ^<backup_file^>
    echo Example: restore_database.bat C:\backup\database\backup_daily_20250112_000000.sql.gz
    exit /b 1
)

set BACKUP_FILE=%1

REM Cek file exists
if not exist "%BACKUP_FILE%" (
    echo [%date% %time%] ERROR: Backup file not found: %BACKUP_FILE% >> "%LOG_FILE%"
    echo ERROR: Backup file not found!
    exit /b 1
)

echo [%date% %time%] Starting database restore from: %BACKUP_FILE% >> "%LOG_FILE%"

REM Cek ekstensi file
echo %BACKUP_FILE% | findstr /i ".gz" > nul
if %errorlevel% equ 0 (
    REM File terkompress, decompress dulu
    if exist "C:\Program Files\7-Zip\7z.exe" (
        "C:\Program Files\7-Zip\7z.exe" e "%BACKUP_FILE%" -o"%BACKUP_DIR%" -y > nul
        set SQL_FILE=%BACKUP_DIR%\temp_restore.sql
        
        REM Restore database
        "%MYSQL_PATH%\mysql.exe" -h %DB_HOST% -u %DB_USER% --password=%DB_PASS% %DB_NAME% < "%SQL_FILE%"
        
        REM Hapus file temporary
        del "%SQL_FILE%"
    ) else (
        echo ERROR: 7-Zip not found. Please install 7-Zip or use uncompressed .sql file
        exit /b 1
    )
) else (
    REM File .sql langsung restore
    "%MYSQL_PATH%\mysql.exe" -h %DB_HOST% -u %DB_USER% --password=%DB_PASS% %DB_NAME% < "%BACKUP_FILE%"
)

if %errorlevel% equ 0 (
    echo [%date% %time%] SUCCESS: Database restored successfully! >> "%LOG_FILE%"
    echo Database restored successfully!
) else (
    echo [%date% %time%] ERROR: Database restore failed! >> "%LOG_FILE%"
    echo ERROR: Database restore failed!
    exit /b 1
)

echo [%date% %time%] Restore process finished >> "%LOG_FILE%"
