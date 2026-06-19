<!DOCTYPE html>
<html lang="en" x-data="{ dir: 'ltr' }" :dir="dir">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'Installer') — {{ $product['name'] ?? 'Application' }}</title>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
  [x-cloak] { display: none !important; }
  :root {
    --bg: #f8fafc; --surface: #ffffff; --surface2: #f1f5f9;
    --border: #e2e8f0; --text: #0f172a; --muted: #475569; --muted2: #94a3b8;
    --primary: #4f46e5; --accent: #06b6d4; --success: #10b981;
    --warning: #f59e0b; --danger: #ef4444;
  }
  body { background: var(--bg); font-family: 'Inter', system-ui, sans-serif; color: var(--text); }
  .glass { background: var(--surface); border: 1px solid var(--border); box-shadow: 0 1px 3px rgba(15,23,42,0.04), 0 8px 24px -12px rgba(15,23,42,0.08); border-radius: 0.75rem; }
  .input-field {
    width: 100%; padding: 0.7rem 1rem; border-radius: 0.6rem;
    background: var(--surface2); border: 1px solid var(--border);
    color: var(--text); outline: none; transition: border-color .15s;
  }
  .input-field:focus { border-color: var(--primary); }
  .btn-primary {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: var(--primary); color: white; padding: 0.7rem 1.5rem;
    border-radius: 0.6rem; font-weight: 600; font-size: 0.9rem;
    transition: opacity .15s; cursor: pointer; border: none;
  }
  .btn-primary:hover { opacity: 0.9; }
  .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; }
  .btn-ghost {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: var(--surface2); color: var(--text); padding: 0.7rem 1.2rem;
    border-radius: 0.6rem; font-weight: 600; font-size: 0.9rem;
    border: 1px solid var(--border); cursor: pointer; transition: .15s;
  }
  .btn-ghost:hover { background: var(--border); }
  .mono { font-family: 'JetBrains Mono', monospace; }
  ::-webkit-scrollbar { width: 6px; height: 6px; }
  ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
</style>
@stack('styles')
</head>
<body class="min-h-screen" style="color: var(--text);">

<div class="min-h-screen flex flex-col">

  <!-- Header -->
  <header class="py-6 px-6 border-b" style="border-color: var(--border);">
    <div class="max-w-3xl mx-auto flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg flex items-center justify-center"
             style="background: linear-gradient(135deg, var(--primary), var(--accent));">
          <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <div>
          <div class="font-semibold text-sm" style="color: var(--text);">{{ $product['name'] ?? 'Application' }}</div>
          <div class="text-xs" style="color: var(--muted2);">Installation Wizard</div>
        </div>
      </div>
      <div class="text-xs mono" style="color: var(--muted2);">v{{ $product['version'] ?? '1.0.0' }}</div>
    </div>
  </header>

  <!-- Step indicator -->
  @isset($steps)
  <div class="px-6 py-4">
    <div class="max-w-3xl mx-auto flex items-center justify-between">
      @foreach($steps as $num => $label)
        <div class="flex items-center flex-1">
          <div class="flex flex-col items-center gap-1.5 {{ $num < count($steps) ? 'flex-1' : '' }}">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold"
                 style="{{ $num < $currentStep
                     ? 'background: var(--success); color: white;'
                     : ($num == $currentStep
                         ? 'background: var(--primary); color: white;'
                         : 'background: var(--surface2); color: var(--muted2); border: 1px solid var(--border);') }}">
              @if($num < $currentStep)
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
              @else
                {{ $num }}
              @endif
            </div>
            <span class="text-[0.65rem] uppercase tracking-wider hidden sm:block"
                  style="color: {{ $num <= $currentStep ? 'var(--text)' : 'var(--muted2)' }};">
              {{ $label }}
            </span>
          </div>
          @if($num < count($steps))
            <div class="h-px flex-1 mx-1" style="background: {{ $num < $currentStep ? 'var(--success)' : 'var(--border)' }};"></div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
  @endisset

  <!-- Main content -->
  <main class="flex-1 px-6 py-8">
    @yield('content')
  </main>

  <footer class="py-4 px-6 text-center text-xs" style="color: var(--muted2);">
    Powered by Smart Installer
  </footer>
</div>

@stack('scripts')
</body>
</html>
