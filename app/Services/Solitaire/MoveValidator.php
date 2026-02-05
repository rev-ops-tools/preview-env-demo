<?php

namespace App\Services\Solitaire;

use App\DTOs\Card;
use App\DTOs\GameState;
use App\DTOs\MoveLocation;

class MoveValidator
{
    /**
     * Validate if a move is legal according to Klondike rules.
     *
     * @param  list<Card>  $cards
     */
    public function isValidMove(GameState $state, MoveLocation $from, MoveLocation $to, array $cards): bool
    {
        if (empty($cards)) {
            return false;
        }

        if ($to->isFoundation()) {
            return $this->isValidFoundationMove($state, $cards);
        }

        if ($to->isTableau()) {
            return $this->isValidTableauMove($state, $to, $cards);
        }

        return false;
    }

    /**
     * Validate a move to a foundation pile.
     * - Only single cards can move to foundations
     * - Must be same suit
     * - Must be next rank (Ace first, then 2, 3, ... King)
     *
     * @param  list<Card>  $cards
     */
    public function isValidFoundationMove(GameState $state, array $cards): bool
    {
        if (count($cards) !== 1) {
            return false;
        }

        $card = $cards[0];
        $suit = $card->suit;
        $foundation = $state->foundations[$suit];

        if (empty($foundation)) {
            return $card->rank === 1;
        }

        $topCard = $foundation[count($foundation) - 1];

        return $card->rank === $topCard->rank + 1;
    }

    /**
     * Validate a move to a tableau pile.
     * - Empty tableau can only receive a King
     * - Cards must alternate colors
     * - Cards must be in descending order
     *
     * @param  list<Card>  $cards
     */
    public function isValidTableauMove(GameState $state, MoveLocation $to, array $cards): bool
    {
        if (! $to->isTableau() || $to->index === null) {
            return false;
        }

        $tableauIndex = (int) $to->index;
        if ($tableauIndex < 0 || $tableauIndex >= 7) {
            return false;
        }

        $tableau = $state->tableaus[$tableauIndex];
        $movingCard = $cards[0];

        if (empty($tableau)) {
            return $movingCard->rank === 13;
        }

        $topCard = $tableau[count($tableau) - 1];

        return $movingCard->isOppositeColor($topCard) && $movingCard->rank === $topCard->rank - 1;
    }

    /**
     * Check if cards form a valid sequence (alternating colors, descending ranks).
     *
     * @param  list<Card>  $cards
     */
    public function isValidSequence(array $cards): bool
    {
        if (count($cards) <= 1) {
            return true;
        }

        for ($i = 1; $i < count($cards); $i++) {
            $previousCard = $cards[$i - 1];
            $currentCard = $cards[$i];

            if (! $currentCard->isOppositeColor($previousCard)) {
                return false;
            }

            if ($currentCard->rank !== $previousCard->rank - 1) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if cards can be picked up from a location.
     *
     * @param  list<Card>  $cards
     */
    public function canPickUp(GameState $state, MoveLocation $from, array $cards): bool
    {
        if (empty($cards)) {
            return false;
        }

        foreach ($cards as $card) {
            if (! $card->faceUp) {
                return false;
            }
        }

        if ($from->isWaste()) {
            return count($cards) === 1;
        }

        if ($from->isFoundation()) {
            return count($cards) === 1;
        }

        if ($from->isTableau()) {
            return $this->isValidSequence($cards);
        }

        return false;
    }
}
