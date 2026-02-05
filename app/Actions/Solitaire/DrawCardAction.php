<?php

namespace App\Actions\Solitaire;

use App\DTOs\GameState;
use App\Models\SolitaireGame;
use InvalidArgumentException;

class DrawCardAction
{
    public function execute(SolitaireGame $game): SolitaireGame
    {
        if (! $game->isPlaying()) {
            throw new InvalidArgumentException('Game is not in playing state');
        }

        $state = $game->state;

        if (empty($state->stock)) {
            throw new InvalidArgumentException('Stock is empty');
        }

        $stock = $state->stock;
        $waste = $state->waste;

        $card = array_pop($stock);
        $card = $card->withFaceUp(true);
        $waste[] = $card;

        $newState = new GameState(
            stock: $stock,
            waste: $waste,
            foundations: $state->foundations,
            tableaus: $state->tableaus,
        );

        $game->state = $newState;
        $game->save();

        return $game;
    }
}
