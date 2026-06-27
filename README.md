<p align="center">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="350" alt="Laravel Logo">
</p>
# 🛠️ Smart Installer — Laravel Installation Wizard Package
<p align="center">
<strong>الحل البرمجي المتكامل والاحترافي لتثبيت مشاريع Laravel بسهولة تامة عبر واجهة ويب تفاعلية أو من خلال سطر الأوامر (CLI)</strong>
</p>
<p align="center">
<img src="https://img.shields.io/badge/Laravel-10%20%7C%2011%20%7C%2012%20%7C%2013-red?style=for-the-badge&logo=laravel" alt="Laravel Version">
<img src="https://img.shields.io/badge/PHP-%3E%3D%208.2-blue?style=for-the-badge&logo=php" alt="PHP Version">
<img src="https://img.shields.io/badge/Language-Arabic%20%7C%20English-orange?style=for-the-badge" alt="Languages">
<img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>
## 📌 الفهرس السريع (Table of Contents)
 1. 📖 لمحة عامة عن الحزمة
 2. 📋 المتطلبات التقنية للنظام
 3. ⚙️ طرق تثبيت الحزمة
   * الطريقة الأولى: التثبيت التلقائي (Windows)
   * الطريقة الثانية: التثبيت اليدوي (Linux / macOS / Windows)
 4. 📝 تهيئة ملف البيئة (.env.example)
 5. 🌐 معالج التثبيت عبر الويب (Web Wizard)
   * خطوات التثبيت بالتفصيل
 6. 💻 أوامر Artisan وسطر الأوامر
 7. 🛡️ ميزات الأمان والحماية
 8. 🔌 فحص حالة التثبيت برمجياً
 9. 🔄 تحديث وترقية الحزمة
 10. ❌ إلغاء التثبيت والحذف الكامل
 11. 📂 بنية وتفصيل مجلدات الحزمة
 12. ❓ الأسئلة الشائعة وحل المشكلات (Troubleshooting)
 13. 📄 الترخيص والمساهمة
## 📖 لمحة عامة عن الحزمة
حزمة **Smart Installer** هي أداة برمجية ذكية وخفيفة الوزن، مصممة خصيصاً لمطوري إطار العمل **Laravel** (الإصدارات 10، 11، 12، و13). تهدف الحزمة إلى توفير تجربة تثبيت احترافية وخالية من التعقيد للمستخدم النهائي أو العميل الذي لا يمتلك خلفية برمجية، من خلال واجهة ويب تفاعلية باللغتين العربية والإنجليزية، أو عبر سطر الأوامر للمطورين.
### ✨ أبرز المميزات:
 * **فحص بيئة التشغيل:** التحقق التلقائي من إصدار PHP، توفر الإضافات المطلوبة، وصلاحيات المجلدات الحيوية.
 * **إعداد قاعدة البيانات التفاعلي:** اختبار الاتصال بقاعدة البيانات لحظياً للتأكد من صحة البيانات قبل تطبيقها.
 * **تنفيذ المهام المتتالية:** تشغيل أوامر المهاجرة (Migrations)، البيانات الأولية (Seeding)، ربط التخزين (Storage Link)، وبناء التخزين المؤقت (Caching) بشكل آلي ومتتابع.
 * **الحماية الذكية (Smart Lock):** بمجرد إتمام التثبيت، يتم إغلاق المعالج نهائياً ويقوم بتحويل أي طلب لصفحة التثبيت إلى خطأ 404 Not Found لحماية التطبيق.
 * **دعم كامل للغة العربية:** واجهات مستخدم مخصصة تدعم الكتابة من اليمين إلى اليسار (RTL) بتصميم عصري وأنيق ومريح للعين.
 * **مرونة كاملة في التشغيل (CLI):** إمكانية التثبيت، التحديث، أو الحذف بالكامل عبر أوامر Artisan أو ملفات الدفعات الذكية .bat.
## 📋 المتطلبات التقنية للنظام
قبل البدء في استخدام الحزمة، يرجى التأكد من مطابقة بيئة خادم الاستضافة للمواصفات التالية:

| المتطلب التقني / الإضافة | الحد الأدنى المطلوب |
| :--- | :--- |
| **إصدار PHP** | 8.2 أو أحدث |
| **إطار عمل Laravel** | 10.x / 11.x / 12.x / 13.x |
| **إضافات PHP الأساسية** | openssl, pdo, pdo_mysql, mbstring, tokenizer, xml, ctype, json, bcmath, curl, fileinfo |
| **صلاحيات المجلدات** | يجب أن تكون المجلدات التالية قابلة للكتابة والقراءة: <br> storage/ <br> bootstrap/cache/ |

