<?php

namespace Smart\Installer\Console\Commands;

use Illuminate\Console\Command;
use Smart\Installer\Install\LockFile;
use Smart\Installer\Services\InstallationService;

/**
 * php artisan installer:reset
 *
 * Removes the installation lock file so the installer can run again.
 * DANGER: Only use this in development or after explicit customer request.
 */
class InstallResetCommand extends Command
{
    protected $signature   = 'installer:reset {--force : Skip confirmation prompt}';
    protected $description = 'Remove the installation lock file (re-enables the installer wizard)';

    public function handle(InstallationService $installer): int
    {
        if (!LockFile::exists()) {
            $this->warn('No lock file found — application does not appear to be installed.');
            return self::SUCCESS;
        }

        $lock = LockFile::read();

        $this->warn('⚠  This will remove the installation lock and re-enable the /install route.');
        $this->table(['Field', 'Value'], [
            ['Domain',       $lock['domain']       ?? 'unknown'],
            ['Installed At', $lock['installed_at'] ?? 'unknown'],
        ]);

        if (!$this->option('force') && !$this->confirm('Are you sure you want to reset the installation?')) {
            $this->info('Aborted.');
            return self::SUCCESS;
        }

        LockFile::delete();
        $installer->resetProgress();

        $this->info('✓ Lock file removed. Installer is active again at /install.');

        return self::SUCCESS;
    }
}
