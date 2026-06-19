@echo off
chcp 65001 >nul
setlocal
cd /d "%~dp0.."

echo ============================================
echo   Updating Smart Installer Package
echo ============================================
echo.

echo [1/5] Updating composer package...
call composer update app/installer --with-all-dependencies
if errorlevel 1 goto :err

echo.
echo [2/5] Re-discovering Laravel packages...
call php artisan package:discover --ansi

echo.
echo [3/5] Publishing installer config (force overwrite)...
call php artisan vendor:publish --tag=installer-config --force
if errorlevel 1 goto :err

echo.
echo [4/5] Publishing installer views (force overwrite)...
call php artisan vendor:publish --tag=installer-views --force
if errorlevel 1 goto :err

echo.
echo [5/5] Clearing caches...
call php artisan optimize:clear

echo.
echo ============================================
echo   Update complete.
echo ============================================
pause
exit /b 0

:err
echo.
echo [ERROR] Update failed. Check the messages above.
pause
exit /b 1