<?php

namespace Smart\Installer\Services;

use Illuminate\Support\Facades\Artisan;
use Smart\Installer\Install\LockFile;
use Throwable;

/**
 * InstallationService
 *
 * Runs the installation pipeline:
 *   composer install → composer dump-autoload → migrate → seed →
 *   storage:link → optimize:clear → config:cache → route:cache →
 *   view:cache → write lock file
 */
class InstallationService
{
    protected string $progressFile;

    public function __construct()
    {
        $this->progressFile = storage_path('app/install_progress.json');
    }

    public function getSteps(): array
    {
        return config('installer.steps', []);
    }

    public function initProgress(): void
    {
        $this->saveProgress([
            'started_at' => now()->toIso8601String(),
            'completed'  => [],
            'current'    => null,
        ]);
    }

    public function getProgress(): array
    {
        if (!file_exists($this->progressFile)) {
            return ['completed' => [], 'current' => null];
        }

        return json_decode(file_get_contents($this->progressFile), true) ?? [];
    }

    protected function saveProgress(array $data): void
    {
        $dir = dirname($this->progressFile);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        file_put_contents($this->progressFile, json_encode($data));
    }

    protected function markStepComplete(string $step): void
    {
        $progress = $this->getProgress();
        $progress['completed'][] = $step;
        $progress['completed']   = array_unique($progress['completed']);
        $progress['current']     = $step;
        $this->saveProgress($progress);
    }

