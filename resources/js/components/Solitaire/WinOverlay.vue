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
        <div class="relative mx-4 w-full max-w-md border border-[#38bdf8]/30 bg-[#0c1929] p-6 text-center shadow-2xl sm:p-8">
            <!-- Corner accents -->
            <div class="absolute -left-2 -top-2 h-4 w-4 border-l-2 border-t-2 border-[#38bdf8]" />
            <div class="absolute -bottom-2 -right-2 h-4 w-4 border-b-2 border-r-2 border-[#38bdf8]" />

            <div class="mb-4 text-4xl sm:text-6xl">
                <span class="text-red-500">&hearts;</span>
                <span class="text-slate-300">&spades;</span>
                <span class="text-red-500">&diams;</span>
                <span class="text-slate-300">&clubs;</span>
            </div>
            <div class="mb-2 flex items-center justify-center gap-2">
                <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-500" />
                <span class="text-[10px] tracking-widest text-emerald-400 sm:text-xs">VICTORY ACHIEVED</span>
            </div>
            <h2 class="mb-4 text-2xl font-bold tracking-tight text-white sm:mb-6 sm:text-4xl">YOU WIN!</h2>
            <div class="mb-6 border-l-2 border-[#38bdf8]/50 pl-4 text-left sm:mb-8">
                <p class="text-xs text-slate-400 sm:text-sm">
                    Game completed in <span class="font-bold text-[#38bdf8]">{{ moveCount }}</span> moves.
                </p>
            </div>
            <button
                class="w-full bg-[#38bdf8] px-4 py-3 text-base font-semibold tracking-wider text-[#0c1929] transition-colors hover:bg-[#7dd3fc] sm:px-6 sm:py-4 sm:text-lg"
                @click="emit('newGame')"
            >
                PLAY AGAIN
            </button>
        </div>
    </div>
</template>
