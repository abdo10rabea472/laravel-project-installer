<?php

namespace Smart\Installer\Console\Commands;

use Illuminate\Console\Command;
use Smart\Installer\Install\LockFile;
use Smart\Installer\Services\InstallationService;

/**
 * php artisan installer:run
 *
 * Runs the full installation pipeline from the CLI.
 * Useful for automated deployments, CI/CD pipelines, and Docker setups.
 */
class InstallCommand extends Command
{
    protected $signature = 'installer:run
                            {--skip-composer : Skip composer install/dump-autoload steps}
                            {--skip-seed     : Skip database seeding}
                            {--force         : Run even if already installed (re-runs all steps)}';

    protected $description = 'Run the full installation pipeline (migrate, seed, cache, lock)';

    public function handle(InstallationService $installer): int
    {
        if (LockFile::exists() && !$this->option('force')) {
            $this->warn('Application is already installed.');
            $this->line('Use --force to re-run anyway.');
            return self::SUCCESS;
        }

        $this->info('');
        $this->info(' Smart Installer — Running installation pipeline');
        $this->info(' ─────────────────────────────────────────────');
        $this->info('');

        $steps        = $installer->getSteps();
        $skipComposer = $this->option('skip-composer');
        $skipSeed     = $this->option('skip-seed');
        $failed       = false;

        foreach (array_keys($steps) as $step) {
            if ($skipComposer && in_array($step, ['composer_install', 'composer_dump'])) {
                $this->line(" <fg=yellow>SKIP</> {$steps[$step]}");
                continue;
            }
            if ($skipSeed && $step === 'seed') {
                $this->line(" <fg=yellow>SKIP</> {$steps[$step]}");
                continue;
            }

            $this->line(" <fg=cyan>RUN</>  {$steps[$step]}…");

            $start   = microtime(true);
            $result  = $installer->runStep($step);
            $elapsed = round((microtime(true) - $start), 1);

            if ($result['success']) {
                $this->line(" <fg=green>✓ DONE</> ({$elapsed}s)" . ($result['output'] ? " — " . $this->truncate($result['output']) : ''));
            } else {
                $this->error(" ✗ FAILED: {$result['message']}");
                $failed = true;
                break;
            }
        }

        $this->info('');

        if ($failed) {
            $this->error(' Installation failed. Fix the error above and re-run.');
            return self::FAILURE;
        }

        $lock = LockFile::read();
        $this->info(' ✅ Installation complete!');
        $this->line('');
        $this->table(['Key', 'Value'], [
            ['Domain',       $lock['domain']       ?? 'unknown'],
            ['Installed At', $lock['installed_at'] ?? 'unknown'],
            ['Lock File',    storage_path('app/installed.lock')],
        ]);

        return self::SUCCESS;
    }

    protected function truncate(string $text, int $len = 80): string
    {
        $text = preg_replace('/\s+/', ' ', trim($text));
        return strlen($text) > $len ? substr($text, 0, $len) . '…' : $text;
    }
}
