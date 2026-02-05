<?php

namespace App\Actions\Solitaire;

use App\DTOs\Card;
use App\DTOs\GameState;
use App\DTOs\Move;
use App\DTOs\MoveLocation;
use App\Enums\GameStatus;
use App\Models\SolitaireGame;
use App\Services\Solitaire\MoveValidator;
use App\Services\Solitaire\WinDetector;
use InvalidArgumentException;

class MakeMoveAction
{
    public function __construct(
        private MoveValidator $moveValidator,
        private WinDetector $winDetector,
    ) {}

    /**
     * @param  list<Card>  $cards
     */
    public function execute(SolitaireGame $game, MoveLocation $from, MoveLocation $to, array $cards): SolitaireGame
    {
        if (! $game->isPlaying()) {
            throw new InvalidArgumentException('Game is not in playing state');
        }

        $state = $game->state;

        if (! $this->moveValidator->canPickUp($state, $from, $cards)) {
            throw new InvalidArgumentException('Cannot pick up these cards');
        }

        if (! $this->moveValidator->isValidMove($state, $from, $to, $cards)) {
            throw new InvalidArgumentException('Invalid move');
        }

        $newState = $this->applyMove($state, $from, $to, $cards);

        $move = new Move($from, $to, $cards);
        $moveHistory = $game->move_history ?? [];
        $moveHistory[] = $move;

        $game->state = $newState;
        $game->move_count = $game->move_count + 1;
        $game->move_history = $moveHistory;

        if ($this->winDetector->isWon($newState)) {
            $game->status = GameStatus::Won;
        }

        $game->save();

        return $game;
    }

    /**
     * @param  list<Card>  $cards
     */
    private function applyMove(GameState $state, MoveLocation $from, MoveLocation $to, array $cards): GameState
    {
        $stock = $state->stock;
        $waste = $state->waste;
        $foundations = $state->foundations;
        $tableaus = $state->tableaus;

        if ($from->isWaste()) {
            array_pop($waste);
        } elseif ($from->isFoundation() && is_string($from->index)) {
            array_pop($foundations[$from->index]);
        } elseif ($from->isTableau() && $from->index !== null) {
            $tableauIndex = (int) $from->index;
            $cardCount = count($cards);
            $tableaus[$tableauIndex] = array_slice($tableaus[$tableauIndex], 0, -$cardCount);

            if (! empty($tableaus[$tableauIndex])) {
                $lastIndex = count($tableaus[$tableauIndex]) - 1;
                $lastCard = $tableaus[$tableauIndex][$lastIndex];
                if (! $lastCard->faceUp) {
                    $tableaus[$tableauIndex][$lastIndex] = $lastCard->withFaceUp(true);
                }
            }
        }

        if ($to->isFoundation() && is_string($to->index)) {
            foreach ($cards as $card) {
                $foundations[$to->index][] = $card->withFaceUp(true);
            }
        } elseif ($to->isFoundation()) {
            $suit = $cards[0]->suit;
            foreach ($cards as $card) {
                $foundations[$suit][] = $card->withFaceUp(true);
            }
        } elseif ($to->isTableau() && $to->index !== null) {
            $tableauIndex = (int) $to->index;
            foreach ($cards as $card) {
                $tableaus[$tableauIndex][] = $card->withFaceUp(true);
            }
        }

        return new GameState(
            stock: $stock,
            waste: $waste,
            foundations: $foundations,
            tableaus: $tableaus,
        );
    }
}
