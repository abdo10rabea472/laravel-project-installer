# Smart Installer — معالج تثبيت Laravel

<p align="center">
  <strong>حل متكامل لتثبيت مشاريع Laravel بخطوات بسيطة عبر الويب أو سطر الأوامر</strong>
</p>

<p align="center">
  <a href="#-ما-هو-smart-installer">الشرح</a> •
  <a href="#-المتطلبات">المتطلبات</a> •
  <a href="#-طريقة-التثبيت">التثبيت</a> •
  <a href="#-طريقة-التحديث">التحديث</a> •
  <a href="#-طريقة-الحذف">الحذف</a> •
  <a href="#-استخدام-معالج-الويب">معالج الويب</a> •
  <a href="#-أوامر-artisan">Artisan</a>
</p>

---

## ما هو Smart Installer؟

**Smart Installer** هو إضافة (Package) مخصصة لمشاريع **Laravel 10 / 11 / 12** توفر تجربة تثبيت احترافية وسهلة عبر المتصفح أو سطر الأوامر.

### مميزاته:

- **فحص المتطلبات** — يتحقق تلقائيًا من إصدار PHP والإضافات المطلوبة وصلاحيات المجلدات.
- **إعداد قاعدة البيانات** — يختبر الاتصال بقاعدة البيانات ويكتب الإعدادات في ملف `.env` ويولد `APP_KEY`.
- **تثبيت تلقائي** — يشغل أوامر Composer وMigration وSeeder وCache بشكل متسلسل.
- **قفل ذكي** — بعد اكتمال التثبيت يتم قفل المعالج نهائيًا (404) لحماية التطبيق.
- **تجربة عربية** — يدعم اللغة العربية بالكامل مع واجهة فاتحة وسهلة الاستخدام.
- **CLI كامل** — يمكنك التثبيت والتحديث والحذف عبر سطر الأوامر أو ملفات `.bat` الجاهزة.

---

## المتطلبات

| المتطلب | الحد الأدنى |
|---------|-------------|
| PHP | 8.2+ |
| Laravel | 10 / 11 / 12 |
| إضافات PHP | openssl, pdo, pdo_mysql, mbstring, tokenizer, xml, ctype, json, bcmath, curl, fileinfo |
| صلاحيات | يجب أن تكون مجلدات `storage/` و `bootstrap/cache/` قابلة للكتابة |

---

## طريقة التثبيت

### الطريقة الأولى: عبر ملف `install.bat` (أسهل طريقة — Windows)

1. انسخ مجلد `packages/smart-installer` داخل مشروعك Laravel.
2. افتح ملف `packages/install.bat` وشغله بالضغط مرتين.
3. سيتم تنفيذ كل شيء تلقائيًا:
   - إضافة Repository في `composer.json`
   - تثبيت البكج `app/installer`
   - نشر ملفات الإعدادات والواجهات
   - تنظيف الكاش

4. افتح المتصفح على الرابط:
   ```
   http://127.0.0.1:8000/install
   ```

### الطريقة الثانية: يدويًا (Linux / macOS / Windows)

```bash
# 1. أضف repository في composer.json
composer config repositories.smart-installer path "packages/smart-installer"

# 2. ثبت البكج
composer require app/installer:@dev

# 3. نشر الإعدادات والواجهات
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force

# 4. شغل المعالج عبر الويب
php artisan serve
# ثم افتح: http://127.0.0.1:8000/install
```

### إعداد ملف `.env.example`

انسخ الأسطر التالية من `packages/smart-installer/stubs/env.example.stub` إلى ملف `.env.example` في مشروعك:

```dotenv
PRODUCT_NAME="My Application"
PRODUCT_VERSION=1.0.0
PRODUCT_DESCRIPTION="A Laravel application."
PRODUCT_SUPPORT_URL="https://support.example.com"
SESSION_DRIVER=file
```

> **ملاحظة:** لا ترسل ملف `.env` مع المشروع — المعالج ينشئه تلقائيًا أثناء التثبيت.

---

## استخدام معالج الويب

بعد فتح `http://127.0.0.1:8000/install`، ستمر بالخطوات التالية:

```
┌─────────────┐   ┌─────────────┐   ┌─────────────┐   ┌─────────────┐   ┌─────────────┐
│  Welcome    │ → │ Requirements│ → │  Database   │ → │   Install   │ → │  Complete   │
│  ترحيب      │   │  المتطلبات   │   │ قاعدة البيانات│   │  التثبيت    │   │  اكتمال     │
└─────────────┘   └─────────────┘   └─────────────┘   └─────────────┘   └─────────────┘
```

### الخطوة 1: Welcome (ترحيب)
يعرض معلومات المنتج وإصدار PHP والسيرفر.

### الخطوة 2: Requirements (المتطلبات)
يفحص:
- إصدار PHP (8.2+)
- الإضافات المطلوبة (openssl, pdo, mbstring, ...)
- صلاحيات الكتابة على `storage/` و `bootstrap/cache/`

### الخطوة 3: Database (قاعدة البيانات)
- أدخل بيانات الاتصال (اسم قاعدة البيانات، المستخدم، كلمة المرور)
- يختبر الاتصال قبل المتابعة
- يولد `APP_KEY` تلقائيًا إذا لم يكن موجودًا
- يكتب الإعدادات في ملف `.env`

### الخطوة 4: Install (التثبيت)
يتم تنفيذ الأوامر التالية بالتسلسل:

