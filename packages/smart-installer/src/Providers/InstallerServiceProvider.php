<?php

namespace Smart\Installer\Providers;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Smart\Installer\Console\Commands\InstallCommand;
use Smart\Installer\Console\Commands\InstallResetCommand;
use Smart\Installer\Console\Commands\SetupCommand;
use Smart\Installer\Http\Middleware\CheckInstalled;
use Smart\Installer\Http\Middleware\RedirectToInstaller;
use Smart\Installer\Services\DatabaseService;
use Smart\Installer\Services\EnvironmentService;
use Smart\Installer\Services\InstallationService;
use Smart\Installer\Services\RequirementsService;

class InstallerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/installer.php', 'installer');

        $this->app->singleton(EnvironmentService::class);
        $this->app->singleton(DatabaseService::class);
        $this->app->singleton(RequirementsService::class);
        $this->app->singleton(InstallationService::class);

        // Force file sessions while not yet installed — avoids
        // SQLSTATE[42S02] "sessions table not found" before migrations run.
        if (!self::isInstalled()) {
            Config::set('session.driver', 'file');
        }
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'installer');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/installer.php');

        $this->registerMiddleware();
        $this->registerPublishables();
        $this->registerCommands();
        $this->bootInstallState();
    }

    protected function registerMiddleware(): void
    {
        /** @var Router $router */
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('installer.check', CheckInstalled::class);

        /** @var Kernel $kernel */
        $kernel = $this->app->make(Kernel::class);
        $kernel->appendMiddlewareToGroup('web', RedirectToInstaller::class);
    }

    protected function registerPublishables(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../../config/installer.php' => config_path('installer.php'),
        ], 'installer-config');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/installer'),
        ], 'installer-views');
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                InstallResetCommand::class,
                SetupCommand::class,
            ]);
        }
    }

    protected function bootInstallState(): void
    {
        $this->app->booted(function () {
            if (!self::isInstalled()) {
                return;
            }

            // App installed → block all /install/* route names with 404
            Route::matched(function (\Illuminate\Routing\Events\RouteMatched $event) {
                $name = $event->route->getName() ?? '';
                if (str_starts_with($name, 'installer.') && $name !== 'installer.complete') {
                    abort(404);
                }
            });
        });
    }

    public static function isInstalled(): bool
    {
        return file_exists(storage_path('app/installed.lock'))
            || file_exists(base_path('bootstrap/cache/installed.php'));
    }
}
