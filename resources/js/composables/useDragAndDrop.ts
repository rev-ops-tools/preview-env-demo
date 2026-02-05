import type { Card, MoveLocation } from '@/types/solitaire';
import { ref } from 'vue';

export interface DragData {
    from: MoveLocation;
    cards: Card[];
}

export function useDragAndDrop() {
    const dragData = ref<DragData | null>(null);

    function startDrag(event: DragEvent, from: MoveLocation, cards: Card[]): void {
        dragData.value = { from, cards };

        if (event.dataTransfer) {
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/plain', JSON.stringify({ from, cards }));
        }
    }

    function getDragData(event: DragEvent): DragData | null {
        if (dragData.value) {
            return dragData.value;
        }

        try {
            const data = event.dataTransfer?.getData('text/plain');
            if (data) {
                return JSON.parse(data) as DragData;
            }
        } catch {
            return null;
        }

        return null;
    }

    function endDrag(): void {
        dragData.value = null;
    }

    return {
        dragData,
        startDrag,
        getDragData,
        endDrag,
    };
}
