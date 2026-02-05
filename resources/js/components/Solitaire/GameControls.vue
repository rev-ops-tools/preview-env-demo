<script setup lang="ts">
defineProps<{
    moveCount: number;
    score: number;
    canUndo?: boolean;
}>();

const emit = defineEmits<{
    newGame: [];
    undo: [];
}>();
</script>

<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">KLONDIKE</h1>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <span class="rounded bg-slate-100 px-2 py-1 text-xs font-semibold uppercase tracking-wide text-slate-600">
                    Moves
                </span>
                <span class="text-lg font-bold text-slate-800">{{ moveCount }}</span>
            </div>
            <button
                :disabled="!canUndo"
                class="flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50"
                @click="emit('undo')"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                </svg>
                Undo
            </button>
            <button
                class="flex items-center gap-2 rounded-lg bg-sky-500 px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-sky-600"
                @click="emit('newGame')"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                New Game
            </button>
        </div>
    </div>
</template>
