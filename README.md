# Smart Installer — Laravel Installation Wizard

<p align="center">
  <strong>A complete solution for installing Laravel projects in simple steps via web or command line</strong>
</p>

<p align="center">
  <a href="#-what-is-smart-installer">Overview</a> •
  <a href="#-requirements">Requirements</a> •
  <a href="#-installation">Installation</a> •
  <a href="#-update">Update</a> •
  <a href="#-uninstall">Uninstall</a> •
  <a href="#-web-wizard">Web Wizard</a> •
  <a href="#-artisan-commands">Artisan</a>
</p>

---

## What is Smart Installer?

**Smart Installer** is a package designed for **Laravel 10 / 11 / 12 / 13** projects that provides a professional and easy installation experience through the browser or command line.

### Features:

- **Requirements Check** — Automatically verifies PHP version, required extensions, and folder permissions.
- **Database Setup** — Tests the database connection, writes settings to `.env`, and generates `APP_KEY`.
- **Automatic Installation** — Runs Composer, Migration, Seeder, and Cache commands sequentially.
- **Smart Lock** — After installation completes, the wizard is locked permanently (404) to protect the application.
- **Arabic Experience** — Full Arabic language support with a light and easy-to-use interface.
- **Full CLI** — You can install, update, and remove via command line or ready-made `.bat` files.

---

## Requirements

| Requirement | Minimum |
|---------|-------------|
| PHP | 8.2+ |
| Laravel | 10 / 11 / 12 /13 |
| PHP Extensions | openssl, pdo, pdo_mysql, mbstring, tokenizer, xml, ctype, json, bcmath, curl, fileinfo |
| Permissions | `storage/` and `bootstrap/cache/` folders must be writable |

---

## Installation

### Method 1: Using `install.bat` (Easiest — Windows)

1. Copy the `packages/smart-installer` folder into your Laravel project.
2. Open `packages/install.bat` and run it by double-clicking.
3. Everything will be executed automatically:
   - Add Repository in `composer.json`
   - Install the `app/installer` package
   - Publish configuration and view files
   - Clear cache

4. Open your browser at:
   ```
   http://127.0.0.1:8000/install
   ```

### Method 2: Manual (Linux / macOS / Windows)

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

### Setting up `.env.example`

Copy the following lines from `packages/smart-installer/stubs/env.example.stub` to your project's `.env.example` file:

```dotenv
PRODUCT_NAME="My Application"
PRODUCT_VERSION=1.0.0
PRODUCT_DESCRIPTION="A Laravel application."
PRODUCT_SUPPORT_URL="https://support.example.com"
SESSION_DRIVER=file
```

> **Note:** Do not commit `.env` with your project — the wizard creates it automatically during installation.

---

## Web Wizard

After opening `http://127.0.0.1:8000/install`, you will go through the following steps:

```
┌─────────────┐   ┌─────────────┐   ┌─────────────┐   ┌─────────────┐   ┌─────────────┐
│  Welcome    │ → │ Requirements│ → │  Database   │ → │   Install   │ → │  Complete   │
└─────────────┘   └─────────────┘   └─────────────┘   └─────────────┘   └─────────────┘
```

### Step 1: Welcome
Displays product information, PHP version, and server details.

### Step 2: Requirements
Checks:
- PHP version (8.2+)
- Required extensions (openssl, pdo, mbstring, ...)
- Write permissions on `storage/` and `bootstrap/cache/`

### Step 3: Database
- Enter connection details (database name, user, password)
- Tests the connection before proceeding
- Generates `APP_KEY` automatically if not present
- Writes settings to `.env` file

### Step 4: Install
The following commands are executed sequentially:

| Command | Description |
|-------|-------|
| `composer install --no-dev --optimize-autoloader` | Install Dependencies |
| `composer dump-autoload --optimize` | Optimize Autoloader |
| `php artisan migrate --force` | Run Migrations |
| `php artisan db:seed --force` | Seed Initial Data |
| `php artisan storage:link` | Link Storage Folder |
| `php artisan optimize:clear` | Clear Old Cache |
| `php artisan config:cache` | Cache Config |
| `php artisan route:cache` | Cache Routes |
| `php artisan view:cache` | Cache Views |
| **Lock File** | Write lock file |

> If a step fails, an error message will appear with a **Retry** button.

### Step 5: Complete
- The wizard is locked permanently (404)
- You are automatically redirected to the application

---

## Artisan Commands

### Full CLI Installation
```bash
php artisan installer:run
```

### Additional Options:
```bash
# Skip Composer steps (if dependencies are already installed)
php artisan installer:run --skip-composer

# Skip Seeding
php artisan installer:run --skip-seed

# Reinstall even if already installed
php artisan installer:run --force
```

### Reset Installation (Remove Lock)
```bash
# Removes lock files to restart the wizard
php artisan installer:reset

# Reset without confirmation
php artisan installer:reset --force
```

### Publish Configuration and Views
```bash
php artisan vendorPrefix:setup

# Or manually:
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force
```

---

## Update

### Using `update.bat` (Windows)
```bash
packages/update.bat
```

### Manual (All Systems)
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

## Uninstall

> **Warning:** Uninstalling removes the package and all its files and settings permanently.

### Using `uninstall.bat` (Windows)
```bash
packages/uninstall.bat
```

It will ask you to type `YES` to confirm, then it will execute:
- Remove the package from Composer
- Delete repository from `composer.json`
- Delete configuration file `config/installer.php`
- Delete published views `resources/views/vendor/installer/`
- Delete lock files
- Clear cache

### Manual (All Systems)
```bash
# 1. Remove the package
composer remove app/installer

# 2. Remove repository from composer.json
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

## Checking Installation Status in Code

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

## Security

- The wizard is **automatically locked** after installation completes (returns 404).
- `APP_KEY` is generated automatically if not present.
- `SESSION_DRIVER=file` is enforced during installation to avoid "sessions table does not exist" issues.

Add these lines to `.gitignore`:
```
storage/app/installed.lock
storage/app/install_progress.json
bootstrap/cache/installed.php
```

---

## Folder Structure

```
packages/
├── smart-installer/           ← Package folder
│   ├── config/
│   │   └── installer.php      ← Package configuration
│   ├── resources/
│   │   └── views/             ← Blade views
│   ├── routes/
│   │   └── installer.php      ← Routes
│   ├── src/
│   │   ├── Console/Commands/  ← Artisan commands
│   │   ├── Http/Controllers/  ← Controllers
│   │   ├── Http/Middleware/   ← Middleware
│   │   ├── Install/           ← LockFile
│   │   ├── Providers/         ← Service Provider
│   │   └── Services/          ← Installation logic
│   ├── stubs/
│   │   └── env.example.stub   ← .env template
│   └── composer.json
│
├── install.bat                  ← Install package
├── update.bat                   ← Update package
└── uninstall.bat                ← Remove package
```

---

## License

MIT License — Use it freely in your commercial and personal projects.

---

<p align="center">
  If you encounter any issues, open an <strong>Issue</strong> and we'll help you solve it.
</p>
