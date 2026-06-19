@echo off
chcp 65001 >nul
setlocal
cd /d "%~dp0.."

echo ============================================
echo   Installing Smart Installer Package
echo ============================================
echo.

echo [1/6] Adding local path repository...
call composer config repositories.smart-installer path "packages/smart-installer"
if errorlevel 1 goto :err

echo.
echo [2/6] Requiring the package (app/installer:@dev)...
call composer require app/installer:@dev
if errorlevel 1 goto :err

echo.
echo [3/6] Discovering Laravel packages...
call php artisan package:discover --ansi
if errorlevel 1 goto :err

echo.
echo [4/6] Publishing installer config...
call php artisan vendor:publish --tag=installer-config --force
if errorlevel 1 goto :err

echo.
echo [5/6] Publishing installer views...
call php artisan vendor:publish --tag=installer-views --force
if errorlevel 1 goto :err

echo.
echo [6/6] Clearing caches...
call php artisan optimize:clear

echo.
echo ============================================
echo   Done. Open: http://127.0.0.1:8000/install
echo ============================================
pause
exit /b 0

:err
echo.
echo [ERROR] Installation failed. Check the messages above.
pause
exit /b 1