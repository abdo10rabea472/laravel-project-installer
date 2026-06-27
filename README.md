<p align="center">
  <img src="https://laravel.com/img/logomark.min.svg" alt="Smart Installer Logo" width="120" />
</p>

<h1 align="center">📦 Smart Installer</h1>
<h3 align="center">⚙️ Laravel Installation Wizard (Package)</h3>

<p align="center">
  <strong>A complete solution for installing Laravel projects in simple steps via web or command line.</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-%3E=8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+" />
  <img src="https://img.shields.io/badge/Laravel-10%20%7C%2011%20%7C%2012%20%7C%2013-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 10-13" />
  <img src="https://img.shields.io/badge/Composer-%3E=2.0-885630?style=for-the-badge&logo=composer&logoColor=white" alt="Composer 2+" />
  <img src="https://img.shields.io/badge/License-MIT-22c55e?style=for-the-badge" alt="MIT License" />
  <img src="https://img.shields.io/badge/Platform-Windows%20%7C%20Linux%20%7C%20macOS-0ea5e9?style=for-the-badge" alt="Platform" />
  <img src="https://img.shields.io/badge/Language-EN%20%7C%20AR-7c3aed?style=for-the-badge" alt="EN / AR" />
</p>

<p align="center">
  <a href="#-overview">📖 Overview</a> •
  <a href="#%EF%B8%8F-requirements">⚙️ Requirements</a> •
  <a href="#-installation">🚀 Installation</a> •
  <a href="#-cache-commands">🧹 Cache Commands</a> •
  <a href="#-update">🔄 Update</a> •
  <a href="#%EF%B8%8F-uninstall">🗑️ Uninstall</a> •
  <a href="#-web-wizard">🪄 Web Wizard</a> •
  <a href="#%EF%B8%8F-artisan-commands">🛠️ Artisan</a>
</p>

---

## 📖 Overview

**Smart Installer** is a package designed for **Laravel 10 / 11 / 12 / 13** projects that provides a professional and easy installation experience through the browser or the command line.

### ✨ Features

| | Feature | Description |
| :-: | ------- | ----------- |
| ✅ | **Requirements Check** | Automatically verifies PHP version, required extensions, and folder permissions. |
| 🗄️ | **Database Setup** | Tests the database connection, writes settings to `.env`, and generates `APP_KEY`. |
| ⚡ | **Automatic Installation** | Runs Composer, Migration, Seeder, and Cache commands sequentially. |
| 🔒 | **Smart Lock** | After installation completes, the wizard is locked permanently (404). |
| 🌍 | **Bilingual** | Full Arabic & English language support with a light interface. |
| 💻 | **Full CLI** | Install, update, and remove via command line or ready-made `.bat` files. |

---

## ⚙️ Requirements

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php&logoColor=white" />
  <img src="https://img.shields.io/badge/Laravel-10/11/12/13-FF2D20?style=flat-square&logo=laravel&logoColor=white" />
  <img src="https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql&logoColor=white" />
  <img src="https://img.shields.io/badge/Composer-2.x-885630?style=flat-square&logo=composer&logoColor=white" />
  <img src="https://img.shields.io/badge/OpenSSL-✓-721412?style=flat-square&logo=openssl&logoColor=white" />
  <img src="https://img.shields.io/badge/PDO-✓-4479A1?style=flat-square" />
  <img src="https://img.shields.io/badge/Mbstring-✓-8892BF?style=flat-square" />
  <img src="https://img.shields.io/badge/Tokenizer-✓-8892BF?style=flat-square" />
  <img src="https://img.shields.io/badge/XML-✓-005A9C?style=flat-square&logo=xml&logoColor=white" />
  <img src="https://img.shields.io/badge/Ctype-✓-8892BF?style=flat-square" />
  <img src="https://img.shields.io/badge/JSON-✓-000000?style=flat-square&logo=json&logoColor=white" />
  <img src="https://img.shields.io/badge/BCMath-✓-8892BF?style=flat-square" />
  <img src="https://img.shields.io/badge/cURL-✓-073551?style=flat-square&logo=curl&logoColor=white" />
  <img src="https://img.shields.io/badge/Fileinfo-✓-8892BF?style=flat-square" />
</p>

| Requirement | Minimum |
| ----------- | ------- |
| 🐘 **PHP** | 8.2+ |
| 🎯 **Laravel** | 10 / 11 / 12 / 13 |
| 🎼 **Composer** | 2.x |
| 🗄️ **Database** | MySQL 5.7+ / MariaDB 10.3+ / PostgreSQL 10+ / SQLite 3 |
| 🧩 **PHP Extensions** | `openssl`, `pdo`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `curl`, `fileinfo` |
| 🔐 **Permissions** | `storage/` and `bootstrap/cache/` folders must be writable |

---

## 🚀 Installation

### 🪟 Method 1: Using `install.bat` (Easiest — Windows)

