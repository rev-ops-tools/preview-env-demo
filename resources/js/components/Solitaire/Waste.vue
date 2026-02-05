<script setup lang="ts">
import type { Card as CardType } from '@/types/solitaire';
import Card from './Card.vue';

const props = defineProps<{
    cards: CardType[];
}>();

const emit = defineEmits<{
    cardDragStart: [event: DragEvent, card: CardType];
    cardDblClick: [card: CardType];
}>();

function handleDragStart(event: DragEvent) {
    const topCard = props.cards[props.cards.length - 1];
    if (topCard) {
        emit('cardDragStart', event, topCard);
    }
}

function handleDblClick() {
    const topCard = props.cards[props.cards.length - 1];
    if (topCard) {
        emit('cardDblClick', topCard);
    }
}
</script>

<template>
    <div class="relative h-[100px] w-[70px]">
        <div
            v-if="cards.length === 0"
            class="flex h-full w-full items-center justify-center rounded-lg border-2 border-dashed border-slate-200 bg-slate-50/50"
        />
        <div v-else class="relative">
            <div
                v-for="(card, index) in cards.slice(-3)"
                :key="`${card.suit}-${card.rank}`"
                class="absolute"
                :style="{ left: `${index * 12}px` }"
            >
                <Card
                    :card="card"
                    :face-up="true"
                    :draggable="index === cards.slice(-3).length - 1"
                    @dragstart="handleDragStart"
                    @dblclick="handleDblClick"
                />
            </div>
        </div>
    </div>
</template>
