<script setup lang="ts">
import type { Card as CardType, Suit } from '@/types/solitaire';
import { getSuitSymbol, isRedSuit } from '@/types/solitaire';
import { computed } from 'vue';
import Card from './Card.vue';

const props = defineProps<{
    suit: Suit;
    cards: CardType[];
}>();

const emit = defineEmits<{
    drop: [event: DragEvent];
    dragover: [event: DragEvent];
    cardDragStart: [event: DragEvent, card: CardType];
}>();

const topCard = computed(() => (props.cards.length > 0 ? props.cards[props.cards.length - 1] : null));
const suitSymbol = computed(() => getSuitSymbol(props.suit));
const isRed = computed(() => isRedSuit(props.suit));

function handleDragOver(event: DragEvent) {
    event.preventDefault();
    emit('dragover', event);
}

function handleDrop(event: DragEvent) {
    event.preventDefault();
    emit('drop', event);
}

function handleDragStart(event: DragEvent) {
    if (topCard.value) {
        emit('cardDragStart', event, topCard.value);
    }
}
</script>

<template>
    <div
        class="relative h-[100px] w-[70px]"
        @dragover="handleDragOver"
        @drop="handleDrop"
    >
        <div
            v-if="!topCard"
            class="flex h-full w-full items-center justify-center rounded-lg border-2 border-dashed transition-colors"
            :class="isRed ? 'border-red-500/30 bg-red-500/10' : 'border-slate-400/30 bg-slate-400/10'"
        >
            <span class="text-3xl" :class="isRed ? 'text-red-500/40' : 'text-slate-400/40'">
                {{ suitSymbol }}
            </span>
        </div>
        <Card
            v-else
            :card="topCard"
            :face-up="true"
            :draggable="true"
            @dragstart="handleDragStart"
        />
    </div>
</template>