    /**
     * Run a single installation step.
     * Returns ['success' => bool, 'message' => string, 'output' => string, 'fatal' => bool]
     */
    public function runStep(string $step): array
    {
        try {
            $result = match ($step) {
                'composer_install' => $this->runComposerInstall(),
                'composer_dump'    => $this->runComposerDump(),
                'migrate'          => $this->runMigrate(),
                'seed'             => $this->runSeed(),
                'storage_link'     => $this->runStorageLink(),
                'optimize_clear'   => $this->runOptimizeClear(),
                'config_cache'     => $this->runConfigCache(),
                'route_cache'      => $this->runRouteCache(),
                'view_cache'       => $this->runViewCache(),
                'lock'             => $this->writeLock(),
                default            => ['success' => false, 'message' => "Unknown step: {$step}", 'fatal' => true],
            };

            if ($result['success']) {
                $this->markStepComplete($step);
            }

            return array_merge(['output' => '', 'fatal' => true], $result);

        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'output'  => '',
                'fatal'   => true,
            ];
        }
    }

    // ── Steps ────────────────────────────────────────────────────

    protected function runComposerInstall(): array
    {
        if (config('installer.composer.skip_if_vendor_exists', true) && file_exists(base_path('vendor/autoload.php'))) {
            return [
                'success' => true,
                'message' => 'Dependencies already installed, skipping Composer install.',
                'output'  => 'vendor/autoload.php exists.',
            ];
        }

        $composer = $this->findComposer();
        if (!$composer) {
            return [
                'success' => false,
                'message' => 'Composer was not found and vendor/autoload.php is missing. Run composer install manually, then retry the installer.',
                'output'  => '',
            ];
        }

        $process = $this->runProcess(array_merge($composer, ['install', '--no-dev', '--optimize-autoloader', '--no-interaction']));
        $cleanOutput = trim($process['output']);

        return [
            'success' => $process['exitCode'] === 0,
            'message' => $process['exitCode'] === 0
                ? 'Dependencies installed.'
                : 'Composer install failed.' . ($cleanOutput ? "\n\n" . $cleanOutput : ''),
            'output'  => $cleanOutput,
        ];
    }

    protected function runComposerDump(): array
    {
        if (config('installer.composer.skip_if_vendor_exists', true) && file_exists(base_path('vendor/autoload.php'))) {
            return [
                'success' => true,
                'message' => 'Autoloader already available, skipping Composer dump-autoload.',
                'output'  => 'vendor/autoload.php exists.',
            ];
        }

        $composer = $this->findComposer();
        if (!$composer) {
            return [
                'success' => false,
                'message' => 'Composer was not found and vendor/autoload.php is missing. Run composer dump-autoload manually, then retry the installer.',
                'output'  => '',
            ];
        }

        $process = $this->runProcess(array_merge($composer, ['dump-autoload', '--optimize']));

        return [
            'success' => $process['exitCode'] === 0,
            'message' => $process['exitCode'] === 0 ? 'Autoloader optimized.' : 'Composer dump-autoload failed.',
            'output'  => trim($process['output']),
        ];
    }

    protected function runMigrate(): array
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();

            return [
                'success' => true,
                'message' => 'Database migrated successfully.',
                'output'  => $output,
            ];
        } catch (Throwable $e) {
            return [
                'success' => false,
                'message' => 'Migration failed: ' . $e->getMessage(),
                'output'  => '',
            ];
        }
    }

    protected function runSeed(): array
    {
        try {
            Artisan::call('db:seed', ['--force' => true]);
            $output = Artisan::output();

            return [
                'success' => true,
                'message' => 'Database seeded successfully.',
                'output'  => $output,
            ];
        } catch (Throwable $e) {
            // Seeding failure should not block installation (non-fatal)
            return [
                'success' => true,
                'message' => 'Seeding skipped: ' . $e->getMessage(),
                'output'  => '',
            ];
        }
    }

    protected function runStorageLink(): array
    {
        try {
            // Idempotent — skip if link already exists
            if (!file_exists(public_path('storage'))) {
                Artisan::call('storage:link');
            }

            return ['success' => true, 'message' => 'Storage linked.', 'output' => Artisan::output()];
        } catch (Throwable $e) {
            // Non-fatal — not every app needs storage:link
            return ['success' => true, 'message' => 'Storage link skipped: ' . $e->getMessage(), 'output' => ''];
        }
    }

    protected function runOptimizeClear(): array
    {
        Artisan::call('optimize:clear');
        return ['success' => true, 'message' => 'Old cache cleared.', 'output' => Artisan::output()];
    }

    protected function runConfigCache(): array
    {
        try {
            Artisan::call('config:cache');
            return ['success' => true, 'message' => 'Configuration cached.', 'output' => Artisan::output()];
        } catch (Throwable $e) {
            // Non-fatal — app still works without config cache
            return ['success' => true, 'message' => 'Config cache skipped: ' . $e->getMessage(), 'output' => ''];
        }
    }

    protected function runRouteCache(): array
    {
        try {
            Artisan::call('route:cache');
            return ['success' => true, 'message' => 'Routes cached.', 'output' => Artisan::output()];
        } catch (Throwable $e) {
            return ['success' => true, 'message' => 'Route cache skipped: ' . $e->getMessage(), 'output' => ''];
        }
    }

    protected function runViewCache(): array
    {
        try {
            Artisan::call('view:cache');
            return ['success' => true, 'message' => 'Views cached.', 'output' => Artisan::output()];
        } catch (Throwable $e) {
            return ['success' => true, 'message' => 'View cache skipped: ' . $e->getMessage(), 'output' => ''];
        }
    }

    protected function writeLock(): array
    {
        $written = LockFile::write([
            'domain' => request()->getHost(),
        ]);

        // Clean up progress file now that we're done
        if (file_exists($this->progressFile)) {
            @unlink($this->progressFile);
        }

        return [
            'success' => $written,
            'message' => $written ? 'Installation complete.' : 'Failed to write lock file.',
            'output'  => '',
        ];
    }

    public function resetProgress(): void
    {
        if (file_exists($this->progressFile)) {
            @unlink($this->progressFile);
        }
    }

    // ── Helpers ──────────────────────────────────────────────────

    protected function findComposer(): ?array
    {
        // Common locations
        $candidates = ['composer', 'composer.phar'];

        foreach ($candidates as $bin) {
            $which = trim((string) shell_exec((PHP_OS_FAMILY === 'Windows' ? 'where ' : 'which ') . $bin . ' 2>&1'));
            if ($which && !str_contains(strtolower($which), 'not found') && file_exists(explode("\n", $which)[0] ?? '')) {
                return [$bin];
            }
        }

        // Local composer.phar in project root
        if (file_exists(base_path('composer.phar'))) {
            return ['php', base_path('composer.phar')];
        }

        return null;
    }

    protected function runProcess(array $command): array
    {
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $cmdString = implode(' ', array_map('escapeshellarg', $command));
        $process   = proc_open($cmdString, $descriptors, $pipes, base_path());

        if (!is_resource($process)) {
            return ['exitCode' => 1, 'output' => 'Failed to start process.'];
        }

        fclose($pipes[0]);
        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        $exitCode = proc_close($process);

        return [
            'exitCode' => $exitCode,
            'output'   => $stdout . "\n" . $stderr,
        ];
    }
}
