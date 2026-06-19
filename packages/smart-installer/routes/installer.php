<?php

use Illuminate\Support\Facades\Route;
use Smart\Installer\Http\Controllers\DatabaseController;
use Smart\Installer\Http\Controllers\InstallController;
use Smart\Installer\Http\Controllers\InstallerController;
use Smart\Installer\Http\Controllers\RequirementsController;

/*
|--------------------------------------------------------------------------
| Installer Routes
|--------------------------------------------------------------------------
|
| Wizard flow: Welcome → Requirements → Database → Install → Complete
| Pure local setup.
|
| IMPORTANT: /install/complete is registered OUTSIDE the installer.check
| group, because installer.check returns 404 once the app is installed —
| which would otherwise also block the success page right after install.
|
*/

Route::get('/install/complete', [InstallerController::class, 'complete'])
     ->middleware(['web'])
     ->name('installer.complete');

Route::group([
    'prefix'     => 'install',
    'as'         => 'installer.',
    'middleware' => ['web', 'installer.check'],
], function () {

    // Step 1 — Welcome
    Route::get('/', [InstallerController::class, 'welcome'])->name('welcome');

    // Step 2 — Requirements
    Route::get('/requirements',        [RequirementsController::class, 'index'])->name('requirements');
    Route::post('/requirements/check', [RequirementsController::class, 'check'])->name('requirements.check');

    // Step 3 — Database
    Route::get('/database',       [DatabaseController::class, 'index'])->name('database');
    Route::post('/database/test', [DatabaseController::class, 'testConnection'])->name('database.test');
    Route::post('/database/save', [DatabaseController::class, 'save'])->name('database.save');

    // Step 4 — Installation execution (migrate, seed, cache)
    Route::get('/run',          [InstallController::class, 'index'])->name('install');
    Route::post('/run/init',    [InstallController::class, 'init'])->name('install.init');
    Route::post('/run/step',    [InstallController::class, 'runStep'])->name('install.step');
    Route::get('/run/progress', [InstallController::class, 'progress'])->name('install.progress');

    // Locale switcher
    Route::post('/locale/{locale}', [InstallerController::class, 'setLocale'])->name('locale');
});
