<script setup lang="ts">
import type { Card as CardType, GameState, Suit } from '@/types/solitaire';
import Foundation from './Foundation.vue';

defineProps<{
    foundations: GameState['foundations'];
}>();

const emit = defineEmits<{
    drop: [suit: Suit, event: DragEvent];
    cardDragStart: [suit: Suit, event: DragEvent, card: CardType];
}>();

const suits: Suit[] = ['hearts', 'diamonds', 'clubs', 'spades'];
</script>

<template>
    <div class="flex gap-[var(--card-gap,12px)]">
        <Foundation
            v-for="suit in suits"
            :key="suit"
            :suit="suit"
            :cards="foundations[suit]"
            @drop="emit('drop', suit, $event)"
            @card-drag-start="(event, card) => emit('cardDragStart', suit, event, card)"
        />
    </div>
</template>