## ⚙️ طرق تثبيت الحزمة
يمكنك دمج حزمة التثبيت الذكية في مشروعك الخاص بـ Laravel بطريقتين:
### الطريقة الأولى: التثبيت التلقائي عبر ملف install.bat (لنظام Windows)
 1. قم بنسخ مجلد الحزمة بالكامل المسمى packages/smart-installer وضعه داخل جذر مشروعك (Root Project).
 2. افتح مجلد packages وقم بتشغيل ملف install.bat عن طريق النقر المزدوج عليه.
 3. سيقوم الملف بتنفيذ كافة الإجراءات تلقائياً:
   * إضافة مستودع محلي (Local Repository) في ملف composer.json.
   * تثبيت الحزمة عبر الملحن كاعتمادية محليّة @dev.
   * نشر ملفات الإعدادات والواجهات (Config & Views).
   * مسح التخزين المؤقت وإعادة بناءه.
 4. بمجرد الانتهاء، افتح متصفحك وتوجه إلى الرابط التالي لبدء التثبيت:
   👉 http://127.0.0.1:8000/install
### الطريقة الثانية: التثبيت اليدوي (لكافة الأنظمة)
إذا كنت تستخدم نظام تشغيل آخر مثل **Linux** أو **macOS**، أو تفضل العمل عبر سطر الأوامر يدوياً، اتبع الخطوات البرمجية التالية:
```bash
# 1. إضافة مسار المجلد المحلي للحزمة إلى composer.json
composer config repositories.smart-installer path "packages/smart-installer"
# 2. تثبيت الحزمة كاعتمادية تطوير محلية
composer require app/installer:@dev
# 3. نشر ملفات الإعدادات والواجهات البرمجية للمشروع
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force
# 4. تشغيل خادم التطبيق المحلي لارافيل
php artisan serve
# الآن توجه إلى المتصفح عبر الرابط: [http://127.0.0.1:8000/install](http://127.0.0.1:8000/install)
```
## 📝 تهيئة ملف البيئة (.env.example)
لكي يقرأ معالج التثبيت بيانات مشروعك الخاص ويقوم بعرضها للمستخدم بشكل مخصص، يرجى إضافة الأسطر التالية إلى نهاية ملف .env.example الخاص بمشروعك الأساسي:
```env
PRODUCT_NAME="تطبيق المبيعات الذكي"
PRODUCT_VERSION=1.0.0
PRODUCT_DESCRIPTION="نظام متكامل لإدارة المبيعات والمخازن مبني على إطار عمل لارافيل."
PRODUCT_SUPPORT_URL="[https://support.example.com](https://support.example.com)"
SESSION_DRIVER=file
```
> **⚠️ تنبيه أمني هام:** تأكد تماماً من عدم تضمين أو رفع ملفك النشط .env إلى مستودعات Git (مثل GitHub/GitLab). حيث يقوم معالج التثبيت بإنشاء هذا الملف بشكل ديناميكي وآمن كلياً أثناء عملية التثبيت.
> 
## 🌐 معالج التثبيت عبر الويب (Web Wizard)
عند فتح الرابط http://127.0.0.1:8000/install في المتصفح، سيمر العميل بـ 5 خطوات متتالية ومنظمة للغاية:
```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐     ┌─────────────┐  
│  Welcome    │  ➔  │ Requirements│  ➔  │  Database   │  ➔  │   Install   │  ➔  │  Complete   │  
└─────────────┘     └─────────────┘     └─────────────┘     └─────────────┘     └─────────────┘
```
### خطوات التثبيت بالتفصيل:
#### 🏁 الخطوة الأولى: الترحيب والمعلومات العامة (Welcome)
 * عرض شعار مشروعك، اسم التطبيق، والوصف البرمجي له من واقع إعدادات البيئة.
 * التحقق من تفاصيل الخادم الحالي وإصدار الـ PHP النشط.
