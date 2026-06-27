<p align="center">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>
# 🛠️ Smart Installer — Laravel Package Installation Wizard
<p align="center">
<strong>A complete, professional solution for installing Laravel projects in simple steps via Web Wizard or Command Line.</strong>
</p>
<p align="center">
<img src="https://img.shields.io/badge/Laravel-10%20%7C%2011%20%7C%2012%20%7C%2013-red?style=flat-square&logo=laravel" alt="Laravel Version">
<img src="https://img.shields.io/badge/PHP-%3E%3D%208.2-blue?style=flat-square&logo=php" alt="PHP Version">
<img src="https://img.shields.io/badge/Language-Arabic%20%7C%20English-orange?style=flat-square" alt="Languages">
<img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="License">
</p>
<p align="center">
<a href="#-what-is-smart-installer">Overview</a> •
<a href="#-requirements">Requirements</a> •
<a href="#-installation">Installation</a> •
<a href="#-web-wizard">Web Wizard</a> •
<a href="#-artisan-commands">Artisan</a> •
<a href="#-update">Update</a> •
<a href="#-uninstall">Uninstall</a>
</p>
## 🚀 What is Smart Installer?
**Smart Installer** is a premium, lightweight Laravel package designed for Laravel 10, 11, 12, and 13 projects. It offers developers a seamless, self-guided setup workflow for their clients or non-technical users to install the application through an intuitive browser wizard or a robust terminal interface.
### ✨ Key Features
 * **📋 Requirements Check** — Automatically inspects PHP versions, required core extensions, and folder write permissions.
 * **💾 Database Setup** — Live-tests database credentials, configures .env settings dynamically, and generates secure application keys on the fly.
 * **⚡ Automated Queue Installation** — Progressively executes Composer, database migrations, seeding, storage symlinks, and caching steps.
 * **🔒 Smart Lock Mechanism** — Permanently locks down /install routes with a 404 response once setup is finished to secure your production app.
 * **🇸🇦 Full Arabic Support** — Beautiful, modern right-to-left (RTL) Arabic user interface, optimized for Middle Eastern users.
 * **💻 Powerhouse CLI & Batches** — Supports automated one-click configurations via CLI and native Windows .bat helper routines.
## 📋 Requirements
Before deploying the installation package, ensure the host environment meets these baseline system parameters:

| Metric / Extension | Minimum / Required Standard |
| :--- | :--- |
| **PHP Version** | 8.2 or newer |
| **Laravel Framework** | 10.x / 11.x / 12.x / 13.x |
| **Required Extensions** | openssl, pdo, pdo_mysql, mbstring, tokenizer, xml, ctype, json, bcmath, curl, fileinfo |
| **Writable Folders** | /storage and /bootstrap/cache must have write permissions |

## ⚙️ Installation
You can integrate this local package into your Laravel system using two straightforward methods.
### Method 1: Using install.bat (Easiest — Windows Devs)
 1. Copy the folder packages/smart-installer directly into the root level of your Laravel codebase.
 2. Navigate to packages/install.bat and run it by double-clicking.
 3. The script will automatically trigger these internal tasks:
   * Inject the local repository path into composer.json
   * Pull the target dependency: app/installer
   * Publish package configs and assets
   * Flush outdated configuration cache
 4. Point your browser directory to:
   👉 http://127.0.0.1:8000/install
