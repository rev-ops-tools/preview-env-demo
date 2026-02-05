<script setup lang="ts">
import type { Card as CardType, MoveLocation } from '@/types/solitaire';
import Card from './Card.vue';

const props = withDefaults(
    defineProps<{
        cards: CardType[];
        offset?: number;
        faceUpOffset?: number;
        location: MoveLocation;
        draggableFrom?: number;
    }>(),
    {
        offset: 4,
        faceUpOffset: 20,
        draggableFrom: -1,
    },
);

const emit = defineEmits<{
    cardDragStart: [event: DragEvent, cardIndex: number, cards: CardType[]];
    cardClick: [cardIndex: number];
    cardDblClick: [cardIndex: number];
}>();

function getOffset(index: number): number {
    if (index === 0) return 0;
    const prevCard = props.cards[index - 1];
    return prevCard?.faceUp ? props.faceUpOffset : props.offset;
}

function isDraggable(index: number): boolean {
    if (props.draggableFrom < 0) return false;
    return index >= props.draggableFrom && props.cards[index]?.faceUp;
}

function handleDragStart(event: DragEvent, cardIndex: number) {
    const cards = props.cards.slice(cardIndex);
    emit('cardDragStart', event, cardIndex, cards);
}
</script>

<template>
    <div class="relative">
        <div
            v-for="(card, index) in cards"
            :key="`${card.suit}-${card.rank}-${index}`"
            class="absolute left-0"
            :style="{ top: `${cards.slice(0, index).reduce((acc, _, i) => acc + getOffset(i + 1), 0)}px` }"
        >
            <Card
                :card="card"
                :draggable="isDraggable(index)"
                @dragstart="handleDragStart($event, index)"
                @click="emit('cardClick', index)"
                @dblclick="emit('cardDblClick', index)"
            />
        </div>
    </div>
</template>
