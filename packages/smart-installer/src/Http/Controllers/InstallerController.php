<?php

namespace Smart\Installer\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Smart\Installer\Install\LockFile;
use Smart\Installer\Services\RequirementsService;

class InstallerController extends Controller
{
    public function welcome(RequirementsService $requirements)
    {
        return view('installer::steps.welcome', [
            'product'     => config('installer.product'),
            'server'      => $requirements->getServerInfo(),
            'steps'       => config('installer.wizard_steps'),
            'currentStep' => 1,
        ]);
    }

    /**
     * Step 5 — Complete page.
     *
     * Registered OUTSIDE the installer.check middleware group, so it
     * works right after installation (when the lock file was just created)
     * without being blocked by the "already installed → 404" rule.
     */
    public function complete()
    {
        if (!LockFile::exists()) {
            return redirect()->route('installer.welcome');
        }

        return view('installer::steps.complete', [
            'product'     => config('installer.product'),
            'lock'        => LockFile::read(),
            'steps'       => config('installer.wizard_steps'),
            'currentStep' => 5,
        ]);
    }

    public function setLocale(Request $request, string $locale)
    {
        $supported = config('installer.supported_locales', ['en', 'ar']);

        if (in_array($locale, $supported)) {
            session(['installer_locale' => $locale]);
            app()->setLocale($locale);
        }

        return back();
    }
}
