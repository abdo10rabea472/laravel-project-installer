<div dir="rtl">

# 📦 Smart Installer — معالج تثبيت Laravel (Package)

<p align="center">
  <strong>حل متكامل لتثبيت مشاريع Laravel بخطوات بسيطة عبر الويب أو سطر الأوامر</strong>
</p>

<p align="center">
  <a href="#-نظرة-عامة">نظرة عامة</a> •
  <a href="#%EF%B8%8F-المتطلبات">المتطلبات</a> •
  <a href="#-التثبيت">التثبيت</a> •
  <a href="#-التحديث">التحديث</a> •
  <a href="#%EF%B8%8F-إلغاء-التثبيت">إلغاء التثبيت</a> •
  <a href="#-معالج-الويب-web-wizard">معالج الويب</a> •
  <a href="#%EF%B8%8F-أوامر-artisan">أوامر Artisan</a>
</p>

---

## 📖 نظرة عامة

**Smart Installer** هو _package_ مخصّص لمشاريع **Laravel 10 / 11 / 12 / 13**، يقدّم تجربة تثبيت احترافية وسهلة من خلال المتصفح أو سطر الأوامر.

### ✨ المميزات

- **فحص المتطلبات** — يتحقق تلقائيًا من إصدار PHP، والإضافات المطلوبة، وصلاحيات المجلدات.
- **إعداد قاعدة البيانات** — يختبر الاتصال، يكتب الإعدادات في `.env`، ويُولِّد `APP_KEY`.
- **تثبيت تلقائي** — يُشغّل أوامر Composer و Migration و Seeder و Cache بالتسلسل.
- **قفل ذكي** — بعد اكتمال التثبيت يُقفل المعالج بشكل دائم (404) لحماية التطبيق.
- **تجربة عربية** — دعم كامل للغة العربية بواجهة خفيفة وسهلة الاستخدام.
- **CLI كامل** — يمكنك التثبيت والتحديث والإزالة عبر سطر الأوامر أو ملفات `.bat` جاهزة.

---

## ⚙️ المتطلبات

| المتطلب    | الحد الأدنى                                                                                                  |
| ---------- | ------------------------------------------------------------------------------------------------------------ |
| PHP        | 8.2+                                                                                                         |
| Laravel    | 10 / 11 / 12 / 13                                                                                            |
| إضافات PHP | `openssl`, `pdo`, `pdo_mysql`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `curl`, `fileinfo` |
| الصلاحيات  | يجب أن يكون مجلد `storage/` و `bootstrap/cache/` قابلًا للكتابة                                              |

---

## 🚀 التثبيت

### الطريقة 1: باستخدام `install.bat` (الأسهل — Windows)

1. انسخ مجلد `packages/smart-installer` داخل مشروع Laravel الخاص بك.
2. افتح ملف `packages/install.bat` وشغّله بالنقر المزدوج.
3. سيتم تنفيذ كل شيء تلقائيًا:
   - إضافة الـ Repository في `composer.json`
   - تثبيت الـ package باسم `app/installer`
   - نشر ملفات الإعدادات والـ Views
   - تنظيف الـ Cache
4. افتح المتصفح على:

   ```
   http://127.0.0.1:8000/install
   ```

### الطريقة 2: يدويًا (Linux / macOS / Windows)

```bash
# 1. إضافة الـ repository إلى composer.json
composer config repositories.smart-installer path "packages/smart-installer"

# 2. تثبيت الـ package
composer require app/installer:@dev

# 3. نشر الإعدادات والـ views
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force

# 4. تشغيل معالج الويب
php artisan serve
# ثم افتح: http://127.0.0.1:8000/install
```

### إعداد ملف `.env.example`

انسخ السطور التالية من `packages/smart-installer/stubs/env.example.stub` إلى ملف `.env.example` الخاص بمشروعك:

```env
PRODUCT_NAME="My Application"
PRODUCT_VERSION=1.0.0
PRODUCT_DESCRIPTION="A Laravel application."
PRODUCT_SUPPORT_URL="https://support.example.com"
SESSION_DRIVER=file
```

> **ملاحظة:** لا تقم برفع ملف `.env` مع مشروعك — المعالج ينشئه تلقائيًا أثناء التثبيت.

---

## 🪄 معالج الويب (Web Wizard)

بعد فتح الرابط `http://127.0.0.1:8000/install` ستمر بالخطوات التالية:

```text
┌─────────────┐   ┌─────────────┐   ┌─────────────┐   ┌─────────────┐   ┌─────────────┐
│   ترحيب    │ → │  المتطلبات  │ → │ قاعدة بيانات│ → │   تثبيت    │ → │   اكتمال   │
└─────────────┘   └─────────────┘   └─────────────┘   └─────────────┘   └─────────────┘
```

### الخطوة 1: الترحيب

يعرض معلومات المنتج، إصدار PHP، وبيانات السيرفر.

### الخطوة 2: المتطلبات

يتم التحقق من:

- إصدار PHP (8.2+)
- الإضافات المطلوبة (`openssl`, `pdo`, `mbstring`, …)
- صلاحيات الكتابة على `storage/` و `bootstrap/cache/`

### الخطوة 3: قاعدة البيانات

- إدخال بيانات الاتصال (اسم القاعدة، المستخدم، كلمة المرور)
- اختبار الاتصال قبل الانتقال للخطوة التالية
- توليد `APP_KEY` تلقائيًا إذا لم يكن موجودًا
- كتابة الإعدادات في ملف `.env`

