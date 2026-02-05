<script setup lang="ts">
defineProps<{
    moveCount: number;
    score: number;
}>();

const emit = defineEmits<{
    newGame: [];
}>();
</script>

<template>
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center justify-between sm:justify-start sm:gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xl sm:text-2xl">
                    <span class="text-red-500">&hearts;</span>
                    <span class="text-[#38bdf8]">&spades;</span>
                </span>
                <h1 class="text-lg font-bold tracking-wider text-white sm:text-xl">KLONDIKE</h1>
            </div>
            <button
                class="flex items-center gap-1.5 bg-[#38bdf8] px-3 py-1.5 text-xs font-semibold tracking-wider text-[#0c1929] transition-colors hover:bg-[#7dd3fc] sm:hidden"
                @click="emit('newGame')"
            >
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                NEW
            </button>
        </div>
        <div class="flex items-center justify-center gap-4 sm:gap-6">
            <div class="flex items-center gap-1.5 sm:gap-2">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-slate-500 sm:text-xs">Moves</span>
                <span class="text-base font-bold tabular-nums text-white sm:text-lg">{{ moveCount }}</span>
            </div>
            <div class="flex items-center gap-1.5 sm:gap-2">
                <span class="text-[10px] font-semibold uppercase tracking-widest text-slate-500 sm:text-xs">Score</span>
                <span class="text-base font-bold tabular-nums text-white sm:text-lg">{{ score }}</span>
            </div>
            <button
                class="hidden items-center gap-2 bg-[#38bdf8] px-4 py-2 text-sm font-semibold tracking-wider text-[#0c1929] transition-colors hover:bg-[#7dd3fc] sm:flex"
                @click="emit('newGame')"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                NEW GAME
            </button>
        </div>
    </div>
</template>