| الأمر | الوصف |
|-------|-------|
| `composer install --no-dev --optimize-autoloader` | تثبيت Dependencies |
| `composer dump-autoload --optimize` | تحسين Autoloader |
| `php artisan migrate --force` | تشغيل Migrations |
| `php artisan db:seed --force` | تعبئة البيانات الأولية |
| `php artisan storage:link` | ربط مجلد Storage |
| `php artisan optimize:clear` | مسح الكاش القديم |
| `php artisan config:cache` | كاش الإعدادات |
| `php artisan route:cache` | كاش الراوتات |
| `php artisan view:cache` | كاش الـ Views |
| **Lock File** | كتابة ملف القفل |

> إذا فشل أحد الخطوات، يظهر لك رسالة الخطأ مع زر **إعادة المحاولة**.

### الخطوة 5: Complete (اكتمال)
- يتم قفل المعالج نهائيًا (404)
- يتم توجيهك تلقائيًا إلى التطبيق

---

## أوامر Artisan

### تثبيت كامل عبر CLI
```bash
php artisan installer:run
```

### خيارات إضافية:
```bash
# تخطي خطوات Composer (إذا كانت الـ Dependencies مثبتة بالفعل)
php artisan installer:run --skip-composer

# تخطي Seeding
php artisan installer:run --skip-seed

# إعادة التثبيت حتى لو كان مثبتًا
php artisan installer:run --force
```

### إعادة ضبط التثبيت (إزالة القفل)
```bash
# يزيل ملفات القفل لإعادة تشغيل المعالج
php artisan installer:reset

# إعادة ضبط بدون تأكيد
php artisan installer:reset --force
```

### نشر الإعدادات والواجهات
```bash
php artisan vendorPrefix:setup

# أو يدويًا:
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force
```

---

## طريقة التحديث

### عبر ملف `update.bat` (Windows)
```bash
packages/update.bat
```

### يدويًا (جميع الأنظمة)
```bash
# 1. تحديث البكج
composer update app/installer --with-all-dependencies

# 2. إعادة نشر الإعدادات والواجهات
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force

# 3. تنظيف الكاش
php artisan optimize:clear
```

---

## طريقة الحذف

> **تحذير:** الحذف يزيل البكج وكل ملفاته وإعداداته نهائيًا.

### عبر ملف `uninstall.bat` (Windows)
```bash
packages/uninstall.bat
```

سيطلب منك كتابة `YES` للتأكيد، ثم ينفذ:
- إزالة البكج من Composer
- حذف repository من `composer.json`
- حذف ملف الإعدادات `config/installer.php`
- حذف الواجهات المنشورة `resources/views/vendor/installer/`
- حذف ملفات القفل
- تنظيف الكاش

### يدويًا (جميع الأنظمة)
```bash
# 1. إزالة البكج
composer remove app/installer

# 2. حذف repository من composer.json
composer config --unset repositories.smart-installer

# 3. حذف الملفات المنشورة
rm -f config/installer.php
rm -rf resources/views/vendor/installer

# 4. حذف ملفات القفل
rm -f storage/app/installed.lock
rm -f storage/app/installer.lock
rm -f storage/installed
rm -f bootstrap/cache/installed.php

# 5. تنظيف الكاش
php artisan optimize:clear
composer dump-autoload -o
```

---

## التحقق من حالة التثبيت في الكود

```php
use Smart\Installer\Providers\InstallerServiceProvider;
use Smart\Installer\Install\LockFile;

// هل التطبيق مثبت؟
$isInstalled = InstallerServiceProvider::isInstalled(); // true أو false

// قراءة بيانات القفل
$lock = LockFile::read();
// ['domain' => '...', 'installed_at' => '...', 'php_version' => '...']
```

---

## الأمان

- المعالج **يُقفل تلقائيًا** بعد اكتمال التثبيت (يُرجع 404).
- يتم توليد `APP_KEY` تلقائيًا إذا لم يكن موجودًا.
- يتم إجبار `SESSION_DRIVER=file` أثناء التثبيت لتجنب مشكلة "جدول sessions غير موجود".

أضف هذه الأسطر إلى `.gitignore`:
```
storage/app/installed.lock
storage/app/install_progress.json
bootstrap/cache/installed.php
```

---

## هيكل المجلدات

```
packages/
├── smart-installer/           ← مجلد البكج
│   ├── config/
│   │   └── installer.php      ← إعدادات البكج
│   ├── resources/
│   │   └── views/             ← واجهات Blade
│   ├── routes/
│   │   └── installer.php      ← الراوتات
│   ├── src/
│   │   ├── Console/Commands/  ← أوامر Artisan
│   │   ├── Http/Controllers/  ← الـ Controllers
│   │   ├── Http/Middleware/   ← الـ Middleware
│   │   ├── Install/           ← LockFile
│   │   ├── Providers/         ← Service Provider
│   │   └── Services/          ← منطق التثبيت
│   ├── stubs/
│   │   └── env.example.stub   ← نموذج .env
│   └── composer.json
│
├── install.bat                  ← تثبيت البكج
├── update.bat                   ← تحديث البكج
└── uninstall.bat                ← حذف البكج
```

---

## الترخيص

MIT License — استخدمه بحرية في مشاريعك التجارية والشخصية.

---

<p align="center">
  إذا واجهتك أي مشكلة، افتح <strong>Issue</strong> وسنساعدك بحلها.
</p>
