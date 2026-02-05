<script setup lang="ts">
defineProps<{
    moveCount: number;
}>();

const emit = defineEmits<{
    newGame: [];
}>();
</script>

<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm font-mono">
        <div class="mx-4 w-full max-w-md border border-[#38bdf8]/30 bg-[#0c1929] p-8 text-center shadow-2xl">
            <!-- Corner accents -->
            <div class="absolute -left-2 -top-2 h-4 w-4 border-l-2 border-t-2 border-[#38bdf8]" />
            <div class="absolute -bottom-2 -right-2 h-4 w-4 border-b-2 border-r-2 border-[#38bdf8]" />

            <div class="mb-4 text-6xl">
                <span class="text-red-500">&hearts;</span>
                <span class="text-slate-300">&spades;</span>
                <span class="text-red-500">&diams;</span>
                <span class="text-slate-300">&clubs;</span>
            </div>
            <div class="mb-2 flex items-center justify-center gap-2">
                <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-500" />
                <span class="text-xs tracking-widest text-emerald-400">VICTORY ACHIEVED</span>
            </div>
            <h2 class="mb-6 text-4xl font-bold tracking-tight text-white">YOU WIN!</h2>
            <div class="mb-8 border-l-2 border-[#38bdf8]/50 pl-4 text-left">
                <p class="text-sm text-slate-400">
                    Game completed in <span class="font-bold text-[#38bdf8]">{{ moveCount }}</span> moves.
                </p>
            </div>
            <button
                class="w-full bg-[#38bdf8] px-6 py-4 text-lg font-semibold tracking-wider text-[#0c1929] transition-colors hover:bg-[#7dd3fc]"
                @click="emit('newGame')"
            >
                PLAY AGAIN
            </button>
        </div>
    </div>
</template>
