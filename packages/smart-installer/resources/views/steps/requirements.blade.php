@extends('installer::layouts.app')
@section('title', 'Requirements')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-1" style="color: var(--text);">Server Requirements</h2>
        <p class="text-sm mb-7" style="color: var(--muted);">
            Checking that your server meets all requirements for installation.
        </p>

        <!-- PHP Version -->
        <div class="mb-5">
            <div class="text-xs font-semibold uppercase tracking-wider mb-2.5" style="color: var(--muted2);">
                PHP Version
            </div>
            <div class="rounded-xl p-3.5 flex items-center justify-between"
                 style="background: var(--surface2); border: 1px solid {{ $results['php_version']['passed'] ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)' }};">
                <div class="flex items-center gap-3">
                    @if($results['php_version']['passed'])
                        <svg class="w-5 h-5 flex-shrink-0" style="color: var(--success);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        <svg class="w-5 h-5 flex-shrink-0" style="color: var(--danger);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    @endif
                    <span class="text-sm" style="color: var(--text);">{{ $results['php_version']['label'] }}</span>
                </div>
                <span class="text-sm mono" style="color: var(--muted);">{{ $results['php_version']['current'] }}</span>
            </div>
        </div>

        <!-- Extensions -->
        <div class="mb-5">
            <div class="text-xs font-semibold uppercase tracking-wider mb-2.5" style="color: var(--muted2);">
                PHP Extensions
            </div>
            <div class="grid grid-cols-2 gap-2">
                @foreach($results['extensions'] as $ext)
                <div class="rounded-lg px-3 py-2 flex items-center gap-2"
                     style="background: var(--surface2); border: 1px solid {{ $ext['passed'] ? 'rgba(16,185,129,0.2)' : 'rgba(239,68,68,0.3)' }};">
                    @if($ext['passed'])
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--success);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        <svg class="w-4 h-4 flex-shrink-0" style="color: var(--danger);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    @endif
                    <span class="text-xs mono" style="color: var(--text);">{{ $ext['label'] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Permissions -->
        <div class="mb-7">
            <div class="text-xs font-semibold uppercase tracking-wider mb-2.5" style="color: var(--muted2);">
                Folder Permissions
            </div>
            <div class="space-y-2">
                @foreach($results['permissions'] as $perm)
                <div class="rounded-lg px-3 py-2 flex items-center justify-between"
                     style="background: var(--surface2); border: 1px solid {{ $perm['passed'] ? 'rgba(16,185,129,0.2)' : 'rgba(239,68,68,0.3)' }};">
                    <div class="flex items-center gap-2">
                        @if($perm['passed'])
                            <svg class="w-4 h-4 flex-shrink-0" style="color: var(--success);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 flex-shrink-0" style="color: var(--danger);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        @endif
                        <span class="text-xs mono" style="color: var(--text);">{{ $perm['label'] }}</span>
                    </div>
                    @if(!$perm['passed'])
                        <span class="text-[0.65rem]" style="color: var(--danger);">Not writable</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        @if(!$allPassed)
        <div class="rounded-xl p-3.5 mb-5 text-sm" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #ef4444;">
            Some requirements are not met. Please fix the issues above (e.g. <code class="mono">chmod -R 775 storage bootstrap/cache</code>) and refresh this page.
        </div>
        @endif

        <div class="flex gap-3">
            <a href="{{ route('installer.requirements') }}" class="btn-ghost">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Re-check
            </a>
            @if($allPassed)
            <a href="{{ route('installer.database') }}" class="btn-primary flex-1 justify-center">
                Continue
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @else
            <button disabled class="btn-primary flex-1 justify-center" style="opacity: 0.5; cursor: not-allowed;">
                Continue
            </button>
            @endif
        </div>
    </div>
</div>
@endsection
