@extends('installer::layouts.app')
@section('title', 'Installation Complete')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass rounded-2xl p-8 text-center">
        <div class="w-16 h-16 rounded-2xl mx-auto mb-5 flex items-center justify-center"
             style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.4);">
            <svg class="w-8 h-8" style="color: var(--success);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold mb-2" style="color: var(--text);">
            Installation Complete!
        </h1>
        <p class="text-sm mb-8 max-w-md mx-auto" style="color: var(--muted);">
            {{ $product['name'] }} has been installed successfully. Your application is now ready to use.
        </p>

        <div class="grid grid-cols-2 gap-3 mb-8 text-left">
            @php
            $info = [
                'Domain'          => $lock['domain']          ?? request()->getHost(),
                'Installed At'    => isset($lock['installed_at']) ? \Carbon\Carbon::parse($lock['installed_at'])->format('Y-m-d H:i') : 'Just now',
                'PHP Version'     => $lock['php_version']     ?? PHP_VERSION,
                'Laravel Version' => $lock['laravel_version'] ?? app()->version(),
            ];
            @endphp
            @foreach($info as $label => $value)
            <div class="rounded-xl p-3" style="background: var(--surface2); border: 1px solid var(--border);">
                <div class="text-xs mb-1" style="color: var(--muted2);">{{ $label }}</div>
                <div class="text-sm font-medium mono" style="color: var(--text);">{{ $value }}</div>
            </div>
            @endforeach
        </div>

        <div class="rounded-xl p-4 mb-6 text-sm text-left" style="background: rgba(99,102,241,0.08); border: 1px solid rgba(99,102,241,0.2);">
            <strong style="color: var(--primary);">Security tip:</strong>
            <span style="color: var(--muted);">
                The installer is now permanently disabled. To re-run it (e.g. for a fresh setup),
                use <code class="mono" style="color: var(--accent);">php artisan installer:reset</code> from the command line.
            </span>
        </div>

        <a href="{{ url('/') }}" class="btn-primary justify-center w-full py-3.5">
            Go to Application
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>
@endsection