1. Copy the `packages/smart-installer` folder into your Laravel project.
2. Open `packages/install.bat` and run it by double-clicking.
3. Everything will be executed automatically:
   - ➕ Add the repository in `composer.json`
   - 📦 Install the `app/installer` package
   - 📤 Publish configuration and view files
   - 🧹 Clear cache
4. Open your browser at:

   ```
   http://127.0.0.1:8000/install
   ```

### 🐧 Method 2: Manual (Linux / macOS / Windows)

```bash
# 1. Add repository to composer.json
composer config repositories.smart-installer path "packages/smart-installer"

# 2. Install the package
composer require app/installer:@dev

# 3. Publish configuration and views
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force

# 4. Run the web wizard
php artisan serve
# Then open: http://127.0.0.1:8000/install
```

### 📝 Setting up `.env.example`

Copy the following lines from `packages/smart-installer/stubs/env.example.stub` to your project's `.env.example` file:

```env
PRODUCT_NAME="My Application"
PRODUCT_VERSION=1.0.0
PRODUCT_DESCRIPTION="A Laravel application."
PRODUCT_SUPPORT_URL="https://support.example.com"
SESSION_DRIVER=file
```

> 💡 **Note:** Do not commit `.env` with your project — the wizard creates it automatically during installation.

---

## 🧹 Cache Commands

Run these commands **after installation** (or any time you change configs, routes, views, or env values).
They are also useful when debugging or after updating the package.

### 🔥 Clear All Caches (Recommended)

```bash
# Clears: config, route, view, application & compiled cache in one go
php artisan optimize:clear
```

### 🧽 Clear Individually

```bash
php artisan cache:clear        # 🗃️  Application cache
php artisan config:clear       # ⚙️  Config cache
php artisan route:clear        # 🛣️  Route cache
php artisan view:clear         # 👀  Compiled Blade views
php artisan event:clear        # 📡  Cached events & listeners
php artisan queue:clear        # 📬  Queue jobs (default connection)
php artisan schedule:clear-cache  # 🕒  Scheduled tasks mutex cache
```

### ⚡ Rebuild (Production Cache)

```bash
# Rebuild all caches for production
php artisan optimize

# Or one by one:
php artisan config:cache       # ⚙️  Cache config
php artisan route:cache        # 🛣️  Cache routes
php artisan view:cache         # 👀  Compile & cache views
php artisan event:cache        # 📡  Cache events
```

### 🎼 Composer Cache

```bash
composer dump-autoload -o      # 🔁  Refresh autoload map
composer clear-cache           # 🧹  Clear Composer's global cache
```

### 🧨 Hard Reset (Last Resort)

```bash
# Manually wipes compiled files (use only if artisan commands fail)
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/views/*
rm -rf storage/framework/sessions/*
php artisan optimize:clear
composer dump-autoload -o
```

### 🪟 Windows (CMD / PowerShell)

```bat
del /Q /S bootstrap\cache\*.php
rmdir /S /Q storage\framework\cache\data
rmdir /S /Q storage\framework\views
rmdir /S /Q storage\framework\sessions
php artisan optimize:clear
composer dump-autoload -o
```

---

## 🪄 Web Wizard

After opening `http://127.0.0.1:8000/install`, you will go through the following steps:

```text
┌─────────────┐   ┌─────────────┐   ┌─────────────┐   ┌─────────────┐   ┌─────────────┐
│  👋 Welcome │ → │ ✅ Requirements│→│ 🗄️ Database │ → │ ⚡ Install  │ → │ 🎉 Complete │
└─────────────┘   └─────────────┘   └─────────────┘   └─────────────┘   └─────────────┘
```

### 👋 Step 1: Welcome

Displays product information, PHP version, and server details.

### ✅ Step 2: Requirements

Checks:

- PHP version (8.2+)
- Required extensions (`openssl`, `pdo`, `mbstring`, …)
- Write permissions on `storage/` and `bootstrap/cache/`

### 🗄️ Step 3: Database

- Enter connection details (database name, user, password)
- Tests the connection before proceeding
- Generates `APP_KEY` automatically if not present
- Writes settings to the `.env` file

### ⚡ Step 4: Install

The following commands are executed sequentially:

| # | Command | Description |
| :-: | ------- | ----------- |
| 1 | `composer install --no-dev --optimize-autoloader` | 📦 Install dependencies |
| 2 | `composer dump-autoload --optimize` | 🔁 Optimize autoloader |
| 3 | `php artisan migrate --force` | 🗄️ Run migrations |
| 4 | `php artisan db:seed --force` | 🌱 Seed initial data |
| 5 | `php artisan storage:link` | 🔗 Link storage folder |
| 6 | `php artisan optimize:clear` | 🧹 Clear old cache |
| 7 | `php artisan config:cache` | ⚙️ Cache config |
| 8 | `php artisan route:cache` | 🛣️ Cache routes |
| 9 | `php artisan view:cache` | 👀 Cache views |
| 10 | Lock File | 🔒 Write lock file |