### Method 2: Manual Installation (Cross-Platform: Linux / macOS / Windows CLI)
```bash
# 1. Add the package directory repository to composer.json  
composer config repositories.smart-installer path "packages/smart-installer"  
  
# 2. Require the package locally  
composer require app/installer:@dev  
  
# 3. Publish configuration and layout view assets  
php artisan vendor:publish --tag=installer-config --force  
php artisan vendor:publish --tag=installer-views --force  
  
# 4. Start your Laravel development server  
php artisan serve  
# Then access: [http://127.0.0.1:8000/install](http://127.0.0.1:8000/install)
```
### 📝 Setting Up .env.example
In order for the web installer to pick up customized product identities, append the following environmental parameters to your project's main .env.example file:
```env
PRODUCT_NAME="My Application"  
PRODUCT_VERSION=1.0.0  
PRODUCT_DESCRIPTION="A Laravel application."  
PRODUCT_SUPPORT_URL="[https://support.example.com](https://support.example.com)"  
SESSION_DRIVER=file
```
> **⚠️ Security Note:** Never commit your live .env file to source repositories. The wizard is designed to generate the operational .env autonomously during the setup procedure.
> 
## 🌐 Web Wizard
Once your web server is running and you visit http://127.0.0.1:8000/install, the setup guide will walk users step-by-step through the following stages:
```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐  
│  Welcome    │  ➔  │ Requirements│  ➔  │  Database   │  ➔  │   Install   │  ➔  │  Complete   │  
└─────────────┘     └─────────────┘     └─────────────┘     └─────────────┘     └─────────────┘
```
### 🏁 Step 1: Welcome Screen
 * Welcomes the end-user with customizable product details, current server metrics, and running PHP properties.
### 🔍 Step 2: System Audit (Requirements)
Verifies critical prerequisites:
 * Matches server-side PHP to 8.2+
 * Validates active extensions (openssl, pdo, etc.)
 * Confirms correct directory write permissions for storage targets.
### 🗄️ Step 3: Database & Environment Connection
 * Collects database driver specs, ports, and login credentials.
 * Performs an on-the-spot connection test to prevent installation hang-ups.
 * Auto-creates a secure APP_KEY inside .env if none is defined.
### ⚙️ Step 4: Installation Run
The wizard triggers the following processes sequentially:

| Command Executed | Detailed Process Description |
| :--- | :--- |
| composer install --no-dev --optimize-autoloader | Resolves production dependency trees |
| composer dump-autoload --optimize | Re-maps optimal namespaces mapping |
| php artisan migrate --force | Executes database migrations |
| php artisan db:seed --force | Sows default schemas and lookup databases |
| php artisan storage:link | Exposes application assets folder |
| php artisan optimize:clear | Wipes stale runtime systems cache files |
| php artisan config:cache | Flushes state to static application settings |
| php artisan route:cache | Generates fast routing tables |
| php artisan view:cache | Pre-compiles Blade layout files |
| **Lock File Engine** | Writes out .lock checkpoints |

*If any specific stage encounters an exception, the system halts cleanly and presents a detailed error console alongside an instant "Retry" action.*
### 🎉 Step 5: Finish & Lock
 * Instantly generates lock keys on disk.
 * Reroutes incoming installations routes to 404 Not Found for maximum security.
 * Auto-directs users to the application homepage.
