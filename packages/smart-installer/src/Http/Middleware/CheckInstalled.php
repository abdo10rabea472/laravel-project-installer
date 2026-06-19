<?php

namespace Smart\Installer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Smart\Installer\Providers\InstallerServiceProvider;

/**
 * CheckInstalled
 *
 * Applied to all /install/* routes EXCEPT /install/complete.
 * Returns 404 once the app is installed, permanently disabling the wizard.
 */
class CheckInstalled
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (InstallerServiceProvider::isInstalled()) {
            abort(404);
        }

        return $next($request);
    }
}