> ⚠️ If a step fails, an error message will appear with a **Retry** button.

### 🎉 Step 5: Complete

- The wizard is locked permanently (404)
- You are automatically redirected to the application

---

## 🛠️ Artisan Commands

### ▶️ Full CLI Installation

```bash
php artisan installer:run
```

#### 🎛️ Additional Options

```bash
# Skip Composer steps (if dependencies are already installed)
php artisan installer:run --skip-composer

# Skip Seeding
php artisan installer:run --skip-seed

# Reinstall even if already installed
php artisan installer:run --force
```

### 🔄 Reset Installation (Remove Lock)

```bash
# Removes lock files to restart the wizard
php artisan installer:reset

# Reset without confirmation
php artisan installer:reset --force
```

### 📤 Publish Configuration and Views

```bash
php artisan vendorPrefix:setup

# Or manually:
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force
```

---

## 🔄 Update

### 🪟 Using `update.bat` (Windows)

```bash
packages/update.bat
```

### 🐧 Manual (All Systems)

```bash
# 1. Update the package
composer update app/installer --with-all-dependencies

# 2. Republish configuration and views
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force

# 3. Clear cache
php artisan optimize:clear
```

---

## 🗑️ Uninstall

> ⚠️ **Warning:** Uninstalling removes the package and all its files and settings permanently.

### 🪟 Using `uninstall.bat` (Windows)

```bash
packages/uninstall.bat
```

It will ask you to type **YES** to confirm, then it will execute:

- 🧱 Remove the package from Composer
- 🗂️ Delete the repository from `composer.json`
- ⚙️ Delete the configuration file `config/installer.php`
- 👀 Delete published views `resources/views/vendor/installer/`
- 🔓 Delete lock files
- 🧹 Clear cache

### 🐧 Manual (All Systems)

```bash
# 1. Remove the package
composer remove app/installer

# 2. Remove the repository from composer.json
composer config --unset repositories.smart-installer

# 3. Delete published files
rm -f config/installer.php
rm -rf resources/views/vendor/installer

# 4. Delete lock files
rm -f storage/app/installed.lock
rm -f storage/app/installer.lock
rm -f storage/installed
rm -f bootstrap/cache/installed.php

# 5. Clear cache
php artisan optimize:clear
composer dump-autoload -o
```

---

## 🔍 Checking Installation Status in Code

```php
use Smart\Installer\Providers\InstallerServiceProvider;
use Smart\Installer\Install\LockFile;

// Is the app installed?
$isInstalled = InstallerServiceProvider::isInstalled(); // true or false

// Read lock data
$lock = LockFile::read();
// ['domain' => '...', 'installed_at' => '...', 'php_version' => '...']
```

---

## 🔒 Security

- 🛡️ The wizard is automatically locked after installation completes (returns 404).
- 🔑 `APP_KEY` is generated automatically if not present.
- 💾 `SESSION_DRIVER=file` is enforced during installation to avoid *"sessions table does not exist"* issues.

Add these lines to your `.gitignore`:

```gitignore
storage/app/installed.lock
storage/app/install_progress.json
bootstrap/cache/installed.php
```

---

## 📁 Folder Structure

```text
packages/
├── 📦 smart-installer/           ← Package folder
│   ├── ⚙️  config/
│   │   └── installer.php         ← Package configuration
│   ├── 🎨 resources/
│   │   └── views/                ← Blade views
│   ├── 🛣️  routes/
│   │   └── installer.php         ← Routes
│   ├── 💻 src/
│   │   ├── Console/Commands/     ← Artisan commands
│   │   ├── Http/Controllers/     ← Controllers
│   │   ├── Http/Middleware/      ← Middleware
│   │   ├── Install/              ← LockFile
│   │   ├── Providers/            ← Service Provider
│   │   └── Services/             ← Installation logic
│   ├── 🧩 stubs/
│   │   └── env.example.stub      ← .env template
│   └── 🎼 composer.json
│
├── 🟢 install.bat                ← Install package
├── 🔵 update.bat                 ← Update package
└── 🔴 uninstall.bat              ← Remove package
```

---

## 📄 License

<p align="center">
  <img src="https://img.shields.io/badge/License-MIT-22c55e?style=for-the-badge" alt="MIT License" />
</p>

**MIT License** — Use it freely in your commercial and personal projects.

---

<p align="center">
  💬 If you encounter any issues, feel free to open an <strong>Issue</strong> or contact me directly via WhatsApp.<br/>
  🚀 Contributions, suggestions, and feedback are always welcome.<br/>
  ⭐ If this project helps you, please consider giving it a <strong>Star</strong> to support its development.
</p>

<p align="center">
  Made with ❤️ by <strong>Eng. Abdelrhman Rabea</strong><br/>
  Laravel Developer • Open Source Enthusiast
  <br/><br/>
  📱 <a href="https://wa.me/201068694941" target="_blank">
    WhatsApp: +20 106 869 4941
  </a>
</p>