#### 🔍 الخطوة الثانية: فحص المتطلبات (Requirements)
 * يقوم النظام بفحص فوري وصامت للتأكد من تفعيل كافة إضافات PHP الإلزامية لتشغيل Laravel.
 * التحقق من صلاحيات الكتابة (Write Permissions) على مجلدات الـ storage والـ bootstrap/cache. في حال وجود خلل، سيعرض النظام دليلاً سريعاً لحل مشكلة الصلاحيات للمستخدم.
#### 🗄️ الخطوة الثالثة: إعداد قاعدة البيانات (Database Setup)
 * حقول إدخال مخصصة لبيانات الاتصال (اسم المضيف، المنفذ، اسم قاعدة البيانات، اسم المستخدم، وكلمة المرور).
 * ميزة **"اختبار الاتصال السريع"** للتحقق من صحة المدخلات دون مغادرة الصفحة أو حدوث خطأ برمجي مزعج.
 * توليد مفتاح التطبيق APP_KEY تلقائياً لتأمين البيانات وحمايتها.
 * كتابة وحفظ المتغيرات فوراً في ملف .env الجديد.
#### ⚙️ الخطوة الرابعة: بدء التنفيذ والتشغيل (Install)
يتم تنفيذ الأوامر التالية بشكل متتابع وتفاعلي مع إظهار شريط تقدم (Progress Bar) حي للمستخدم:

| الأمر البرمجي المنفذ | وصف وتأثير العملية |
| :--- | :--- |
| composer install --no-dev --optimize-autoloader | تنزيل المكتبات والاعتماديات الخاصة بالإنتاج |
| composer dump-autoload --optimize | تسريع وتحسين ملفات التوجيه والتحميل التلقائي |
| php artisan migrate --force | بناء جداول قاعدة البيانات بالكامل |
| php artisan db:seed --force | إدراج البيانات الأولية والحسابات الافتراضية للوحة التحكم |
| php artisan storage:link | إنشاء الاختصار الرمزي لملفات الميديا والمرفقات |
| php artisan optimize:clear | مسح كافة ملفات الكاش القديمة والمهملة |
| php artisan config:cache | تخزين الإعدادات مؤقتاً لتسريع الاستجابة |
| php artisan route:cache | تشفير وتخزين مسارات التوجيه لرفع الكفاءة |
| php artisan view:cache | المعالجة المسبقة لملفات واجهات Blade |
| **Write Lock File** | كتابة ملف الحماية وقفل معالج التثبيت للأبد |

> **💡 ملاحظة:** في حال تعثر أي خطوة (كخطأ في قواعد البيانات مثلاً)، سيظهر صندوق توضيحي باللون الأحمر يحتوي على تفاصيل المشكلة بالتحديد مع زر لإعادة المحاولة (Retry) بعد إصلاح الخطأ.
> 
#### 🎉 الخطوة الخامسة: إتمام التثبيت (Complete)
 * يتم قفل مسارات التثبيت فوراً وإلى الأبد من خلال محرك التثبيت الآمن.
 * تحويل التلقائي للمستخدم نحو الصفحة الرئيسية للتطبيق أو لوحة التحكم لبدء العمل الفعلي.
## 💻 أوامر Artisan وسطر الأوامر
للمطورين الذين يفضلون إجراء عمليات التثبيت السريعة عبر الـ Terminal، توفر الحزمة مجموعة من الأوامر القوية والمميزة:
### التثبيت الكامل عبر سطر الأوامر:
```bash
php artisan installer:run
```
#### الخيارات الإضافية المتوفرة للأمر:
```bash
# تثبيت التطبيق وتخطي مرحلة Composer (في حال كانت المكتبات مثبتة مسبقاً)
php artisan installer:run --skip-composer
# تشغيل المهاجرات وبناء النظام مع تخطي بذر البيانات الأولية (Seeding)
php artisan installer:run --skip-seed
# فرض التثبيت وإعادة تهيئة بيئة العمل حتى لو كان التطبيق مثبتاً بالفعل ومقفل
php artisan installer:run --force
```
### إعادة تهيئة وتصفير معالج التثبيت:
إذا كنت ترغب في فك القفل عن المعالج واختباره من جديد:
```bash
# إزالة ملف القفل لتفعيل واجهة التثبيت مجدداً
php artisan installer:reset
# إزالة القفل وتصفير البيانات بشكل مباشر دون طلب تأكيد تأكيدي (No Interaction)
php artisan installer:reset --force
```
### نشر الملفات يدوياً:
```bash
php artisan vendorPrefix:setup
# أو بشكل تفصيلي من خلال أوامر لارافيل القياسية:
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force
```
## 🛡️ ميزات الأمان والحماية
توفر الحزمة أعلى معايير الحماية لضمان عدم استغلال واجهة التثبيت بعد رفع المشروع للإنتاج:
 1. **🔒 سياسة الإغلاق الفوري (Zero-Leak Policy):** بمجرد كتابة ملف القفل بنجاح، لن يتمكن أي شخص من الوصول لواجهات التثبيت، وسيتم توليد استجابة 404 Not Found تلقائياً لكل الطلبات الموجهة للرابط /install.
 2. **🔑 التشفير التلقائي للأمان:** في حال عدم توفر مفتاح أمان للمشروع، تولد الحزمة قيمة تشفير مشفرة وقوية لـ APP_KEY وتدمجها بالملف لضمان تشفير بيانات الجلسات وكلمات المرور للمستخدمين.
 3. **📁 إدارة الجلسات الآمنة:** يتم فرض قيمة SESSION_DRIVER=file طوال فترة التثبيت للتغلب على مشكلة "عدم وجود جدول الجلسات في قاعدة البيانات" قبل هجرة الجداول للاتصال.
