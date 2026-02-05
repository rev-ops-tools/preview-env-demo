<?php

namespace App\Actions\Solitaire;

use App\DTOs\Card;
use App\DTOs\GameState;
use App\Enums\GameStatus;
use App\Models\SolitaireGame;
use App\Services\Solitaire\DeckService;

class CreateGameAction
{
    public function __construct(
        private DeckService $deckService,
    ) {}

    public function execute(): SolitaireGame
    {
        $deck = $this->deckService->createShuffledDeck();
        $state = $this->dealCards($deck);

        return SolitaireGame::create([
            'status' => GameStatus::Playing,
            'move_count' => 0,
            'score' => 0,
            'elapsed_seconds' => 0,
            'state' => $state,
            'move_history' => [],
        ]);
    }

    /**
     * Deal cards into initial Klondike layout.
     *
     * @param  list<Card>  $deck
     */
    private function dealCards(array $deck): GameState
    {
        $tableaus = [[], [], [], [], [], [], []];
        $cardIndex = 0;

        for ($col = 0; $col < 7; $col++) {
            for ($row = $col; $row < 7; $row++) {
                $card = $deck[$cardIndex++];

                if ($row === $col) {
                    $card = $card->withFaceUp(true);
                }

                $tableaus[$row][] = $card;
            }
        }

        $stock = array_slice($deck, $cardIndex);

        return new GameState(
            stock: $stock,
            waste: [],
            foundations: [
                'hearts' => [],
                'diamonds' => [],
                'clubs' => [],
                'spades' => [],
            ],
            tableaus: $tableaus,
        );
    }
}
