<?php

namespace Smart\Installer\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Smart\Installer\Install\LockFile;
use Smart\Installer\Services\InstallationService;

class InstallController extends Controller
{
    public function __construct(protected InstallationService $installer) {}

    public function index()
    {
        // Already installed? Go straight to complete page.
        if (LockFile::exists()) {
            return redirect()->route('installer.complete');
        }

        // Must have database configured first
        if (empty(config('database.connections.mysql.database'))) {
            return redirect()->route('installer.database')
                ->with('error', 'Please configure the database first.');
        }

        return view('installer::steps.install', [
            'currentStep'  => 4,
            'steps'        => config('installer.wizard_steps'),
            'product'      => config('installer.product'),
            'installSteps' => $this->installer->getSteps(),
        ]);
    }

    public function init(Request $request): JsonResponse
    {
        $this->installer->initProgress();

        return response()->json([
            'steps'   => $this->installer->getSteps(),
            'message' => 'Ready to install.',
        ]);
    }

    public function runStep(Request $request): JsonResponse
    {
        $validSteps = implode(',', array_keys($this->installer->getSteps()));

        $request->validate([
            'step' => "required|string|in:{$validSteps}",
        ]);

        $step   = $request->input('step');
        $result = $this->installer->runStep($step);

        if ($step === 'lock' && $result['success']) {
            $result['redirect'] = route('installer.complete');
        }

        $status = ($result['success'] || !($result['fatal'] ?? true)) ? 200 : 422;

        return response()->json($result, $status);
    }

    public function progress(): JsonResponse
    {
        return response()->json([
            'progress' => $this->installer->getProgress(),
            'steps'    => $this->installer->getSteps(),
            'locked'   => LockFile::exists(),
        ]);
    }
}