### ملفات يجب إضافتها لـ .gitignore
لمنع تداخل ملفات القفل الخاصة ببيئات التطوير مع الخوادم الحية للإنتاج، يرجى إدراج الأسطر التالية في ملف الـ .gitignore بمشروعك:
```text
storage/app/installed.lock
storage/app/install_progress.json
bootstrap/cache/installed.php
```
## 🔌 فحص حالة التثبيت برمجياً في أكوادك
يمكنك استخدام المكونات البرمجية للحزمة للتحقق من وضع التثبيت الحالي داخل شيفراتك البرمجية (على سبيل المثال لمنع تشغيل أجزاء معينة أو تطبيق جدار حماية مخصص):
```php
use Smart\Installer\Providers\InstallerServiceProvider;  
use Smart\Installer\Install\LockFile;  
// هل تم تثبيت التطبيق بنجاح ومقفل حالياً؟
$isInstalled = InstallerServiceProvider::isInstalled(); // تعيد true أو false
// قراءة بيانات التثبيت المحفوظة داخل ملف القفل
$lockData = LockFile::read();  
/*
تعيد مصفوفة تحتوي على:
[
  'domain' => 'example.com',
  'installed_at' => '2026-06-27 03:29:00',
  'php_version' => '8.3.1',
  'product_version' => '1.0.0'
]
*/
```
## 🔄 تحديث وترقية الحزمة
عند إصدار تحديثات جديدة للحزمة من المطورين، يمكنك الترقية بمرونة كاملة:
### الطريقة الأولى: عبر استخدام سكربت الترقية السريعة (Windows)
```bash
packages/update.bat
```
### الطريقة الثانية: التحديث اليدوي لكافة الأنظمة
```bash
# 1. تحديث الحزمة والاعتماديات التابعة لها عبر Composer
composer update app/installer --with-all-dependencies
# 2. إعادة نشر وتحديث ملفات التصاميم والواجهات والإعدادات وتجاوز القديمة
php artisan vendor:publish --tag=installer-config --force
php artisan vendor:publish --tag=installer-views --force
# 3. تصفير وإعادة تهيئة الـ Cache
php artisan optimize:clear
```
## ❌ إلغاء التثبيت والحذف الكامل
> **⚠️ تحذير شديد:** عملية إلغاء التثبيت ستقوم بإزالة الحزمة تماماً، وحذف كافة الإعدادات والملفات المنشورة بشكل نهائي وبلا رجعة.
> 
### الطريقة الأولى: الإزالة السريعة (Windows)
قم بتشغيل ملف السكربت packages/uninstall.bat واكتب كلمة YES عند مطالبتك بالتأكيد لإتمام العملية تلقائياً وبأمان.
### الطريقة الثانية: الإزالة اليدوية خطوة بخطوة (Linux / macOS)
```bash
# 1. إزالة الحزمة والاعتمادية البرمجية عبر الملحن
composer remove app/installer
# 2. إزالة المستودع المحلي الخاص بالحزمة من ملف composer.json
composer config --unset repositories.smart-installer
# 3. حذف ملفات الإعدادات والواجهات البرمجية المنشورة سابقاً
rm -f config/installer.php
rm -rf resources/views/vendor/installer
# 4. إزالة كافة ملفات القفل وملفات التقدم للتثبيت من الخادم
rm -f storage/app/installed.lock
rm -f storage/app/install_progress.json
rm -f storage/installed
rm -f bootstrap/cache/installed.php
# 5. تنظيف ملفات الكاش وتحديث التحميل التلقائي
php artisan optimize:clear
composer dump-autoload -o
```
## 📂 بنية وتفصيل مجلدات الحزمة
تأتي الحزمة مجهزة ببنية برمجية معيارية تتبع أفضل ممارسات وهيكلة حزم لارافيل (Laravel Package Development):
```text
packages/  
├── smart-installer/           ← المجلد الأساسي للحزمة البرمجية  
│   ├── config/  
│   │   └── installer.php      ← ملف إعدادات وثوابت التثبيت وسلوك الحزمة  
│   ├── resources/  
│   │   └── views/             ← ملفات العرض والواجهات (Blade Views) المترجمة  
│   ├── routes/  
│   │   └── installer.php      ← مسارات التوجيه الآمنة للويب  
│   ├── src/  
│   │   ├── Console/Commands/  ← أوامر سطر الأوامر (Artisan CLI)  
│   │   ├── Http/Controllers/  ← المتحكمات لمعالجة خطوات التثبيت  
│   │   ├── Http/Middleware/   ← برمجيات وسيطة لفحص الأقفال والحماية  
│   │   ├── Install/           ← معالج القراءة والكتابة لملفات القفل (LockFile)  
│   │   ├── Providers/         ← الموفر الرئيسي للخدمة ومسجل الحزمة  
│   │   └── Services/          ← منطق وأكواد عمليات التثبيت والخلفية البرمجية  
│   ├── stubs/  
│   │   └── env.example.stub   ← القالب الجاهز لملفات الـ البيئة الافتراضية  
│   └── composer.json          ← ملف تعريف الحزمة واعتمادياتها البرمجية  
│  
├── install.bat                ← أداة التثبيت السريعة بنقرة واحدة لـ Windows  
├── update.bat                 ← أداة التحديث السريعة بنقرة واحدة لـ Windows  
└── uninstall.bat              ← أداة الإزالة السريعة بنقرة واحدة لـ Windows  
```
## ❓ الأسئلة الشائعة وحل المشكلات (Troubleshooting)
#### س: تظهر لي صفحة خطأ 404 عند محاولة فتح الرابط /install لأول مرة، ما المشكلة؟
 * **ج:** تأكد من عدم وجود ملف باسم installed.lock داخل المجلد storage/app/ أو ملف installed.php في مجلد bootstrap/cache/. إذا كانت هذه الملفات موجودة، فإن النظام يعتبر التطبيق مثبتاً بالفعل ويمنع الدخول؛ قم بحذفها يدوياً أو شغل الأمر php artisan installer:reset لإعادة تفعيل المعالج.
