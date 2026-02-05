<script setup lang="ts">
import type { Card as CardType } from '@/types/solitaire';
import { computed } from 'vue';
import CardStack from './CardStack.vue';

const props = defineProps<{
    index: number;
    cards: CardType[];
}>();

const emit = defineEmits<{
    drop: [event: DragEvent];
    cardDragStart: [event: DragEvent, cardIndex: number, cards: CardType[]];
    cardDblClick: [cardIndex: number];
}>();

const firstFaceUpIndex = computed(() => {
    const idx = props.cards.findIndex((card) => card.faceUp);
    return idx >= 0 ? idx : props.cards.length;
});

const stackHeight = computed(() => {
    if (props.cards.length === 0) return 100;
    let height = 100;
    for (let i = 1; i < props.cards.length; i++) {
        height += props.cards[i - 1].faceUp ? 20 : 4;
    }
    return height;
});

function handleDragOver(event: DragEvent) {
    event.preventDefault();
}

function handleDrop(event: DragEvent) {
    event.preventDefault();
    emit('drop', event);
}
</script>

<template>
    <div
        class="relative w-[70px]"
        :style="{ minHeight: `${stackHeight}px` }"
        @dragover="handleDragOver"
        @drop="handleDrop"
    >
        <div
            v-if="cards.length === 0"
            class="flex h-[100px] w-full items-center justify-center rounded-lg border-2 border-dashed border-slate-200 bg-slate-50/30"
        >
            <span class="text-2xl font-bold text-slate-200">K</span>
        </div>
        <CardStack
            v-else
            :cards="cards"
            :location="{ type: 'tableau', index }"
            :draggable-from="firstFaceUpIndex"
            :offset="4"
            :face-up-offset="20"
            @card-drag-start="(event, cardIndex, cards) => emit('cardDragStart', event, cardIndex, cards)"
            @card-dbl-click="(cardIndex) => emit('cardDblClick', cardIndex)"
        />
    </div>
</template>