### الخطوة 4: التثبيت

يتم تنفيذ الأوامر التالية بالتسلسل:

| الأمر                                             | الوصف                  |
| ------------------------------------------------- | ---------------------- |
| `composer install --no-dev --optimize-autoloader` | تثبيت الاعتمادات       |
| `composer dump-autoload --optimize`               | تحسين الـ Autoloader   |
| `php artisan migrate --force`                     | تشغيل الـ Migrations   |
| `php artisan db:seed --force`                     | إدخال البيانات الأولية |
| `php artisan storage:link`                        | ربط مجلد التخزين       |
| `php artisan optimize:clear`                      | تنظيف الكاش القديم     |
| `php artisan config:cache`                        | تخزين الإعدادات        |
| `php artisan route:cache`                         | تخزين المسارات         |
| `php artisan view:cache`                          | تخزين الـ Views        |
| Lock File                                         | كتابة ملف القفل        |

> في حال فشل أي خطوة ستظهر رسالة خطأ مع زر **إعادة المحاولة**.

### الخطوة 5: الاكتمال

- يُقفل المعالج بشكل دائم (404)
- يتم توجيهك تلقائيًا إلى التطبيق

---

## 🛠️ أوامر Artisan

### تثبيت كامل عبر CLI

```bash
php artisan installer:run
```

#### خيارات إضافية

```bash
# تخطّي خطوات Composer (إذا كانت الاعتمادات مثبتة بالفعل)
php artisan installer:run --skip-composer

# تخطّي الـ Seeding
php artisan installer:run --skip-seed

# إعادة التثبيت حتى لو كان مثبتًا بالفعل
php artisan installer:run --force
```

### إعادة تعيين التثبيت (إزالة القفل)

```bash
# يحذف ملفات القفل لإعادة تشغيل المعالج
php artisan installer:reset

# إعادة تعيين بدون تأكيد
php artisan installer:reset --force
```

### نشر الإعدادات والـ Views

```bash
php artisan vendorPrefix:setup

# أو يدويًا:
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force
```

---

## 🔄 التحديث

### باستخدام `update.bat` (Windows)

```bash
packages/update.bat
```

### يدويًا (لكل الأنظمة)

```bash
# 1. تحديث الـ package
composer update app/installer --with-all-dependencies

# 2. إعادة نشر الإعدادات والـ views
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force

# 3. تنظيف الكاش
php artisan optimize:clear
```

---

## 🗑️ إلغاء التثبيت

> **تحذير:** إلغاء التثبيت يحذف الـ package وجميع ملفاته وإعداداته بشكل دائم.

### باستخدام `uninstall.bat` (Windows)

```bash
packages/uninstall.bat
```

سيُطلب منك كتابة **YES** للتأكيد، ثم يتم تنفيذ:

- إزالة الـ package من Composer
- حذف الـ repository من `composer.json`
- حذف ملف الإعدادات `config/installer.php`
- حذف الـ views المنشورة `resources/views/vendor/installer/`
- حذف ملفات القفل
- تنظيف الكاش

### يدويًا (لكل الأنظمة)

```bash
# 1. إزالة الـ package
composer remove app/installer

# 2. حذف الـ repository من composer.json
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

## 🔍 التحقق من حالة التثبيت في الكود

```php
use Smart\Installer\Providers\InstallerServiceProvider;
use Smart\Installer\Install\LockFile;

// هل التطبيق مثبت؟
$isInstalled = InstallerServiceProvider::isInstalled(); // true أو false

// قراءة بيانات ملف القفل
$lock = LockFile::read();
// ['domain' => '...', 'installed_at' => '...', 'php_version' => '...']
```

---

## 🔒 الأمان

- يُقفل المعالج تلقائيًا بعد اكتمال التثبيت (يُرجع 404).
- يتم توليد `APP_KEY` تلقائيًا إذا لم يكن موجودًا.
- يتم فرض `SESSION_DRIVER=file` أثناء التثبيت لتجنّب خطأ _"sessions table does not exist"_.

أضف الأسطر التالية إلى ملف `.gitignore`:

```gitignore
storage/app/installed.lock
storage/app/install_progress.json
bootstrap/cache/installed.php
```

---

## 📁 هيكل المجلدات

```text
packages/
├── smart-installer/           ← مجلد الـ package
│   ├── config/
│   │   └── installer.php      ← إعدادات الـ package
│   ├── resources/
│   │   └── views/             ← ملفات Blade
│   ├── routes/
│   │   └── installer.php      ← المسارات
│   ├── src/
│   │   ├── Console/Commands/  ← أوامر Artisan
│   │   ├── Http/Controllers/  ← الـ Controllers
│   │   ├── Http/Middleware/   ← الـ Middleware
│   │   ├── Install/           ← LockFile
│   │   ├── Providers/         ← Service Provider
│   │   └── Services/          ← منطق التثبيت
│   ├── stubs/
│   │   └── env.example.stub   ← قالب .env
│   └── composer.json
│
├── install.bat                ← تثبيت الـ package
├── update.bat                 ← تحديث الـ package
└── uninstall.bat              ← إزالة الـ package
```

---

## 📄 الترخيص

**MIT License** — استخدمه بحرية في مشاريعك التجارية والشخصية.

---

<p align="center">
  لو واجهتك أي مشكلة، افتح <strong>Issue</strong> وهنساعدك في حلها.
</p>

</div>
