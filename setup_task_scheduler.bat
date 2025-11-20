@echo off
REM ============================================
REM Setup Windows Task Scheduler untuk Auto Backup
REM ============================================

echo Setting up Windows Task Scheduler for database backup...
echo.

set SCRIPT_DIR=%~dp0
set BACKUP_SCRIPT=%SCRIPT_DIR%backup_database.bat

REM Daily backup - setiap hari pukul 00:00
schtasks /create /tn "Database Backup - Daily" /tr "\"%BACKUP_SCRIPT%\" daily" /sc daily /st 00:00 /f
if %errorlevel% equ 0 (
    echo [OK] Daily backup task created
) else (
    echo [FAILED] Daily backup task creation failed
)

REM Weekly backup - setiap Minggu pukul 02:00
schtasks /create /tn "Database Backup - Weekly" /tr "\"%BACKUP_SCRIPT%\" weekly" /sc weekly /d SUN /st 02:00 /f
if %errorlevel% equ 0 (
    echo [OK] Weekly backup task created
) else (
    echo [FAILED] Weekly backup task creation failed
)

REM Monthly backup - setiap tanggal 28 pukul 03:00
schtasks /create /tn "Database Backup - Monthly" /tr "\"%BACKUP_SCRIPT%\" monthly" /sc monthly /d 28 /st 03:00 /f
if %errorlevel% equ 0 (
    echo [OK] Monthly backup task created
) else (
    echo [FAILED] Monthly backup task creation failed
)

echo.
echo ========================================
echo Task Scheduler setup completed!
echo ========================================
echo.
echo Scheduled tasks:
echo   - Daily backup: Every day at 00:00
echo   - Weekly backup: Every Sunday at 02:00
echo   - Monthly backup: 28th of each month at 03:00
echo.
echo To view tasks: schtasks /query /tn "Database Backup*"
echo To delete tasks: schtasks /delete /tn "Database Backup - Daily" /f
echo.
pause
