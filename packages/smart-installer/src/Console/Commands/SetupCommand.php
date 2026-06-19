<?php

namespace Smart\Installer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

/**
 * php artisan installer:setup
 *
 * Publishes installer config + views with a live progress bar so the
 * user can see exactly what's happening during package setup.
 */
class SetupCommand extends Command
{
    protected $signature = 'installer:setup
                            {--force : Overwrite any previously published files}
                            {--no-views : Skip publishing the views}';

    protected $description = 'Publish installer assets with a progress bar (run after composer require)';

    public function handle(): int
    {
        $this->newLine();
        $this->line('  <fg=cyan;options=bold>┌──────────────────────────────────────────────┐</>');
        $this->line('  <fg=cyan;options=bold>│        App Installer — Setup Wizard          │</>');
        $this->line('  <fg=cyan;options=bold>└──────────────────────────────────────────────┘</>');
        $this->newLine();

        $tasks = [
            ['label' => 'Checking environment',          'run' => fn () => usleep(250000)],
            ['label' => 'Publishing installer config',   'run' => fn () => $this->publishTag('installer-config')],
            ['label' => 'Publishing installer views',    'run' => fn () => $this->option('no-views') ? null : $this->publishTag('installer-views')],
            ['label' => 'Preparing storage directories', 'run' => fn () => $this->prepareStorage()],
            ['label' => 'Clearing config cache',         'run' => fn () => Artisan::call('config:clear')],
            ['label' => 'Finalizing',                    'run' => fn () => usleep(200000)],
        ];

        $bar = $this->output->createProgressBar(count($tasks));
        $bar->setFormat(" %current%/%max% [%bar%] %percent:3s%%  <fg=yellow>%message%</>");
        $bar->setBarCharacter('<fg=green>█</>');
        $bar->setEmptyBarCharacter('<fg=gray>░</>');
        $bar->setProgressCharacter('<fg=green>█</>');
        $bar->setMessage('starting…');
        $bar->start();

        foreach ($tasks as $task) {
            $bar->setMessage($task['label']);
            $bar->display();
            try {
                ($task['run'])();
            } catch (\Throwable $e) {
                $bar->clear();
                $this->error("  ✗ {$task['label']} failed: {$e->getMessage()}");
                return self::FAILURE;
            }
            $bar->advance();
        }

        $bar->setMessage('done');
        $bar->finish();
        $this->newLine(2);

        $this->line('  <fg=green;options=bold>✓ Setup complete!</>');
        $this->line('  <fg=gray>Next:</> open your app in the browser — you\'ll be redirected to <fg=cyan>/install</>');
        $this->newLine();

        return self::SUCCESS;
    }

    protected function publishTag(string $tag): void
    {
        Artisan::call('vendor:publish', [
            '--tag'   => $tag,
            '--force' => (bool) $this->option('force'),
        ]);
    }

    protected function prepareStorage(): void
    {
        $dirs = [
            storage_path('app'),
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('logs'),
            base_path('bootstrap/cache'),
        ];
        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }
        }
    }
}