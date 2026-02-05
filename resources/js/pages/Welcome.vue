<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';

function startGame() {
    router.post('/game');
}
</script>

<template>
    <Head title="Klondike Solitaire">
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700" rel="stylesheet" />
    </Head>

    <div class="min-h-screen bg-[#0c1929] font-mono text-white">
        <!-- Header -->
        <header class="border-b border-[#1e3a5f]/50 bg-[#0c1929]/80 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <svg class="h-8 w-8 text-[#38bdf8]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                        <span class="text-lg font-bold tracking-wider">KLONDIKE</span>
                        <span class="text-[#38bdf8]">SOLITAIRE</span>
                    </div>
                    <span class="text-xs tracking-widest text-slate-500">// SYSTEM.READY</span>
                </div>
                <div class="flex items-center gap-8 text-xs tracking-widest text-slate-400">
                    <a href="#features" class="transition hover:text-white">FEATURES</a>
                    <a href="#specs" class="transition hover:text-white">SPECIFICATIONS</a>
                    <a href="https://laravel.com/docs" target="_blank" class="transition hover:text-white">DOCS</a>
                    <span class="rounded border border-[#38bdf8]/30 bg-[#38bdf8]/10 px-3 py-1 text-[#38bdf8]">V 1.0.0</span>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="relative overflow-hidden">
            <!-- Background grid pattern -->
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#1e3a5f20_1px,transparent_1px),linear-gradient(to_bottom,#1e3a5f20_1px,transparent_1px)] bg-[size:40px_40px]" />

            <!-- Vertical text on left -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 -rotate-90 transform text-[80px] font-bold tracking-widest text-[#1e3a5f]/30">
                STRUCTURE
            </div>

            <div class="relative mx-auto max-w-7xl px-6 py-16">
                <div class="grid gap-12 lg:grid-cols-2">
                    <!-- Left content -->
                    <div class="flex flex-col justify-center">
                        <!-- Coordinates -->
                        <div class="mb-8 text-right text-xs tracking-widest text-slate-500 lg:text-left">
                            COORD: 34.0522° N, 118.2437° W<br />
                            SECURE CONNECTION
                        </div>

                        <!-- Status badge -->
                        <div class="mb-4 flex items-center gap-2">
                            <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-500" />
                            <span class="text-xs tracking-widest text-emerald-400">GLOBAL DEPLOYMENT READY</span>
                        </div>

                        <!-- Main headline -->
                        <h1 class="mb-6">
                            <span class="block text-[72px] font-bold leading-none tracking-tighter text-white">UNLIMITED</span>
                            <span class="block text-[72px] font-bold leading-none tracking-tighter text-[#38bdf8]">SCALE</span>
                        </h1>

                        <!-- Description -->
                        <div class="mb-8 border-l-2 border-slate-600 pl-4">
                            <p class="max-w-md text-sm leading-relaxed text-slate-400">
                                Next-generation infrastructure for modern PHP applications. Zero configuration. Infinite scale. The industrial standard for cloud computing.
                            </p>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex gap-4">
                            <button
                                @click="startGame"
                                class="group flex items-center gap-3 bg-[#38bdf8] px-8 py-4 font-semibold tracking-wider text-[#0c1929] transition hover:bg-[#7dd3fc]"
                            >
                                PLAY SOLITAIRE
                                <svg class="h-5 w-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                            <a
                                href="https://laravel.com/docs"
                                target="_blank"
                                class="flex items-center gap-3 border border-slate-600 px-8 py-4 font-semibold tracking-wider text-white transition hover:border-white hover:bg-white/5"
                            >
                                READ BLUEPRINT
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Right panel - Server visualization -->
                    <div class="flex items-center justify-center">
                        <div class="relative w-full max-w-md">
                            <!-- Server panel -->
                            <div class="border border-[#38bdf8]/30 bg-[#0c1929]/80 p-6 backdrop-blur">
                                <!-- Header -->
                                <div class="mb-6 flex items-center justify-between">
                                    <span class="text-xs tracking-widest text-slate-400">UNIT: SRV-01</span>
                                    <span class="text-xs tracking-widest text-emerald-400">STATUS: ONLINE</span>
                                </div>

                                <!-- Card visualization -->
                                <div class="mb-8 flex justify-center">
                                    <div class="relative">
                                        <!-- Card back representation -->
                                        <div class="h-40 w-28 rounded-lg border-2 border-[#38bdf8]/50 bg-gradient-to-br from-[#1e3a5f] to-[#0c1929]">
                                            <div class="flex h-full flex-col items-center justify-center gap-2">
                                                <div class="h-1 w-16 bg-[#38bdf8]/30" />
                                                <div class="h-1 w-12 bg-[#38bdf8]/30" />
                                                <div class="h-1 w-14 bg-[#38bdf8]/30" />
                                                <div class="mt-4">
                                                    <svg class="h-6 w-6 text-[#38bdf8]/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Stacked cards effect -->
                                        <div class="absolute -right-2 -top-2 -z-10 h-40 w-28 rounded-lg border border-[#38bdf8]/20 bg-[#1e3a5f]/30" />
                                        <div class="absolute -right-4 -top-4 -z-20 h-40 w-28 rounded-lg border border-[#38bdf8]/10 bg-[#1e3a5f]/20" />
                                    </div>
                                </div>

                                <!-- Stats -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-xs tracking-widest text-slate-500">CPU LOAD</span>
                                        <p class="text-2xl font-bold">12%</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs tracking-widest text-slate-500">MEMORY</span>
                                        <p class="text-2xl font-bold">4.2GB</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Corner accents -->
                            <div class="absolute -left-2 -top-2 h-4 w-4 border-l-2 border-t-2 border-[#38bdf8]" />
                            <div class="absolute -bottom-2 -right-2 h-4 w-4 border-b-2 border-r-2 border-[#38bdf8]" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature badges bar -->
            <div id="features" class="border-y border-[#1e3a5f] bg-[#1e3a5f]/20 py-4">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-6">
                    <div class="flex items-center gap-3 text-[#38bdf8]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span class="text-sm tracking-widest">INSTANT BOOT</span>
                    </div>
                    <div class="h-4 w-px bg-[#1e3a5f]" />
                    <div class="flex items-center gap-3 text-[#38bdf8]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span class="text-sm tracking-widest">DDOS PROTECTED</span>
                    </div>
                    <div class="h-4 w-px bg-[#1e3a5f]" />
                    <div class="flex items-center gap-3 text-[#38bdf8]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm tracking-widest">12 REGIONS</span>
                    </div>
                    <div class="h-4 w-px bg-[#1e3a5f]" />
                    <div class="flex items-center gap-3 text-[#38bdf8]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-sm tracking-widest">AUTO-SCALING</span>
                    </div>
                </div>
            </div>

            <!-- Specs section -->
            <div id="specs" class="mx-auto max-w-7xl px-6 py-16">
                <div class="grid gap-8 md:grid-cols-3">
                    <!-- Spec 1 -->
                    <div class="border-l-2 border-[#38bdf8]/30 pl-6">
                        <span class="text-xs tracking-widest text-[#38bdf8]">SPEC-01 // COMPUTE</span>
                        <h3 class="mb-4 mt-2 text-2xl font-bold tracking-tight">ELASTIC RUNTIME</h3>
                        <p class="text-sm leading-relaxed text-slate-400">
                            Containerized execution environment with micro-VM isolation. Cold starts under 150ms.
                        </p>
                    </div>

                    <!-- Spec 2 -->
                    <div class="border-l-2 border-[#38bdf8]/30 pl-6">
                        <span class="text-xs tracking-widest text-[#38bdf8]">SPEC-02 // STORAGE</span>
                        <h3 class="mb-4 mt-2 text-2xl font-bold tracking-tight">EDGE STORAGE</h3>
                        <p class="text-sm leading-relaxed text-slate-400">
                            Distributed object storage accessible from any compute node with low-latency drivers.
                        </p>
                    </div>

                    <!-- Spec 3 -->
                    <div class="border-l-2 border-[#38bdf8]/30 pl-6">
                        <span class="text-xs tracking-widest text-[#38bdf8]">SPEC-03 // NETWORK</span>
                        <h3 class="mb-4 mt-2 text-2xl font-bold tracking-tight">MESH GRID</h3>
                        <p class="text-sm leading-relaxed text-slate-400">
                            Private encrypted networking between services. Zero-trust architecture by default.
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-[#1e3a5f]/50 py-6">
            <div class="mx-auto max-w-7xl px-6">
                <div class="flex items-center justify-between text-xs tracking-widest text-slate-500">
                    <span>BUILT WITH LARAVEL + INERTIA + VUE</span>
                    <span>PREVIEW ENVIRONMENTS DEMO</span>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
@import url('https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700');

* {
    font-family: 'JetBrains Mono', monospace;
}
</style>
