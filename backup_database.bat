@echo off
REM ============================================
REM MySQL Database Auto Backup Script (Windows)
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
set LOG_FILE=%BACKUP_DIR%\backup.log

REM Buat direktori jika belum ada
if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

REM Ambil timestamp
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value') do set datetime=%%I
set TIMESTAMP=%datetime:~0,8%_%datetime:~8,6%

REM Tentukan tipe backup
set BACKUP_TYPE=%1
if "%BACKUP_TYPE%"=="" set BACKUP_TYPE=daily

REM Nama file backup
set BACKUP_FILE=%BACKUP_DIR%\backup_%BACKUP_TYPE%_%TIMESTAMP%.sql.gz

REM Log start
echo [%date% %time%] Starting %BACKUP_TYPE% backup... >> "%LOG_FILE%"

REM Export database dengan mysqldump
"%MYSQL_PATH%\mysqldump.exe" -h %DB_HOST% -u %DB_USER% --password=%DB_PASS% %DB_NAME% > "%BACKUP_DIR%\temp_backup.sql"

if %errorlevel% equ 0 (
    REM Kompres dengan 7zip atau gzip (jika tersedia)
    if exist "C:\Program Files\7-Zip\7z.exe" (
        "C:\Program Files\7-Zip\7z.exe" a -tgzip "%BACKUP_FILE%" "%BACKUP_DIR%\temp_backup.sql" > nul
        del "%BACKUP_DIR%\temp_backup.sql"
        echo [%date% %time%] SUCCESS: %BACKUP_TYPE% backup completed: %BACKUP_FILE% >> "%LOG_FILE%"
    ) else (
        REM Jika tidak ada 7zip, simpan sebagai .sql
        move "%BACKUP_DIR%\temp_backup.sql" "%BACKUP_DIR%\backup_%BACKUP_TYPE%_%TIMESTAMP%.sql"
        echo [%date% %time%] SUCCESS: %BACKUP_TYPE% backup completed (uncompressed) >> "%LOG_FILE%"
    )
) else (
    echo [%date% %time%] ERROR: %BACKUP_TYPE% backup failed! >> "%LOG_FILE%"
    exit /b 1
)

REM Hapus backup lebih dari 30 hari
echo [%date% %time%] Cleaning up old backups... >> "%LOG_FILE%"
forfiles /p "%BACKUP_DIR%" /s /m backup_*.sql* /d -30 /c "cmd /c del @path" 2>nul
echo [%date% %time%] Cleanup completed >> "%LOG_FILE%"

echo [%date% %time%] Backup process finished >> "%LOG_FILE%"
echo Backup completed successfully!
