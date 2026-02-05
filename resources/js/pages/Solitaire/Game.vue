<script setup lang="ts">
import GameBoard from '@/components/Solitaire/GameBoard.vue';
import GameControls from '@/components/Solitaire/GameControls.vue';
import WinOverlay from '@/components/Solitaire/WinOverlay.vue';
import { useDragAndDrop } from '@/composables/useDragAndDrop';
import { useGameActions } from '@/composables/useGameActions';
import type { Card, Game, MoveLocation, Suit } from '@/types/solitaire';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps<{
    game: Game;
}>();

const gameState = ref(props.game);
const { startDrag, getDragData, endDrag } = useDragAndDrop();
const { makeMove, drawCard, resetStock, createNewGame, loading } = useGameActions(props.game.id);

const isWon = computed(() => gameState.value.status === 'won');

async function handleDraw() {
    if (loading.value) return;
    const result = await drawCard();
    if (result) {
        gameState.value = result;
    }
}

async function handleResetStock() {
    if (loading.value) return;
    const result = await resetStock();
    if (result) {
        gameState.value = result;
    }
}

function handleWasteDragStart(event: DragEvent, card: Card) {
    startDrag(event, { type: 'waste' }, [card]);
}

function handleFoundationDragStart(suit: Suit, event: DragEvent, card: Card) {
    startDrag(event, { type: 'foundation', index: suit }, [card]);
}

function handleTableauDragStart(tableauIndex: number, event: DragEvent, _cardIndex: number, cards: Card[]) {
    startDrag(event, { type: 'tableau', index: tableauIndex }, cards);
}

async function handleMoveToFoundation(suit: Suit, event: DragEvent) {
    if (loading.value) return;

    const data = getDragData(event);
    endDrag();

    if (!data) return;

    const to: MoveLocation = { type: 'foundation', index: suit };
    const result = await makeMove(data.from, to, data.cards);
    if (result) {
        gameState.value = result;
    }
}

async function handleMoveToTableau(tableauIndex: number, event: DragEvent) {
    if (loading.value) return;

    const data = getDragData(event);
    endDrag();

    if (!data) return;

    const to: MoveLocation = { type: 'tableau', index: tableauIndex };
    const result = await makeMove(data.from, to, data.cards);
    if (result) {
        gameState.value = result;
    }
}

async function tryAutoMoveToFoundation(card: Card, from: MoveLocation) {
    if (loading.value) return;

    const to: MoveLocation = { type: 'foundation', index: card.suit };
    const result = await makeMove(from, to, [card]);
    if (result) {
        gameState.value = result;
    }
}

function handleWasteDoubleClick(card: Card) {
    tryAutoMoveToFoundation(card, { type: 'waste' });
}

function handleTableauDoubleClick(tableauIndex: number, cardIndex: number) {
    const tableau = gameState.value.state.tableaus[tableauIndex];
    if (cardIndex === tableau.length - 1) {
        const card = tableau[cardIndex];
        tryAutoMoveToFoundation(card, { type: 'tableau', index: tableauIndex });
    }
}

function handleNewGame() {
    createNewGame();
}
</script>

<template>
    <Head title="Klondike Solitaire" />
    <div class="min-h-screen bg-slate-50 bg-[radial-gradient(circle,_#e2e8f0_1px,_transparent_1px)] bg-[size:20px_20px]">
        <div class="mx-auto max-w-4xl px-4 py-6">
            <div class="mb-6">
                <GameControls :move-count="gameState.moveCount" :score="gameState.score" @new-game="handleNewGame" />
            </div>
            <div class="rounded-2xl border border-slate-200 bg-white/80 p-6 shadow-lg backdrop-blur">
                <GameBoard
                    :state="gameState.state"
                    @draw="handleDraw"
                    @reset-stock="handleResetStock"
                    @waste-drag-start="handleWasteDragStart"
                    @foundation-drag-start="handleFoundationDragStart"
                    @tableau-drag-start="handleTableauDragStart"
                    @move-to-foundation="handleMoveToFoundation"
                    @move-to-tableau="handleMoveToTableau"
                    @waste-double-click="handleWasteDoubleClick"
                    @tableau-double-click="handleTableauDoubleClick"
                />
            </div>
        </div>
    </div>
    <WinOverlay v-if="isWon" :move-count="gameState.moveCount" @new-game="handleNewGame" />
</template>
