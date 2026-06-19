<?php

namespace Smart\Installer\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Smart\Installer\Services\RequirementsService;

class RequirementsController extends Controller
{
    public function __construct(protected RequirementsService $requirements) {}

    public function index()
    {
        return view('installer::steps.requirements', [
            'currentStep' => 2,
            'steps'       => config('installer.wizard_steps'),
            'product'     => config('installer.product'),
            'results'     => $this->requirements->checkAll(),
            'allPassed'   => $this->requirements->allPassed(),
        ]);
    }

    public function check(): JsonResponse
    {
        return response()->json([
            'results'   => $this->requirements->checkAll(),
            'allPassed' => $this->requirements->allPassed(),
        ]);
    }
}
