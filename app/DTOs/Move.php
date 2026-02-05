<?php

namespace App\DTOs;

use JsonSerializable;

final readonly class Move implements JsonSerializable
{
    /**
     * @param  list<Card>  $cards
     */
    public function __construct(
        public MoveLocation $from,
        public MoveLocation $to,
        public array $cards,
    ) {}

    /**
     * @param array{
     *     from: array{type: string, index?: int|string|null},
     *     to: array{type: string, index?: int|string|null},
     *     cards: list<array{suit: string, rank: int, faceUp: bool}>
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            from: MoveLocation::fromArray($data['from']),
            to: MoveLocation::fromArray($data['to']),
            cards: array_map(Card::fromArray(...), $data['cards']),
        );
    }

    /**
     * @return array{
     *     from: array{type: string, index: int|string|null},
     *     to: array{type: string, index: int|string|null},
     *     cards: list<array{suit: string, rank: int, faceUp: bool}>
     * }
     */
    public function toArray(): array
    {
        return [
            'from' => $this->from->toArray(),
            'to' => $this->to->toArray(),
            'cards' => array_map(fn (Card $card) => $card->toArray(), $this->cards),
        ];
    }

    /**
     * @return array{
     *     from: array{type: string, index: int|string|null},
     *     to: array{type: string, index: int|string|null},
     *     cards: list<array{suit: string, rank: int, faceUp: bool}>
     * }
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
