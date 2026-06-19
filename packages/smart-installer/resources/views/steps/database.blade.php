@extends('installer::layouts.app')
@section('title', 'Database Configuration')

@section('content')
<div class="max-w-2xl mx-auto"
     x-data="{
        host:     '{{ $defaults['host'] }}',
        port:     '{{ $defaults['port'] }}',
        database: '{{ $defaults['database'] }}',
        username: '{{ $defaults['username'] }}',
        password: '',
        showPass: false,

        testing:  false,
        saving:   false,
        testResult: null,
        saveError:  null,

        async testConnection() {
            this.testing    = true;
            this.testResult = null;
            this.saveError  = null;
            const r = await ajax('{{ route('installer.database.test') }}', {
                host: this.host, port: this.port,
                database: this.database, username: this.username, password: this.password
            });
            this.testing    = false;
            this.testResult = r.data;
        },

        async saveAndContinue() {
            this.saving    = true;
            this.saveError = null;
            const r = await ajax('{{ route('installer.database.save') }}', {
                host: this.host, port: this.port,
                database: this.database, username: this.username, password: this.password
            });
            this.saving = false;
            if (r.ok) {
                window.location.href = r.data.redirect;
            } else {
                this.saveError = r.data.message || 'Failed to save configuration.';
            }
        }
     }">

    <div class="glass rounded-2xl p-8">
        <h2 class="text-2xl font-bold mb-1" style="color: var(--text);">Database Configuration</h2>
        <p class="text-sm mb-8" style="color: var(--muted);">
            Enter your MySQL/MariaDB credentials. They will be saved to your
            <code class="mono" style="color: var(--accent);">.env</code> file.
        </p>

        <div class="space-y-4 mb-6">
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--muted2);">
                        Database Host
                    </label>
                    <input x-model="host" type="text" placeholder="127.0.0.1" class="input-field mono">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--muted2);">
                        Port
                    </label>
                    <input x-model="port" type="number" placeholder="3306" min="1" max="65535" class="input-field mono">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--muted2);">
                    Database Name
                </label>
                <input x-model="database" type="text" placeholder="my_database" class="input-field mono">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--muted2);">
                        Username
                    </label>
                    <input x-model="username" type="text" placeholder="root" autocomplete="off" class="input-field mono">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-1.5" style="color: var(--muted2);">
                        Password
                    </label>
                    <div class="relative">
                        <input x-model="password"
                               :type="showPass ? 'text' : 'password'"
                               placeholder="••••••••"
                               autocomplete="new-password"
                               class="input-field mono pr-10">
                        <button type="button"
                                @click="showPass = !showPass"
                                class="absolute inset-y-0 right-0 px-3 flex items-center"
                                style="color: var(--muted2);">
                            <svg x-show="!showPass" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg x-show="showPass" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="testResult" x-cloak
             class="rounded-xl p-3.5 mb-4 text-sm flex items-center gap-2"
             :style="testResult?.success
                 ? 'background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#10b981;'
                 : 'background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ef4444;'">
            <span x-text="testResult?.success ? '✓' : '✗'"></span>
            <span x-text="testResult?.message"></span>
            <span x-show="testResult?.server"
                  class="mono text-xs ml-auto opacity-70"
                  x-text="'MySQL ' + testResult?.server"></span>
        </div>

        <div x-show="saveError" x-cloak
             class="rounded-xl p-3.5 mb-4 text-sm"
             style="background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.3);color:#ef4444;"
             x-text="saveError">
        </div>

        <div class="flex gap-3">
            <button @click="testConnection()"
                    :disabled="testing"
                    class="btn-ghost">
                <svg class="w-4 h-4" :class="{ 'animate-spin': testing }"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span x-text="testing ? 'Testing…' : 'Test Connection'"></span>
            </button>

            <button @click="saveAndContinue()"
                    :disabled="saving"
                    class="btn-primary flex-1 justify-center">
                <svg x-show="saving" class="w-4 h-4 animate-spin"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9"/>
                </svg>
                <span x-text="saving ? 'Saving…' : 'Save & Continue'"></span>
                <svg x-show="!saving" class="w-4 h-4"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
async function ajax(url, data) {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    try {
        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify(data),
        });
        return { ok: res.ok, status: res.status, data: await res.json() };
    } catch (e) {
        return { ok: false, status: 0, data: { message: 'Network error: ' + e.message } };
    }
}
</script>
@endpush
@endsection
