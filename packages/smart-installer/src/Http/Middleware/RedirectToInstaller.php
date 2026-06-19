<?php

namespace Smart\Installer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Smart\Installer\Providers\InstallerServiceProvider;

/**
 * RedirectToInstaller
 *
 * 1. Redirects any non-installer route to /install when not yet installed.
 * 2. Forces SESSION_DRIVER=file during install so Laravel never tries to
 *    query the `sessions` table before migrations have run.
 */
class RedirectToInstaller
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (InstallerServiceProvider::isInstalled()) {
            return $next($request);
        }

        // Force file sessions while not yet installed (fixes SQLSTATE[42S02])
        if (config('session.driver') !== 'file') {
            Config::set('session.driver', 'file');
        }

        // Allow installer routes through
        if ($request->is('install') || $request->is('install/*')) {
            return $next($request);
        }

        // Skip framework/dev tooling routes
        if ($request->is('api/*', 'telescope*', 'horizon*', 'livewire*', '_debugbar/*')) {
            return $next($request);
        }

        return redirect('/install');
    }
}
