<script setup lang="ts">
import type { Card } from '@/types/solitaire';
import { getRankDisplay, getSuitSymbol, isRedSuit } from '@/types/solitaire';
import { computed } from 'vue';

const props = withDefaults(
    defineProps<{
        card?: Card | null;
        faceUp?: boolean;
        draggable?: boolean;
        selected?: boolean;
    }>(),
    {
        card: null,
        faceUp: false,
        draggable: false,
        selected: false,
    },
);

const emit = defineEmits<{
    dragstart: [event: DragEvent];
    click: [];
    dblclick: [];
}>();

const isRed = computed(() => props.card && isRedSuit(props.card.suit));
const rankDisplay = computed(() => (props.card ? getRankDisplay(props.card.rank) : ''));
const suitSymbol = computed(() => (props.card ? getSuitSymbol(props.card.suit) : ''));
const showFace = computed(() => props.card && (props.card.faceUp || props.faceUp));

function handleDragStart(event: DragEvent) {
    if (props.draggable && showFace.value) {
        emit('dragstart', event);
    }
}
</script>

<template>
    <div
        class="flex h-[100px] w-[70px] select-none flex-col rounded-lg border shadow-lg transition-all duration-150"
        :class="[
            showFace
                ? 'cursor-pointer border-slate-300 bg-white hover:shadow-xl'
                : 'cursor-default border-[#38bdf8]/50 bg-gradient-to-br from-[#1e3a5f] to-[#0c1929]',
            selected ? 'ring-2 ring-[#38bdf8] ring-offset-2 ring-offset-[#0c1929]' : '',
            draggable && showFace ? 'cursor-grab active:cursor-grabbing' : '',
        ]"
        :draggable="draggable && showFace"
        @dragstart="handleDragStart"
        @click="emit('click')"
        @dblclick="emit('dblclick')"
    >
        <template v-if="showFace && card">
            <div class="flex flex-1 flex-col p-1.5" :class="isRed ? 'text-red-600' : 'text-slate-800'">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold leading-none">{{ rankDisplay }}</span>
                    <span class="text-base leading-none">{{ suitSymbol }}</span>
                </div>
                <div class="flex flex-1 items-center justify-center">
                    <span class="text-3xl">{{ suitSymbol }}</span>
                </div>
                <div class="flex rotate-180 items-center justify-between">
                    <span class="text-sm font-bold leading-none">{{ rankDisplay }}</span>
                    <span class="text-base leading-none">{{ suitSymbol }}</span>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="flex h-full items-center justify-center">
                <div class="flex flex-col items-center gap-1">
                    <div class="h-1 w-10 rounded bg-[#38bdf8]/30" />
                    <div class="h-1 w-8 rounded bg-[#38bdf8]/30" />
                    <div class="h-1 w-10 rounded bg-[#38bdf8]/30" />
                </div>
            </div>
        </template>
    </div>
</template>
