<script setup lang="ts">
defineProps<{
    moveCount: number;
}>();

const emit = defineEmits<{
    newGame: [];
}>();
</script>

<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="mx-4 w-full max-w-md rounded-2xl bg-white p-8 text-center shadow-2xl">
            <div class="mb-4 text-6xl">
                <span class="text-red-500">&hearts;</span>
                <span class="text-slate-800">&spades;</span>
                <span class="text-red-500">&diams;</span>
                <span class="text-slate-800">&clubs;</span>
            </div>
            <h2 class="mb-2 text-3xl font-bold tracking-tight text-slate-900">YOU WIN!</h2>
            <p class="mb-6 text-lg text-slate-600">
                Congratulations! You completed the game in
                <span class="font-semibold text-sky-600">{{ moveCount }}</span> moves.
            </p>
            <button
                class="w-full rounded-lg bg-sky-500 px-6 py-3 text-lg font-semibold text-white transition-colors hover:bg-sky-600"
                @click="emit('newGame')"
            >
                Play Again
            </button>
        </div>
    </div>
</template>
