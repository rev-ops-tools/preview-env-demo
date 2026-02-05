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
            :class="isRed ? 'border-red-200 bg-red-50/30' : 'border-slate-200 bg-slate-50/30'"
        >
            <span class="text-3xl opacity-30" :class="isRed ? 'text-red-300' : 'text-slate-300'">
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
