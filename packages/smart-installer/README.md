# app/installer

**Standalone Laravel Installer Wizard** — requirements check, database setup, migrations & seeding.

---

## What it does

A simple, self-contained installation wizard for any Laravel 10/11/12 project:

1. **Welcome** — shows product info and server details
2. **Requirements** — checks PHP version, extensions, folder permissions
3. **Database** — tests connection, writes `.env`, generates `APP_KEY`
4. **Install** — runs `composer install`, `migrate`, `db:seed`, cache commands
5. **Complete** — writes lock files, permanently disables the installer

That's it — pure local setup.

---

## Installation

### 1. Copy the package into your project

```
your-laravel-project/
├── packages/
│   └── smart-installer/    ← copy this folder here
├── composer.json
```

### 2. Add to composer.json

```json
{
    "repositories": [
        { "type": "path", "url": "packages/smart-installer" }
    ],
    "require": {
        "app/installer": "@dev"
    }
}
```

### 3. Install

```bash
composer require app/installer:@dev
php artisan installer:setup
```

`installer:setup` runs publishing with a live progress bar so you can
see exactly what is happening at each step.

> **If you previously installed this package under the old name `smart/installer`**,
> delete these before re-installing to clear stale class maps:
> ```bash
> rm -rf vendor composer.lock bootstrap/cache/*.php
> composer install
> ```

### 4. Set up your .env.example

Copy entries from `stubs/env.example.stub` into your project's `.env.example`:

```dotenv
PRODUCT_NAME="My App"
PRODUCT_VERSION=1.0.0
SESSION_DRIVER=file
```

### 5. Ship without `.env`

Don't include a `.env` file in your distribution — only `.env.example`.
The installer creates and populates `.env` automatically.

---

## How It Works

```
Customer visits https://myapp.com/anything
        ↓
RedirectToInstaller middleware fires
        ↓
Redirect to /install
        ↓
Wizard: Welcome → Requirements → Database → Install → Complete
        ↓
storage/app/installed.lock + bootstrap/cache/installed.php written
        ↓
/install returns 404 permanently
        ↓
App is live
```

### Installation commands executed (Step 4)

```bash
composer install --no-dev --optimize-autoloader
composer dump-autoload --optimize
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
# then writes lock files
```

---

## Artisan Commands

```bash
# Run the full installation from CLI (CI/CD, Docker)
php artisan installer:run

# Skip composer steps (when dependencies already installed)
php artisan installer:run --skip-composer

# Skip database seeding
php artisan installer:run --skip-seed

# Force re-run even if already installed
php artisan installer:run --force

# Remove lock files to re-enable the installer
php artisan installer:reset
php artisan installer:reset --force
```

---

## Checking Installation Status in Code

```php
use Smart\Installer\Providers\InstallerServiceProvider;
use Smart\Installer\Install\LockFile;

InstallerServiceProvider::isInstalled(); // true/false

$lock = LockFile::read();
// ['domain' => '...', 'installed_at' => '...', 'php_version' => '...', ...]
```

---

## Customising Views

```bash
php artisan vendor:publish --tag=installer-views
```

Published to `resources/views/vendor/installer/`.

---

## Security

- The installer is **permanently disabled** after lock files are created (HTTP 404)
- `APP_KEY` is auto-generated during database setup if missing

Add to your `.gitignore`:
```
storage/app/installed.lock
storage/app/install_progress.json
bootstrap/cache/installed.php
```

---

## Common Issue: "sessions table not found"

If `SESSION_DRIVER=database` is set as default, Laravel will try to query
the `sessions` table before migrations run, causing:

```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'db.sessions' doesn't exist
```

**This package handles it automatically** by forcing `SESSION_DRIVER=file`
during the entire installation process. Once installed, your app uses
whatever `SESSION_DRIVER` you've configured in `.env`.

---

## Requirements

| | Minimum |
|--|--|
| PHP | 8.2+ |
| Laravel | 10 / 11 / 12 |
| Extensions | openssl, pdo, pdo_mysql, curl, fileinfo, bcmath |
| Permissions | `storage/` and `bootstrap/cache/` must be writable |
