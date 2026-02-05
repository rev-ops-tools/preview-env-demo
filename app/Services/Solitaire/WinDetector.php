<?php

namespace App\Services\Solitaire;

use App\DTOs\GameState;

class WinDetector
{
    /**
     * Check if the game has been won.
     * Win condition: All 4 foundations have 13 cards each (Ace through King).
     */
    public function isWon(GameState $state): bool
    {
        foreach ($state->foundations as $foundation) {
            if (count($foundation) !== 13) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the total number of cards in foundations.
     */
    public function getFoundationCardCount(GameState $state): int
    {
        $count = 0;

        foreach ($state->foundations as $foundation) {
            $count += count($foundation);
        }

        return $count;
    }
}
