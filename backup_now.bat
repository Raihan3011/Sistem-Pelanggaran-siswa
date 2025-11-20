@echo off
REM Quick Backup Script - Langsung Jalankan
echo ========================================
echo   AUTO BACKUP DATABASE - RUNNING NOW
echo ========================================
echo.

REM Konfigurasi
set DB_NAME=db_pelanggaran_siswa
set DB_USER=root
set DB_PASS=
set DB_HOST=localhost
set MYSQL_PATH=C:\xampp\mysql\bin
set BACKUP_DIR=%~dp0backup\database

REM Buat direktori jika belum ada
if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

REM Timestamp
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value') do set datetime=%%I
set TIMESTAMP=%datetime:~0,8%_%datetime:~8,6%
set BACKUP_FILE=%BACKUP_DIR%\backup_manual_%TIMESTAMP%.sql

echo [1/4] Memulai backup database...
echo Database: %DB_NAME%
echo File: backup_manual_%TIMESTAMP%.sql
echo.

REM Backup database
"%MYSQL_PATH%\mysqldump.exe" -h %DB_HOST% -u %DB_USER% %DB_NAME% > "%BACKUP_FILE%" 2>nul

if %errorlevel% equ 0 (
    echo [2/4] Backup berhasil!
    
    REM Cek ukuran file
    for %%A in ("%BACKUP_FILE%") do set SIZE=%%~zA
    echo Ukuran: %SIZE% bytes
    echo.
    
    REM Kompres jika 7zip tersedia
    echo [3/4] Mengompres file...
    if exist "C:\Program Files\7-Zip\7z.exe" (
        "C:\Program Files\7-Zip\7z.exe" a -tgzip "%BACKUP_FILE%.gz" "%BACKUP_FILE%" > nul 2>&1
        if %errorlevel% equ 0 (
            del "%BACKUP_FILE%"
            echo File terkompress: backup_manual_%TIMESTAMP%.sql.gz
        ) else (
            echo File tidak terkompress (7-Zip error)
        )
    ) else (
        echo File tidak terkompress (7-Zip tidak terinstall)
    )
    echo.
    
    REM Log
    echo [4/4] Menulis log...
    echo [%date% %time%] SUCCESS: Manual backup completed >> "%BACKUP_DIR%\backup.log"
    
    echo.
    echo ========================================
    echo   BACKUP SELESAI!
    echo ========================================
    echo Lokasi: %BACKUP_DIR%
    echo.
    
    REM Tampilkan daftar backup
    echo Daftar backup yang tersedia:
    dir "%BACKUP_DIR%\backup_*.sql*" /b 2>nul
    
) else (
    echo [ERROR] Backup gagal!
    echo.
    echo Kemungkinan penyebab:
    echo - MySQL tidak berjalan
    echo - Path MySQL salah: %MYSQL_PATH%
    echo - Database tidak ditemukan: %DB_NAME%
    echo.
    echo [%date% %time%] ERROR: Manual backup failed >> "%BACKUP_DIR%\backup.log"
)

echo.
pause
