@echo off
REM Auto Backup Script for Windows
SET DATE=%date:~-4%%date:~3,2%%date:~0,2%_%time:~0,2%%time:~3,2%%time:~6,2%
SET DATE=%DATE: =0%
SET BACKUP_DIR=storage\app\backups\manual
SET DB_NAME=sistem_pelanggaran
SET DB_USER=root
SET DB_PASS=

REM Create backup directory if not exists
if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

REM MySQL Backup
echo Creating backup...
mysqldump -u %DB_USER% -p%DB_PASS% %DB_NAME% > %BACKUP_DIR%\backup_%DATE%.sql

REM Compress (optional - requires 7zip or similar)
REM 7z a %BACKUP_DIR%\backup_%DATE%.zip %BACKUP_DIR%\backup_%DATE%.sql
REM del %BACKUP_DIR%\backup_%DATE%.sql

echo Backup created: backup_%DATE%.sql
pause
