<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Product Information
    |--------------------------------------------------------------------------
    | Shown in the installer welcome page.
    */
    'product' => [
        'name'        => env('PRODUCT_NAME', 'My Application'),
        'version'     => env('PRODUCT_VERSION', '1.0.0'),
        'description' => env('PRODUCT_DESCRIPTION', 'A Laravel application.'),
        'logo'        => null,
        'support_url' => env('PRODUCT_SUPPORT_URL', null),
    ],

    /*
    |--------------------------------------------------------------------------
    | PHP Requirements
    |--------------------------------------------------------------------------
    */
    'requirements' => [
        'min_php_version' => '8.2.0',

        'extensions' => [
            'openssl', 'pdo', 'pdo_mysql', 'mbstring',
            'tokenizer', 'xml', 'ctype', 'json',
            'bcmath', 'curl', 'fileinfo',
        ],

        // Folders that must be writable by the web server
        'writable_paths' => [
            'storage',
            'storage/app',
            'storage/framework',
            'storage/framework/cache',
            'storage/framework/sessions',
            'storage/framework/views',
            'storage/logs',
            'bootstrap/cache',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Installation Commands (run in order during Step 3)
    |--------------------------------------------------------------------------
    | Each step has a label used in the UI, and is executed by InstallationService.
    */
    'steps' => [
        'composer_install' => 'Installing dependencies',
        'composer_dump'    => 'Optimizing autoloader',
        'migrate'          => 'Running database migrations',
        'seed'             => 'Seeding initial data',
        'storage_link'     => 'Linking storage',
        'optimize_clear'   => 'Clearing old cache',
        'config_cache'     => 'Caching configuration',
        'route_cache'      => 'Caching routes',
        'view_cache'       => 'Caching views',
        'lock'             => 'Finalizing installation',
    ],

    /*
    |--------------------------------------------------------------------------
    | Composer Runtime
    |--------------------------------------------------------------------------
    | Web installers usually run after `composer require`, so vendor/autoload.php
    | already exists. In that case Composer is skipped to avoid web-server shell
    | permission, timeout, memory, and Windows PATH issues.
    */
    'composer' => [
        'skip_if_vendor_exists' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Step Labels (wizard page indicator)
    |--------------------------------------------------------------------------
    */
    'wizard_steps' => [
        1 => 'Welcome',
        2 => 'Requirements',
        3 => 'Database',
        4 => 'Install',
        5 => 'Complete',
    ],

    /*
    |--------------------------------------------------------------------------
    | Lock File Paths
    |--------------------------------------------------------------------------
    */
    'lock_file' => [
        'primary'   => 'storage/app/installed.lock',
        'secondary' => 'bootstrap/cache/installed.php',
    ],

    'supported_locales' => ['en', 'ar'],
];
