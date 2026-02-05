<?php

namespace App\Actions\Solitaire;

use App\DTOs\GameState;
use App\Models\SolitaireGame;
use InvalidArgumentException;

class ResetStockAction
{
    public function execute(SolitaireGame $game): SolitaireGame
    {
        if (! $game->isPlaying()) {
            throw new InvalidArgumentException('Game is not in playing state');
        }

        $state = $game->state;

        if (! empty($state->stock)) {
            throw new InvalidArgumentException('Stock is not empty');
        }

        if (empty($state->waste)) {
            throw new InvalidArgumentException('Waste is empty');
        }

        $waste = $state->waste;
        $stock = [];

        while (! empty($waste)) {
            $card = array_pop($waste);
            $card = $card->withFaceUp(false);
            $stock[] = $card;
        }

        $newState = new GameState(
            stock: $stock,
            waste: [],
            foundations: $state->foundations,
            tableaus: $state->tableaus,
        );

        $game->state = $newState;
        $game->save();

        return $game;
    }
}
