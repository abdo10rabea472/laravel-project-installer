@extends('installer::layouts.app')
@section('title', 'Welcome')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="glass rounded-2xl p-8 text-center">
        <div class="w-16 h-16 rounded-2xl mx-auto mb-5 flex items-center justify-center"
             style="background: linear-gradient(135deg, var(--primary), var(--accent));">
            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold mb-2" style="color: var(--text);">
            Welcome to {{ $product['name'] }}
        </h1>
        <p class="text-sm mb-8 max-w-md mx-auto" style="color: var(--muted);">
            {{ $product['description'] ?? 'Let\'s get your application set up. This wizard will guide you through checking requirements, configuring your database, and finishing the installation.' }}
        </p>

        <!-- Server info grid -->
        <div class="grid grid-cols-2 gap-3 mb-8 text-left">
            @php
            $info = [
                'PHP Version'     => $server['php_version'],
                'Laravel Version' => $server['laravel_version'],
                'Server Software' => $server['server_software'],
                'Operating System'=> $server['os'],
            ];
            @endphp
            @foreach($info as $label => $value)
            <div class="rounded-xl p-3" style="background: var(--surface2); border: 1px solid var(--border);">
                <div class="text-xs mb-1" style="color: var(--muted2);">{{ $label }}</div>
                <div class="text-sm font-medium mono" style="color: var(--text);">{{ $value }}</div>
            </div>
            @endforeach
        </div>

        <a href="{{ route('installer.requirements') }}" class="btn-primary justify-center w-full py-3.5">
            Get Started
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
</div>
@endsection