#### س: يظهر لي خطأ متعلق بصلاحيات الملفات (Permissions Error) أثناء التثبيت، كيف يمكنني حله؟
 * **ج:** يحتاج لارافيل إلى صلاحيات الكتابة لبعض المجلدات الحيوية. قم بتنفيذ الأوامر التالية عبر منفذ الأوامر لمنح الصلاحيات المناسبة (على نظام Linux/macOS):
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```
#### س: أثناء إدخال بيانات قاعدة البيانات يظهر لي فشل الاتصال، على الرغم من أن البيانات صحيحة؟
 * **ج:** تأكد من أن خادم قواعد البيانات (MySQL/MariaDB) يعمل بالفعل على خادم الاستضافة الخاص بك، وتأكد من كتابة اسم المضيف بدقة (استخدم 127.0.0.1 عوضاً عن localhost في بعض البيئات للتغلب على مشاكل توافق الـ Sockets).
## 📄 الترخيص والمساهمة
هذه الحزمة مفتوحة المصدر ومتاحة للاستخدام والتطوير الحر تحت شروط ترخيص **MIT License**. يمكنك استخدامها وتعديلها بحرية تامة في مشاريعك التجارية والشخصية على حد سواء دون أي قيود.
<p align="center">
إذا واجهتك أي عقبة برمجية أو رغبت في الإبلاغ عن مشكلة، يرجى فتح <strong>Issue</strong> جديد على المستودع وسنقوم بمساعدتك على الفور!
</p></p>
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