## 💻 Artisan Commands
### Full Command-Line Setup
You can run the full automated installation using the built-in Artisan tool:
```bash
php artisan installer:run
```
#### Available Parameters:
```bash
# Skip package download/Composer tasks (useful if vendor packages are pre-installed)  
php artisan installer:run --skip-composer  
  
# Bypass database seeding  
php artisan installer:run --skip-seed  
  
# Overwrite existing locks and force reinstall  
php artisan installer:run --force
```
### Resetting the Installer
To restart the installation environment or unlock the wizard for debugging:
```bash
# Removes all lock files to restore the setup guide  
php artisan installer:reset  
  
# Force-remove lock states without asking for manual validation  
php artisan installer:reset --force
```
### Manual Config/Asset Publishing
```bash
php artisan vendorPrefix:setup  
  
# Alternative manual publish commands:  
php artisan vendor:publish --tag=installer-config --force  
php artisan vendor:publish --tag=installer-views --force  
```
## 🔄 Update
### Option A: Using Windows Utility Script (update.bat)
Run the following script:
```bash
packages/update.bat
```
### Option B: Standard Manual Command Line (All Operating Systems)
```bash
# 1. Pull the upgraded packages code  
composer update app/installer --with-all-dependencies  
  
# 2. Overwrite out-of-date assets and configurations  
php artisan vendor:publish --tag=installer-config --force  
php artisan vendor:publish --tag=installer-views --force  
  
# 3. Purge cached configurations  
php artisan optimize:clear
```
## ❌ Uninstall
> **⚠️ Warning:** Uninstalling completely removes all system configurations, packages, scripts, and runtime lock states.
> 
### Option A: Automatic Uninstall (uninstall.bat)
Double-click packages/uninstall.bat, type YES when prompted to verify, and the engine will automatically dismantle all components.
### Option B: Manual Disassembly (All Systems)
```bash
# 1. Cleanly pull out the installation package  
composer remove app/installer  
  
# 2. Purge the repository link from composer.json  
composer config --unset repositories.smart-installer  
  
# 3. Clean up published application views and configurations  
rm -f config/installer.php  
rm -rf resources/views/vendor/installer  
  
# 4. Destroy active installations and workflow locks  
rm -f storage/app/installed.lock  
rm -f storage/app/install_progress.json  
rm -f storage/installed  
rm -f bootstrap/cache/installed.php  
  
# 5. Reset Composer cache and optimize autoloader maps  
php artisan optimize:clear  
composer dump-autoload -o
```
## 🛡️ Security & Integrity
 * **Zero-Leak Policy:** Routes linked to setup views automatically exit with a HTTP 404 status code immediately after successful installation.
 * **Auto Cryptography:** Keys are safely generated upon environment verification to prevent deployment vulnerability.
 * **Safe Sessioning:** Temporarily locks SESSION_DRIVER to file during database setups to circumvent runtime dependency failures (e.g. searching for missing session tables prior to migration).
### Recommended Ignored Entries
In order to maintain clean repositories, ensure you append these local output states to your .gitignore configuration:
```text
storage/app/installed.lock  
storage/app/install_progress.json  
bootstrap/cache/installed.php
```
## 📂 Folder Structure
```text
packages/  
├── smart-installer/           ← Core Package Folder  
│   ├── config/  
│   │   └── installer.php      ← Package Configurations  
│   ├── resources/  
│   │   └── views/             ← Multi-Language Blade Views  
│   ├── routes/  
│   │   └── installer.php      ← Safe Routing Implementations  
│   ├── src/  
│   │   ├── Console/Commands/  ← Artisan CLI Orchestrations  
│   │   ├── Http/Controllers/  ← Route Controllers  
│   │   ├── Http/Middleware/   ← Lock-State Middleware Filters  
│   │   ├── Install/           ← LockFile Core Files  
│   │   ├── Providers/         ← Package Service Provider  
│   │   └── Services/          ← Core Installations Logic  
│   ├── stubs/  
│   │   └── env.example.stub   ← Baseline Environment Template  
│   └── composer.json  
│  
├── install.bat                ← Fast Package Integrator (Windows)  
├── update.bat                 ← Package Updater Utility (Windows)  
└── uninstall.bat              ← Complete Package Remover (Windows)  
```
## 🔌 Checking Setup Status programmatically
You can check the installation state and retrieve metadata dynamically in your application:
```php
use Smart\Installer\Providers\InstallerServiceProvider;  
use Smart\Installer\Install\LockFile;  
  
// Check if the application is currently installed  
$isInstalled = InstallerServiceProvider::isInstalled(); // returns true or false  
  
// Extract recorded system environment parameters upon setup  
$lock = LockFile::read();  
// Returns: ['domain' => '...', 'installed_at' => '...', 'php_version' => '...']
```
## 📄 License
The Smart Installer package is open-sourced software licensed under the **MIT License**. Feel free to incorporate it into your personal or commercial systems.
<p align="center">
إذا واجهتك أي مشكلة أثناء التثبيت أو الاستخدام، يرجى فتح <strong>Issue</strong> وسيقوم فريق العمل بمساعدتك فورًا!
</p>
