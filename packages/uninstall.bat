@echo off
chcp 65001 >nul
setlocal enabledelayedexpansion
cd /d "%~dp0.."

echo ============================================
echo   FULL Uninstall - Smart Installer Package
echo   Removes package, published files, lock
echo   files, cache, and all related traces.
echo ============================================
echo.
set /p CONFIRM=Type YES to confirm full removal: 
if /i not "!CONFIRM!"=="YES" (
    echo Aborted.
    pause
    exit /b 0
)

echo.
echo [1/10] Removing composer package (app/installer)...
call composer remove app/installer --no-interaction 2>nul

echo.
echo [2/10] Removing local path repository from composer.json...
call composer config --unset repositories.smart-installer 2>nul
call composer config --unset repositories.0 2>nul

echo.
echo [3/10] Deleting published config file...
if exist "config\installer.php" ( del /f /q "config\installer.php" & echo   - config\installer.php deleted. )

echo.
echo [4/10] Deleting published views directory...
if exist "resources\views\vendor\installer" ( rmdir /s /q "resources\views\vendor\installer" & echo   - resources\views\vendor\installer deleted. )

echo.
echo [5/10] Deleting install lock files...
if exist "storage\app\installed.lock"      del /f /q "storage\app\installed.lock"
if exist "storage\app\installer.lock"      del /f /q "storage\app\installer.lock"
if exist "storage\installed"               del /f /q "storage\installed"
if exist "bootstrap\cache\installed.php"   del /f /q "bootstrap\cache\installed.php"

echo.
echo [6/10] Removing vendor leftovers...
if exist "vendor\app\installer"   rmdir /s /q "vendor\app\installer"
if exist "vendor\smart\installer" rmdir /s /q "vendor\smart\installer"

echo.
echo [7/10] Clearing bootstrap caches...
if exist "bootstrap\cache\packages.php"  del /f /q "bootstrap\cache\packages.php"
if exist "bootstrap\cache\services.php"  del /f /q "bootstrap\cache\services.php"
if exist "bootstrap\cache\config.php"    del /f /q "bootstrap\cache\config.php"
if exist "bootstrap\cache\routes-v7.php" del /f /q "bootstrap\cache\routes-v7.php"
if exist "bootstrap\cache\events.php"    del /f /q "bootstrap\cache\events.php"

echo.
echo [8/10] Running composer dump-autoload...
call composer dump-autoload -o 2>nul

echo.
echo [9/10] Clearing Laravel caches...
call php artisan optimize:clear 2>nul
call php artisan config:clear 2>nul
call php artisan route:clear 2>nul
call php artisan view:clear 2>nul
call php artisan cache:clear 2>nul

echo.
echo [10/10] Searching for any remaining installer traces...
echo   Scanning config\, app\, routes\ ...
findstr /S /M /I /C:"Smart\\Installer" /C:"app/installer" "config\*.php" "app\*.php" "routes\*.php" "bootstrap\*.php" 2>nul
if errorlevel 1 (
    echo   - No remaining references found.
) else (
    echo.
    echo   [!] The files listed above still reference the installer.
    echo       Open them and remove the related lines manually.
)

echo.
echo ============================================
echo   Smart Installer has been fully removed.
echo ============================================
pause
exit /b 0