<?php

namespace App\Services\Solitaire;

use App\DTOs\Card;

class DeckService
{
    /**
     * Create a standard 52-card deck.
     *
     * @return list<Card>
     */
    public function createDeck(): array
    {
        $deck = [];

        foreach (Card::SUITS as $suit) {
            for ($rank = 1; $rank <= 13; $rank++) {
                $deck[] = new Card(suit: $suit, rank: $rank, faceUp: false);
            }
        }

        return $deck;
    }

    /**
     * Shuffle the deck using Fisher-Yates algorithm.
     *
     * @param  list<Card>  $deck
     * @return list<Card>
     */
    public function shuffle(array $deck): array
    {
        $count = count($deck);

        for ($i = $count - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            [$deck[$i], $deck[$j]] = [$deck[$j], $deck[$i]];
        }

        return $deck;
    }

    /**
     * Create a shuffled deck ready for a new game.
     *
     * @return list<Card>
     */
    public function createShuffledDeck(): array
    {
        return $this->shuffle($this->createDeck());
    }
}
