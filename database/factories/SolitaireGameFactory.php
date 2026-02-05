<?php

namespace Database\Factories;

use App\DTOs\Card;
use App\DTOs\GameState;
use App\Enums\GameStatus;
use App\Models\SolitaireGame;
use App\Services\Solitaire\DeckService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SolitaireGame>
 */
class SolitaireGameFactory extends Factory
{
    protected $model = SolitaireGame::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $deckService = new DeckService;
        $deck = $deckService->createShuffledDeck();

        return [
            'status' => GameStatus::Playing,
            'move_count' => 0,
            'score' => 0,
            'elapsed_seconds' => 0,
            'state' => $this->dealCards($deck),
            'move_history' => [],
        ];
    }

    public function won(): static
    {
        return $this->state(function (array $attributes) {
            $foundations = [];
            foreach (Card::SUITS as $suit) {
                $cards = [];
                for ($rank = 1; $rank <= 13; $rank++) {
                    $cards[] = new Card(suit: $suit, rank: $rank, faceUp: true);
                }
                $foundations[$suit] = $cards;
            }

            return [
                'status' => GameStatus::Won,
                'state' => new GameState(
                    stock: [],
                    waste: [],
                    foundations: $foundations,
                    tableaus: [[], [], [], [], [], [], []],
                ),
            ];
        });
    }

    public function abandoned(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => GameStatus::Abandoned,
        ]);
    }

    /**
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
