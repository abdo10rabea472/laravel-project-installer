@extends('installer::layouts.app')
@section('title', 'Installing')

@section('content')
<div class="max-w-2xl mx-auto" x-data="installerRunner()">

    <div class="glass rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-1" style="color: var(--text);">
            <span x-show="!finished && !failed">Installing…</span>
            <span x-show="finished" x-cloak>Installation Complete!</span>
            <span x-show="failed" x-cloak>Installation Failed</span>
        </h2>
        <p class="text-sm mb-8" style="color: var(--muted);">
            <span x-show="!finished && !failed">Please wait while we set up your application. This may take a minute.</span>
            <span x-show="finished" x-cloak>Redirecting you to the finish page…</span>
            <span x-show="failed" x-cloak>Something went wrong. You can retry or check the error below.</span>
        </p>

        <div class="space-y-2 mb-6">
            <template x-for="(label, key) in steps" :key="key">
                <div class="rounded-xl px-4 py-3 flex items-center gap-3"
                     style="background: var(--surface2); border: 1px solid var(--border);">

                    <!-- Status icon -->
                    <div class="w-6 h-6 flex-shrink-0 flex items-center justify-center">
                        <svg x-show="statuses[key] === 'pending'" class="w-3 h-3 rounded-full"
                             style="background: var(--muted2);"></svg>

                        <svg x-show="statuses[key] === 'running'" class="w-5 h-5 animate-spin" style="color: var(--primary);"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9"/>
                        </svg>

                        <svg x-show="statuses[key] === 'done'" x-cloak class="w-5 h-5" style="color: var(--success);"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>

                        <svg x-show="statuses[key] === 'failed'" x-cloak class="w-5 h-5" style="color: var(--danger);"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>

                    <span class="text-sm flex-1"
                          :style="statuses[key] === 'pending' ? 'color: var(--muted2);' : 'color: var(--text);'"
                          x-text="label"></span>
                </div>
            </template>
        </div>

        <!-- Error box -->
        <div x-show="failed" x-cloak
             class="rounded-xl p-4 mb-6 text-sm"
             style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #ef4444;">
            <div class="font-semibold mb-1">Error:</div>
            <div class="whitespace-pre-wrap" x-text="errorMessage"></div>
        </div>

        <button x-show="failed" x-cloak @click="retry()" class="btn-primary w-full justify-center">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Retry Installation
        </button>

        <div x-show="finished" x-cloak class="text-center text-sm" style="color: var(--success);">
            ✓ All done — redirecting…
        </div>
    </div>
</div>

@push('scripts')
<script>
window.installerPayload = {
    steps: {{ Js::from($installSteps) }},
    stepKeys: {{ Js::from(array_keys($installSteps)) }},
    initUrl: {{ Js::from(route('installer.install.init')) }},
    stepUrl: {{ Js::from(route('installer.install.step')) }},
};

function installerRunner() {
    return {
        steps: window.installerPayload.steps,
        stepKeys: window.installerPayload.stepKeys,
        statuses: {},
        outputs: {},
        currentIndex: -1,
        running: false,
        finished: false,
        failed: false,
        errorMessage: '',
        redirectUrl: null,

        init() {
            this.stepKeys.forEach((key) => {
                this.statuses[key] = 'pending';
            });
            this.startInstall();
        },

        async startInstall() {
            this.running = true;
            this.finished = false;
            this.failed = false;
            this.errorMessage = '';

            const initResponse = await ajaxPost(window.installerPayload.initUrl, {});
            if (!initResponse.ok) {
                this.failed = true;
                this.running = false;
                this.errorMessage = initResponse.data.message || 'Installation could not start.';
                return;
            }

            for (let i = 0; i < this.stepKeys.length; i++) {
                this.currentIndex = i;
                const key = this.stepKeys[i];
                this.statuses[key] = 'running';

                const response = await ajaxPost(window.installerPayload.stepUrl, { step: key });

                if (response.ok && response.data.success) {
                    this.statuses[key] = 'done';
                    this.outputs[key] = response.data.output || '';

                    if (key === 'lock' && response.data.redirect) {
                        this.redirectUrl = response.data.redirect;
                    }
                } else {
                    this.statuses[key] = 'failed';
                    this.failed = true;
                    this.errorMessage = response.data.message || 'Installation step failed.';
                    this.running = false;
                    return;
                }
            }

            this.running = false;
            this.finished = true;

            if (this.redirectUrl) {
                setTimeout(() => window.location.href = this.redirectUrl, 1200);
            }
        },

        async retry() {
            this.stepKeys.forEach((key) => {
                this.statuses[key] = 'pending';
            });
            await this.startInstall();
        },
    };
}

async function ajaxPost(url, data, attempt = 0) {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    const MAX_ATTEMPTS = 5;
    try {
        const res = await fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
            body: JSON.stringify(data),
        });
        const text = await res.text();
        let json;
        try { json = text ? JSON.parse(text) : {}; }
        catch (_) {
            return { ok: false, status: res.status, data: { message: 'Server returned an invalid response:\n' + text.slice(0, 500) } };
        }
        return { ok: res.ok, status: res.status, data: json };
    } catch (e) {
        // php artisan serve is single-threaded — long-running steps (composer, migrate)
        // can briefly drop the connection. Retry a few times before giving up.
        if (attempt < MAX_ATTEMPTS) {
            await new Promise(r => setTimeout(r, 1500 * (attempt + 1)));
            return ajaxPost(url, data, attempt + 1);
        }
        return { ok: false, status: 0, data: { message: 'Network error: ' + e.message + '\n\nThe dev server may have stalled during a long step. Try refreshing the page or running the step manually (e.g. composer install, php artisan migrate).' } };
    }
}
</script>
@endpush
@endsection
