<?php

namespace Smart\Installer\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Smart\Installer\Services\DatabaseService;
use Smart\Installer\Services\EnvironmentService;

class DatabaseController extends Controller
{
    public function __construct(
        protected DatabaseService    $database,
        protected EnvironmentService $environment,
    ) {}

    public function index()
    {
        $this->environment->ensureEnvExists();

        return view('installer::steps.database', [
            'currentStep' => 3,
            'steps'       => config('installer.wizard_steps'),
            'product'     => config('installer.product'),
            'defaults' => [
                'host'     => $this->environment->get('DB_HOST', '127.0.0.1'),
                'port'     => $this->environment->get('DB_PORT', '3306'),
                'database' => $this->environment->get('DB_DATABASE', ''),
                'username' => $this->environment->get('DB_USERNAME', ''),
            ],
        ]);
    }

    public function testConnection(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'host'     => 'required|string|max:253',
            'port'     => 'required|integer|between:1,65535',
            'database' => 'required|string|max:64',
            'username' => 'required|string|max:64',
            'password' => 'nullable|string',
        ]);

        $result = $this->database->testConnection([
            'host'     => $validated['host'],
            'port'     => $validated['port'],
            'database' => $validated['database'],
            'username' => $validated['username'],
            'password' => $validated['password'] ?? '',
        ]);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    public function save(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'host'     => 'required|string|max:253',
            'port'     => 'required|integer|between:1,65535',
            'database' => 'required|string|max:64',
            'username' => 'required|string|max:64',
            'password' => 'nullable|string',
        ]);

        $config = [
            'host'     => $validated['host'],
            'port'     => $validated['port'],
            'database' => $validated['database'],
            'username' => $validated['username'],
            'password' => $validated['password'] ?? '',
        ];

        $test = $this->database->testConnection($config);
        if (!$test['success']) {
            return response()->json([
                'success' => false,
                'message' => $test['message'],
            ], 422);
        }

        $this->environment->ensureEnvExists();
        $this->database->saveConfiguration($config);

        if (empty(config('app.key')) || config('app.key') === 'base64:') {
            $this->database->generateAppKey();
        }

        // Keep sessions on file driver until installation fully completes
        $this->database->forceFileSession();

        return response()->json([
            'success'  => true,
            'message'  => 'Database configured successfully.',
            'redirect' => route('installer.install'),
        ]);
    }
}
