<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Installer Explorer</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .chart-container {
            position: relative;
            width: 100%;
            max-width: 650px;
            margin-left: auto;
            margin-right: auto;
            height: 320px;
            max-height: 380px;
        }
        @media (min-width: 768px) {
            .chart-container {
                height: 360px;
            }
        }
    </style>
</head>
<body class="bg-[#FAF9F5] text-[#2C3E50] font-sans antialiased selection:bg-[#E2E8F0]">

    <header class="sticky top-0 z-50 bg-[#F4F1EA]/90 backdrop-blur-md border-b border-[#E6E1D6]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-xl font-bold tracking-tight text-[#1A2E40]">✨ Smart<span class="text-[#D97706]">Installer</span></span>
                <span class="hidden sm:inline-block bg-[#E6E1D6] text-xs px-2 py-0.5 rounded text-[#5C6B73] font-medium">Laravel Package Guide</span>
            </div>
            <nav class="hidden md:flex space-x-1">
                <button onclick="switchTab('dashboard')" class="nav-btn px-3 py-2 text-sm font-medium rounded-md transition-colors bg-[#E6E1D6] text-[#1A2E40]" id="nav-dashboard">Overview & Dashboard</button>
                <button onclick="switchTab('wizard')" class="nav-btn px-3 py-2 text-sm font-medium rounded-md transition-colors text-[#5C6B73] hover:text-[#1A2E40]" id="nav-wizard">Wizard Simulator</button>
                <button onclick="switchTab('artisan')" class="nav-btn px-3 py-2 text-sm font-medium rounded-md transition-colors text-[#5C6B73] hover:text-[#1A2E40]" id="nav-artisan">CLI & Environment</button>
                <button onclick="switchTab('lifecycle')" class="nav-btn px-3 py-2 text-sm font-medium rounded-md transition-colors text-[#5C6B73] hover:text-[#1A2E40]" id="nav-lifecycle">Architecture & Lifecycle</button>
            </nav>
            <div class="md:hidden">
                <select onchange="switchTab(this.value)" class="bg-[#F4F1EA] border border-[#E6E1D6] text-sm rounded-md p-1.5 focus:outline-none focus:border-[#D97706]">
                    <option value="dashboard">Overview & Dashboard</option>
                    <option value="wizard">Wizard Simulator</option>
                    <option value="artisan">CLI & Environment</option>
                    <option value="lifecycle">Architecture & Lifecycle</option>
                </select>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <section id="tab-dashboard" class="tab-content space-y-8 animate-fade-in">
            <div class="bg-white rounded-xl p-6 md:p-8 shadow-sm border border-[#E6E1D6]">
                <h2 class="text-2xl font-bold text-[#1A2E40] mb-2">Package Insights & Readiness Analysis</h2>
                <p class="text-sm text-[#5C6B73] leading-relaxed max-w-3xl">
                    Welcome to the Smart Installer Interactive Documentation Hub. This application dynamically organizes the package capabilities, configuration presets, requirements check criteria, and automated command sequences. Use the selector controls to check environment statuses and visualize the installation step workflow.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-[#F4F1EA]">
                    <div class="bg-[#FAF9F5] p-4 rounded-lg border border-[#E6E1D6]">
                        <div class="text-xs font-semibold uppercase tracking-wider text-[#D97706] mb-1">Laravel Support Scope</div>
                        <div class="text-xl font-bold text-[#1A2E40]">v10, v11, v12, v13</div>
                        <div class="text-xs text-[#5C6B73] mt-2">Compatible across multiple modern legacy and current versions.</div>
                    </div>
                    <div class="bg-[#FAF9F5] p-4 rounded-lg border border-[#E6E1D6]">
                        <div class="text-xs font-semibold uppercase tracking-wider text-[#475569] mb-1">PHP Requirement</div>
                        <div class="text-xl font-bold text-[#1A2E40]">PHP 8.2+</div>
                        <div class="text-xs text-[#5C6B73] mt-2">Enforces optimized autoloader parameters and structural safety bounds.</div>
                    </div>
                    <div class="bg-[#FAF9F5] p-4 rounded-lg border border-[#E6E1D6]">
                        <div class="text-xs font-semibold uppercase tracking-wider text-[#16A34A] mb-1">Security Enforcement</div>
                        <div class="text-xl font-bold text-[#1A2E40]">Smart Lock (404)</div>
                        <div class="text-xs text-[#5C6B73] mt-2">Permanently isolates setup routes upon successful execution completion.</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-[#E6E1D6] flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-[#1A2E40] mb-2">Interactive Requirements Matrix</h3>
                        <p class="text-xs text-[#5C6B73] mb-4">Select an environment type to simulate compatibility checks and understand required system constraints.</p>
                        <div class="mb-4">
                            <label class="block text-xs font-medium text-[#475569] mb-1">Target Environment Archetype</label>
                            <select id="env-preset-selector" onchange="updateEnvPresetCharts()" class="w-full bg-[#FAF9F5] border border-[#E6E1D6] text-sm rounded-md p-2 focus:outline-none focus:ring-1 focus:ring-[#D97706]">
                                <option value="standard">Standard Web Server (Fully Compatible)</option>
                                <option value="minimal">Minimalist CLI/Shared Server (Missing Extension Errors)</option>
                                <option value="restricted">Restricted Environment (Folder Permission Blocks)</option>
                            </select>
                        </div>
                        <div id="requirements-status-list" class="space-y-2.5 text-sm">
                            </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-[#F4F1EA] bg-[#FAF9F5] p-3 rounded text-xs text-[#5C6B73]">
                        💡 <strong>Note on Permissions:</strong> The application guarantees that both <code class="bg-[#E6E1D6] px-1 py-0.5 rounded">storage/</code> and <code class="bg-[#E6E1D6] px-1 py-0.5 rounded">bootstrap/cache/</code> must retain write privileges prior to initialization triggering.
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-[#E6E1D6] flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-[#1A2E40] mb-2">Automated Steps Proportional Volume</h3>
                        <p class="text-xs text-[#5C6B73] mb-4">Proportion of manual setups minimized through automated background step operations execution.</p>
                    </div>
                    <div class="chart-container">
                        <canvas id="dashboardPieChart"></canvas>
                    </div>
                    <div class="text-center text-xs text-[#5C6B73] mt-2">
                        Comprehensive task offloading safely managed inside single script runs.
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-[#E6E1D6]">
                <h3 class="text-lg font-bold text-[#1A2E40] mb-4">Core Feature Framework Matrix</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="p-4 rounded-lg bg-[#FAF9F5] border border-[#F4F1EA]">
                        <div class="text-xl mb-1">🔍</div>
                        <h4 class="font-semibold text-sm text-[#1A2E40] mb-1">Automatic Diagnostics</h4>
                        <p class="text-xs text-[#5C6B73]">Scans native server metadata layers, verifying individual package criteria bounds comprehensively.</p>
                    </div>
                    <div class="p-4 rounded-lg bg-[#FAF9F5] border border-[#F4F1EA]">
                        <div class="text-xl mb-1">🗄️</div>
                        <h4 class="font-semibold text-sm text-[#1A2E40] mb-1">Pre-flight Db Validation</h4>
                        <p class="text-xs text-[#5C6B73]">Verifies target configurations, prevents common exceptions, generates system keys securely.</p>
                    </div>
                    <div class="p-4 rounded-lg bg-[#FAF9F5] border border-[#F4F1EA]">
                        <div class="text-xl mb-1">⚙️</div>
                        <h4 class="font-semibold text-sm text-[#1A2E40] mb-1">Chained Executions</h4>
                        <p class="text-xs text-[#5C6B73]">Invokes Composer parameters alongside migration sequences cleanly in step order.</p>
                    </div>
                    <div class="p-4 rounded-lg bg-[#FAF9F5] border border-[#F4F1EA]">
                        <div class="text-xl mb-1">🔒</div>
                        <h4 class="font-semibold text-sm text-[#1A2E40] mb-1">Smart Route Isolation</h4>
                        <p class="text-xs text-[#5C6B73]">Instantly produces standard 404 response profiles for the router upon process completion.</p>
                    </div>
                    <div class="p-4 rounded-lg bg-[#FAF9F5] border border-[#F4F1EA]">
                        <div class="text-xl mb-1">🌍</div>
                        <h4 class="font-semibold text-sm text-[#1A2E40] mb-1">Bilingual User Comfort</h4>
                        <p class="text-xs text-[#5C6B73]">Fully localized layout optimization for Arabic and light aesthetic design specifications.</p>
                    </div>
                    <div class="p-4 rounded-lg bg-[#FAF9F5] border border-[#F4F1EA]">
                        <div class="text-xl mb-1">💻</div>
                        <h4 class="font-semibold text-sm text-[#1A2E40] mb-1">Dual-Mode CLI Handlers</h4>
                        <p class="text-xs text-[#5C6B73]">Interchangeable GUI browsers and command-line scripts support automated batch deployments.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="tab-wizard" class="tab-content space-y-8 hidden animate-fade-in">
            <div class="bg-white rounded-xl p-6 md:p-8 shadow-sm border border-[#E6E1D6]">
                <h2 class="text-2xl font-bold text-[#1A2E40] mb-2">Web Wizard Flow Simulation</h2>
                <p class="text-sm text-[#5C6B73] leading-relaxed">
                    This interactive workflow map details the sequencing logic behind the user browser screens during installation. Click on any step indicator below to inspect backend tasks, automated logic parameters, and real-time interface rendering scenarios.
                </p>

                <div class="mt-8 grid grid-cols-5 gap-2 max-w-4xl mx-auto text-center font-medium text-xs">
                    <button onclick="setWizardStep(1)" id="btn-step-1" class="p-3 rounded-lg border bg-[#1A2E40] text-white border-[#1A2E40]">
                        <div class="font-bold">Step 1</div>
                        <div>Welcome</div>
                    </button>
                    <button onclick="setWizardStep(2)" id="btn-step-2" class="p-3 rounded-lg border bg-[#FAF9F5] text-[#5C6B73] border-[#E6E1D6]">
                        <div class="font-bold">Step 2</div>
                        <div>Requirements</div>
                    </button>
                    <button onclick="setWizardStep(3)" id="btn-step-3" class="p-3 rounded-lg border bg-[#FAF9F5] text-[#5C6B73] border-[#E6E1D6]">
                        <div class="font-bold">Step 3</div>
                        <div>Database</div>
                    </button>
                    <button onclick="setWizardStep(4)" id="btn-step-4" class="p-3 rounded-lg border bg-[#FAF9F5] text-[#5C6B73] border-[#E6E1D6]">
                        <div class="font-bold">Step 4</div>
                        <div>Execution</div>
                    </button>
                    <button onclick="setWizardStep(5)" id="btn-step-5" class="p-3 rounded-lg border bg-[#FAF9F5] text-[#5C6B73] border-[#E6E1D6]">
                        <div class="font-bold">Step 5</div>
                        <div>Isolation</div>
                    </button>
                </div>

                <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2 bg-[#F4F1EA] p-5 rounded-xl border border-[#E6E1D6] space-y-4">
                        <div class="flex items-center justify-between border-b border-[#E6E1D6] pb-2">
                            <span class="text-xs font-bold text-[#475569] uppercase tracking-wider">Simulated Browser Workspace Screen</span>
                            <div class="flex space-x-1.5">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span>
                                <span class="w-2.5 h-2.5 rounded-full bg-green-400"></span>
                            </div>
                        </div>
                        <div id="wizard-screen-content" class="bg-white p-6 rounded-lg min-h-[220px] shadow-sm border border-[#E6E1D6]">
                            </div>
                    </div>

                    <div class="bg-[#FAF9F5] p-5 rounded-xl border border-[#E6E1D6] flex flex-col justify-between">
                        <div>
                            <h4 class="font-bold text-[#1A2E40] text-sm uppercase tracking-wider mb-2">Under-the-Hood Actions</h4>
                            <div id="wizard-explanation-text" class="text-xs text-[#5C6B73] space-y-3 leading-relaxed">
                                </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-[#E6E1D6] flex justify-between items-center">
                            <button id="prev-step-btn" onclick="adjustWizardStep(-1)" class="px-3 py-1.5 text-xs font-medium rounded border border-[#E6E1D6] bg-white hover:bg-[#F4F1EA] disabled:opacity-40" disabled>Previous</button>
                            <button id="next-step-btn" onclick="adjustWizardStep(1)" class="px-3 py-1.5 text-xs font-medium rounded border border-[#1A2E40] bg-[#1A2E40] text-white hover:bg-[#2C3E50]">Next Step</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-[#E6E1D6]">
                <div class="sm:flex sm:items-center sm:justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-bold text-[#1A2E40]">Step 4 Complete Automation Sequence Logs</h3>
                        <p class="text-xs text-[#5C6B73]">Live reference map of commands executed sequentially during the installation pipeline hook.</p>
                    </div>
                    <div class="mt-2 sm:mt-0">
                        <input type="text" id="command-search" oninput="filterCommandTable()" placeholder="Filter commands..." class="bg-[#FAF9F5] border border-[#E6E1D6] rounded-md px-3 py-1.5 text-xs focus:outline-none focus:ring-1 focus:ring-[#D97706] w-full sm:w-48">
                    </div>
                </div>
                <div class="overflow-x-auto border border-[#E6E1D6] rounded-lg">
                    <table class="min-w-full text-xs text-left">
                        <thead class="bg-[#F4F1EA] text-[#475569] uppercase font-semibold border-b border-[#E6E1D6]">
                            <tr>
                                <th class="p-3">Order</th>
                                <th class="p-3">Command Structure</th>
                                <th class="p-3">Functional Domain Objective</th>
                            </tr>
                        </thead>
                        <tbody id="command-table-body" class="divide-y divide-[#F4F1EA]">
                            </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="tab-artisan" class="tab-content space-y-8 hidden animate-fade-in">
            <div class="bg-white rounded-xl p-6 md:p-8 shadow-sm border border-[#E6E1D6]">
                <h2 class="text-2xl font-bold text-[#1A2E40] mb-2">CLI Deployments & Environment Blueprinting</h2>
                <p class="text-sm text-[#5C6B73] leading-relaxed">
                    Review necessary console procedures and template keys configured for the local architecture setup. Switch interactive sub-tabs to inspect manual installation code blocks or sample environment templates.
                </p>

                <div class="flex space-x-2 mt-6 border-b border-[#F4F1EA] pb-3">
                    <button onclick="toggleCliView('artisan-commands')" id="btn-sub-artisan" class="px-4 py-1.5 text-xs font-semibold rounded-md transition-colors bg-[#E6E1D6] text-[#1A2E40]">Artisan Actions Reference</button>
                    <button onclick="toggleCliView('env-stubs')" id="btn-sub-env" class="px-4 py-1.5 text-xs font-semibold rounded-md transition-colors text-[#5C6B73] hover:bg-[#F4F1EA]">Environment Examples (.env)</button>
                </div>

                <div id="sub-view-artisan-commands" class="sub-cli-view space-y-6 mt-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h4 class="font-bold text-sm text-[#1A2E40]">Interactive Core Flags Preview</h4>
                            <p class="text-xs text-[#5C6B73]">Toggle common deployment flags to observe how the console interpreter command signature mutates dynamic parameters on delivery.</p>
                            <div class="bg-[#FAF9F5] p-4 rounded-lg border border-[#E6E1D6] space-y-3 text-xs">
                                <label class="flex items-center space-x-2.5 cursor-pointer">
                                    <input type="checkbox" id="flag-composer" onchange="generateArtisanString()" class="rounded border-[#E6E1D6] text-[#D97706] focus:ring-0">
                                    <span>Skip dependency management (<code class="bg-[#E6E1D6] px-1 py-0.5 rounded">--skip-composer</code>)</span>
                                </label>
                                <label class="flex items-center space-x-2.5 cursor-pointer">
                                    <input type="checkbox" id="flag-seed" onchange="generateArtisanString()" class="rounded border-[#E6E1D6] text-[#D97706] focus:ring-0">
                                    <span>Omit demo records loading (<code class="bg-[#E6E1D6] px-1 py-0.5 rounded">--skip-seed</code>)</span>
                                </label>
                                <label class="flex items-center space-x-2.5 cursor-pointer">
                                    <input type="checkbox" id="flag-force" onchange="generateArtisanString()" class="rounded border-[#E6E1D6] text-[#D97706] focus:ring-0">
                                    <span>Force overriding locks (<code class="bg-[#E6E1D6] px-1 py-0.5 rounded">--force</code>)</span>
                                </label>
                            </div>
                            <div class="bg-gray-900 text-gray-100 p-4 rounded-lg font-mono text-xs relative overflow-hidden">
                                <div class="text-gray-500 select-none mb-1"># Generated Artisan Signature</div>
                                <code id="generated-artisan-cmd">php artisan installer:run</code>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h4 class="font-bold text-sm text-[#1A2E40]">Reset & Assets Registration</h4>
                            <p class="text-xs text-[#5C6B73]">Use standard system clean tools if local configurations or file tokens become corrupt.</p>
                            <div class="space-y-3">
                                <div class="p-3 bg-[#FAF9F5] rounded-lg border border-[#E6E1D6]">
                                    <div class="text-xs font-bold text-[#1A2E40] font-mono">php artisan installer:reset [--force]</div>
                                    <p class="text-xs text-[#5C6B73] mt-1">Cleans temporary dynamic metrics tokens to allow developer troubleshooting.</p>
                                </div>
                                <div class="p-3 bg-[#FAF9F5] rounded-lg border border-[#E6E1D6]">
                                    <div class="text-xs font-bold text-[#1A2E40] font-mono">php artisan vendor:publish --tag=installer-views --force</div>
                                    <p class="text-xs text-[#5C6B73] mt-1">Ejects vendor templates directly into local blade workspace layers for customization overrides.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="sub-view-env-stubs" class="sub-cli-view space-y-4 mt-6 hidden">
                    <h4 class="font-bold text-sm text-[#1A2E40]">Required Stubs Injection Parameters</h4>
                    <p class="text-xs text-[#5C6B73]">
                        Append the variables template configuration below safely into <code class="bg-[#E6E1D6] px-1 font-mono">.env.example</code>. The package parses keys during subsequent web evaluations dynamically.
                    </p>
                    <div class="bg-gray-900 text-gray-100 p-5 rounded-lg font-mono text-xs whitespace-pre overflow-x-auto">PRODUCT_NAME="My Application"  
PRODUCT_VERSION=1.0.0  
PRODUCT_DESCRIPTION="A Laravel application."  
PRODUCT_SUPPORT_URL="https://support.example.com"  
SESSION_DRIVER=file</div>
                    <div class="bg-[#FAF9F5] p-3 rounded-md border border-yellow-200 text-xs text-amber-800">
                        🛑 <strong>Security Guardrail Note:</strong> Ensure local physical instances of <code class="font-mono bg-white px-1">.env</code> keys remain excluded from shared git histories. The controller guarantees clean creation pipelines dynamically.
                    </div>
                </div>
            </div>
        </section>

        <section id="tab-lifecycle" class="tab-content space-y-8 hidden animate-fade-in">
            <div class="bg-white rounded-xl p-6 md:p-8 shadow-sm border border-[#E6E1D6]">
                <h2 class="text-2xl font-bold text-[#1A2E40] mb-2">Package Tree Structure & Lifecycle Routines</h2>
                <p class="text-sm text-[#5C6B73] leading-relaxed">
                    Review files layout alongside structural processes required to configure upgrades or handle secure removal procedures correctly.
                </p>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-bold text-[#1A2E40] uppercase tracking-wider">Directory Tree Architecture</h3>
                            <span class="text-xs text-[#5C6B73]">Click items to view metadata definitions</span>
                        </div>
                        <div class="bg-[#FAF9F5] p-4 rounded-xl border border-[#E6E1D6] font-mono text-xs space-y-2 select-none">
                            <div class="text-[#1A2E40] font-bold">📦 packages/</div>
                            <div class="pl-4 border-l border-[#E6E1D6] space-y-2">
                                <div class="cursor-pointer text-amber-700 hover:underline" onclick="showFolderMeta('config')">📁 smart-installer/</div>
                                <div id="meta-config" class="hidden pl-4 py-1 text-[11px] text-[#5C6B73] bg-white rounded border border-[#E6E1D6]">Contains system parameters configuration arrays.</div>
                                
                                <div class="pl-4 border-l border-[#E6E1D6] space-y-1.5">
                                    <div class="cursor-pointer text-blue-700 hover:underline" onclick="showFolderMeta('views')">📁 resources/views/</div>
                                    <div id="meta-views" class="hidden pl-4 py-1 text-[11px] text-[#5C6B73] bg-white rounded border border-[#E6E1D6]">Dynamic blade components translated cleanly into custom templates.</div>
                                    
                                    <div class="cursor-pointer text-blue-700 hover:underline" onclick="showFolderMeta('src')">📁 src/Http/Middleware/</div>
                                    <div id="meta-src" class="hidden pl-4 py-1 text-[11px] text-[#5C6B73] bg-white rounded border border-[#E6E1D6]">Guards installer routes against secondary executions once a lock file exists.</div>
                                </div>
                                <div class="text-[#5C6B73]">📄 install.bat <span class="text-[10px] bg-gray-200 px-1 rounded">Windows</span></div>
                                <div class="text-[#5C6B73]">📄 update.bat <span class="text-[10px] bg-gray-200 px-1 rounded">Windows</span></div>
                                <div class="text-[#5C6B73]">📄 uninstall.bat <span class="text-[10px] bg-gray-200 px-1 rounded">Windows</span></div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 flex flex-col justify-between">
                        <div>
                            <h3 class="text-sm font-bold text-[#1A2E40] uppercase tracking-wider mb-3">Lifecycle Pipelines Operations</h3>
                            <div class="space-y-4">
                                <div class="p-4 rounded-lg bg-white border border-[#E6E1D6] space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-[#1A2E40]">Package Upgrades (Maintenance Flow)</span>
                                        <span class="text-[10px] text-green-700 bg-green-50 px-1.5 py-0.5 rounded border border-green-200">Safe</span>
                                    </div>
                                    <p class="text-xs text-[#5C6B73]">Execute the helper sequence via console prompts to safely update dependency records without breaking database settings values.</p>
                                    <pre class="bg-[#FAF9F5] p-2 text-[11px] font-mono rounded border text-[#475569] overflow-x-auto">composer update app/installer && php artisan optimize:clear</pre>
                                </div>

                                <div class="p-4 rounded-lg bg-white border border-[#E6E1D6] space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-bold text-red-700">Permanent System Removal Sequence</span>
                                        <span class="text-[10px] text-red-700 bg-red-50 px-1.5 py-0.5 rounded border border-red-200">Destructive</span>
                                    </div>
                                    <p class="text-xs text-[#5C6B73]">Completely removes package configuration states and vendor files references from composer mappings.</p>
                                    <pre class="bg-[#FAF9F5] p-2 text-[11px] font-mono rounded border text-[#475569] overflow-x-auto">composer remove app/installer && rm -f config/installer.php</pre>
                                </div>
                            </div>
                        </div>
                        <div class="bg-[#FAF9F5] p-3 rounded-lg border border-[#E6E1D6] text-[11px] text-[#5C6B73] font-mono flex justify-between items-center">
                            <span>Status Reader Check Hook:</span>
                            <span class="bg-[#E6E1D6] px-2 py-0.5 rounded font-bold text-[#1A2E40]">InstallerServiceProvider::isInstalled()</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-[#F4F1EA] border-t border-[#E6E1D6] mt-20 py-6 text-center text-xs text-[#5C6B73]">
        <div class="max-w-7xl mx-auto px-4">
            <p>© 2026 Smart Installer Explorer Dashboard Framework. Distributed cleanly under open MIT permissions criteria parameters.</p>
        </div>
    </footer>

    <script>
        // Global Application State Context Layer
        const state = {
            currentWizardStep: 1,
            selectedEnvPreset: 'standard'
        };

        const requirementsData = [
            { id: 'php', name: 'PHP Environment (8.2+)', baseMin: '8.2', standard: '8.4 (Pass)', minimal: '8.3 (Pass)', restricted: '8.1 (Fail)', type: 'version' },
            { id: 'extensions', name: 'Core Required PHP Extensions', baseMin: 'PDO, OpenSSL, Mbstring', standard: 'All Present', minimal: 'Missing pdo_mysql', restricted: 'All Present', type: 'ext' },
            { id: 'permissions', name: 'Directory Write Privileges', baseMin: 'Writable Storage & Cache', standard: 'Granted', minimal: 'Granted', restricted: 'Blocked (Access Denied)', type: 'perm' }
        ];

        const commandsSequence = [
            { id: 1, cmd: 'composer install --no-dev --optimize-autoloader', desc: 'Installs locked package production components cleanly.' },
            { id: 2, cmd: 'composer dump-autoload --optimize', desc: 'Regenerates fast mapped structures inside autoloader systems.' },
            { id: 3, cmd: 'php artisan migrate --force', desc: 'Triggers database tables updates bypassing confirmation alerts.' },
            { id: 4, cmd: 'php artisan db:seed --force', desc: 'Loads primary dictionary and fallback seeders into database rows.' },
            { id: 5, cmd: 'php artisan storage:link', desc: 'Exposes persistent media files directories to public web layouts.' },
            { id: 6, cmd: 'php artisan optimize:clear', desc: 'Purges stale runtime templates memory caches safely.' },
            { id: 7, cmd: 'php artisan config:cache', desc: 'Combines dynamic properties strings into unified flat arrays.' },
            { id: 8, cmd: 'php artisan route:cache', desc: 'Compiles route definitions trees for high speed response processing.' },
            { id: 9, cmd: 'php artisan view:cache', desc: 'Pre-compiles blade templates to eliminate production file system IO checks.' },
            { id: 10, cmd: 'Lock File Generation', desc: 'Writes an physical lock array preventing route re-entry forever.' }
        ];

        const wizardStepsContent = {
            1: {
                title: "Step 1: Welcome & Server Handshake",
                screen: "<div class='space-y-3 text-center py-4'><h3 class='text-lg font-bold text-[#1A2E40]'>✨ Smart Installer Welcome</h3><p class='text-xs text-[#5C6B73]'>System checks complete. Ready to unpack application configurations layer structures into active database targets.</p><div class='inline-block text-[11px] bg-[#FAF9F5] border border-[#E6E1D6] rounded px-3 py-1 font-mono text-[#475569]'>Detected Environment: PHP 8.3 on Linux Server Architecture</div></div>",
                explainer: "<strong>Backend Process Hooks:</strong><br>• Extracts initial environment configuration definitions variables context.<br>• Validates active request paths aren't flag-isolated inside structural system lock checks blocks."
            },
            2: {
                title: "Step 2: Core Diagnostics Integrity Verification",
                screen: "<div class='space-y-2'><h4 class='text-xs font-bold uppercase text-[#475569]'>System Verification Status Logs</h4><div class='text-xs space-y-1.5 font-mono'><div class='text-green-6xl flex items-center justify-between bg-green-50 p-1.5 rounded text-green-800'><span>✓ PHP Version Requirement Verified</span><span class='font-bold'>[8.3.2]</span></div><div class='text-green-6xl flex items-center justify-between bg-green-50 p-1.5 rounded text-green-800'><span>✓ Required Native Modules Loaded</span><span class='font-bold'>[OK]</span></div><div class='text-green-6xl flex items-center justify-between bg-green-50 p-1.5 rounded text-green-800'><span>✓ Storage Workspace Path Privileges</span><span class='font-bold'>[Writable]</span></div></div></div>",
                explainer: "<strong>Backend Process Hooks:</strong><br>• Executes internal PHP reflection method queries across critical extension strings list targets.<br>• Asserts dynamic file generation outputs test tasks inside caching pipelines directories structural nodes."
            },
            3: {
                title: "Step 3: Database Engine Credentials Hooking",
                screen: "<div class='space-y-3 text-xs'><label class='block font-medium text-[#475569]'>Database Connection Profile</label><input type='text' disabled value='mysql' class='w-full bg-[#FAF9F5] border rounded p-1.5 font-mono'><div class='grid grid-cols-2 gap-2'><input type='text' disabled value='127.0.0.1' class='bg-[#FAF9F5] border rounded p-1.5 font-mono'><input type='text' disabled value='forge_production_db' class='bg-[#FAF9F5] border rounded p-1.5 font-mono'></div><div class='text-[10px] text-amber-700 bg-amber-50 p-1.5 rounded border border-amber-200'>✓ Active database connection verified over secure connection string sockets parameters layers.</div></div>",
                explainer: "<strong>Backend Process Hooks:</strong><br>• Establishes safe verification queries checking target system availability schemas definitions structures.<br>• Generates structural <code class='bg-gray-200 px-0.5 rounded'>APP_KEY</code> records dynamically when local properties profiles report missing variable parameters."
            },
            4: {
                title: "Step 4: Chained System Tasks Deployment Run",
                screen: "<div class='space-y-2.5 text-xs'><div class='flex justify-between items-center'><span class='font-medium text-[#1A2E40]'>Automated Sequence Pipeline State:</span><span class='text-amber-700 font-bold animate-pulse'>Executing Step 4/10...</span></div><div class='w-full bg-gray-200 rounded-full h-2'><div class='bg-[#D97706] h-2 rounded-full transition-all duration-300' style='width: 40%'></div></div><div class='bg-gray-900 text-gray-200 p-2.5 rounded font-mono text-[10px] h-20 overflow-y-auto' id='terminal-wizard-sim'>$ php artisan migrate --force\nMigrating: 2026_01_01_000000_create_users_table\nMigrated:  2026_01_01_000000_create_users_table (42ms)</div></div>",
                explainer: "<strong>Backend Process Hooks:</strong><br>• Fires sequential sub-process arrays executing nested artisan optimization definitions structures cleanly.<br>• Intercepts failure conditions strings natively, feeding user views structured retry workflow buttons instantly."
            },
            5: {
                title: "Step 5: Completion & Immutable Security Lockout",
                screen: "<div class='space-y-3 text-center py-4'><div class='text-2xl text-green-600'>✓ Setup Complete</div><h3 class='text-sm font-bold text-[#1A2E40]'>Application Active & Safe</h3><p class='text-[11px] text-[#5C6B73]'>The setup layout is now permanently locked via native route exclusions. Any subsequent hits produce isolated 404 profiles.</p><button disabled class='bg-[#1A2E40] text-white text-xs px-4 py-2 rounded opacity-50 cursor-not-allowed'>Launch Application Dashboard</button></div>",
                explainer: "<strong>Backend Process Hooks:</strong><br>• Commits the physical immutable lock array mapping metadata tracking configuration files payload layers.<br>• Enforces execution configurations mapping variables tracking system states cleanly without database leaks."
            }
        };

        // Navigation Tab Switching Manager Routine
        window.switchTab = function(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.getElementById('tab-' + tabName).classList.remove('hidden');
            
            document.querySelectorAll('.nav-btn').forEach(btn => {
                btn.classList.remove('bg-[#E6E1D6]', 'text-[#1A2E40]');
                btn.classList.add('text-[#5C6B73]');
            });
            const activeBtn = document.getElementById('nav-' + tabName);
            if(activeBtn) {
                activeBtn.classList.add('bg-[#E6E1D6]', 'text-[#1A2E40]');
                activeBtn.classList.remove('text-[#5C6B73]');
            }
        };

        // Requirements Interactive Matrix Presets Component Engine
        window.updateEnvPresetCharts = function() {
            const presetKey = document.getElementById('env-preset-selector').value;
            state.selectedEnvPreset = presetKey;
            
            const listContainer = document.getElementById('requirements-status-list');
            listContainer.innerHTML = '';
            
            requirementsData.forEach(item => {
                const specVal = item[presetKey];
                const isFail = specVal.includes('Fail') || specVal.includes('Blocked') || specVal.includes('Missing');
                
                const card = document.createElement('div');
                card.className = "flex items-center justify-between p-2.5 rounded-lg border bg-white transition-colors " + (isFail ? 'border-red-200 bg-red-50/30' : 'border-[#E6E1D6]');
                card.innerHTML = `
                    <div class="flex flex-col">
                        <span class="font-medium text-[#1A2E40]">${item.name}</span>
                        <span class="text-[10px] text-[#5C6B73]">Min Scope Target: ${item.baseMin}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full ${isFail ? 'bg-red-500' : 'bg-green-600'}"></span>
                        <span class="text-xs font-mono font-bold ${isFail ? 'text-red-700' : 'text-green-700'}">${specVal}</span>
                    </div>
                `;
                listContainer.appendChild(card);
            });
        };

        // Web Wizard Simulation Execution Controls Engine
        window.setWizardStep = function(stepNum) {
            state.currentWizardStep = stepNum;
            
            for(let i = 1; i <= 5; i++) {
                const btn = document.getElementById(`btn-step-${i}`);
                if(i === stepNum) {
                    btn.className = "p-3 rounded-lg border bg-[#1A2E40] text-white border-[#1A2E40]";
                } else {
                    btn.className = "p-3 rounded-lg border bg-[#FAF9F5] text-[#5C6B73] border-[#E6E1D6]";
                }
            }
            
            const viewData = wizardStepsContent[stepNum];
            document.getElementById('wizard-screen-content').innerHTML = `
                <h4 class="text-xs font-bold text-[#D97706] mb-2 uppercase tracking-wide">${viewData.title}</h4>
                ${viewData.screen}
            `;
            document.getElementById('wizard-explanation-text').innerHTML = viewData.explainer;
            
            document.getElementById('prev-step-btn').disabled = (stepNum === 1);
            document.getElementById('next-step-btn').disabled = (stepNum === 5);
        };

        window.adjustWizardStep = function(delta) {
            let nextStep = state.currentWizardStep + delta;
            if(nextStep >= 1 && nextStep <= 5) {
                setWizardStep(nextStep);
            }
        };

        // Command Logs Reference Table Search Filter Component
        window.filterCommandTable = function() {
            const query = document.getElementById('command-search').value.toLowerCase();
            const filtered = commandsSequence.filter(c => c.cmd.toLowerCase().includes(query) || c.desc.toLowerCase().includes(query));
            renderCommandTable(filtered);
        };

        function renderCommandTable(dataArray) {
            const tbody = document.getElementById('command-table-body');
            tbody.innerHTML = '';
            if(dataArray.length === 0) {
                tbody.innerHTML = `<tr><td colspan="3" class="p-4 text-center text-[#5C6B73]">No matching command profiles discovered.</td></tr>`;
                return;
            }
            dataArray.forEach(item => {
                const row = document.createElement('tr');
                row.className = "hover:bg-[#FAF9F5]/60 transition-colors";
                row.innerHTML = `
                    <td class="p-3 font-mono text-[#5C6B73] font-bold">${item.id}</td>
                    <td class="p-3"><code class="bg-[#E6E1D6] px-1.5 py-0.5 rounded font-mono text-[#1A2E40] text-[11px]">${item.cmd}</code></td>
                    <td class="p-3 text-[#5C6B73]">${item.desc}</td>
                `;
                tbody.appendChild(row);
            });
        }

        // Sub View Toggles for CLI Operations Controls Hub
        window.toggleCliView = function(viewKey) {
            document.querySelectorAll('.sub-cli-view').forEach(el => el.classList.add('hidden'));
            document.getElementById(`sub-view-${viewKey}`).classList.remove('hidden');
            
            document.getElementById('btn-sub-artisan').className = "px-4 py-1.5 text-xs font-semibold rounded-md transition-colors text-[#5C6B73] hover:bg-[#F4F1EA]";
            document.getElementById('btn-sub-env').className = "px-4 py-1.5 text-xs font-semibold rounded-md transition-colors text-[#5C6B73] hover:bg-[#F4F1EA]";
            
            if(viewKey === 'artisan-commands') {
                document.getElementById('btn-sub-artisan').className = "px-4 py-1.5 text-xs font-semibold rounded-md transition-colors bg-[#E6E1D6] text-[#1A2E40]";
            } else {
                document.getElementById('btn-sub-env').className = "px-4 py-1.5 text-xs font-semibold rounded-md transition-colors bg-[#E6E1D6] text-[#1A2E40]";
            }
        };

        // Dynamic Flag-based Artisan Commands Signature Mutator Utility
        window.generateArtisanString = function() {
            let base = "php artisan installer:run";
            if(document.getElementById('flag-composer').checked) base += " --skip-composer";
            if(document.getElementById('flag-seed').checked) base += " --skip-seed";
            if(document.getElementById('flag-force').checked) base += " --force";
            document.getElementById('generated-artisan-cmd').innerText = base;
        };

        // File Explorer Nested Tree Metadata Inspector Component Hook
        window.showFolderMeta = function(metaId) {
            const block = document.getElementById(`meta-${metaId}`);
            if(block.classList.contains('hidden')) {
                block.classList.remove('hidden');
            } else {
                block.classList.add('hidden');
            }
        };

        // Application ChartJS Canvas Visualizer Implementation Routine
        function initializeAnalyticsCharts() {
            const ctxPie = document.getElementById('dashboardPieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: ['Automated Steps', 'Manual Injection Variables'],
                    datasets: [{
                        data: [90, 10],
                        backgroundColor: ['#1A2E40', '#D97706'],
                        borderWidth: 2,
                        borderColor: '#FAF9F5'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: { size: 11 },
                                color: '#2C3E50'
                            }
                        }
                    },
                    cutout: '70%'
                }
            });
        }

        // Global Orchestrator Handshake Lifecycle Setup Bootstrapping Node
        document.addEventListener("DOMContentLoaded", () => {
            initializeAnalyticsCharts();
            updateEnvPresetCharts();
            setWizardStep(1);
            renderCommandTable(commandsSequence);
        });
    </script>
</body>
</html>
