<?php

namespace App\DTOs;

use JsonSerializable;

final readonly class GameState implements JsonSerializable
{
    /**
     * @param  list<Card>  $stock
     * @param  list<Card>  $waste
     * @param  array{hearts: list<Card>, diamonds: list<Card>, clubs: list<Card>, spades: list<Card>}  $foundations
     * @param  array<int, list<Card>>  $tableaus
     */
    public function __construct(
        public array $stock,
        public array $waste,
        public array $foundations,
        public array $tableaus,
    ) {}

    /**
     * @param array{
     *     stock: list<array{suit: string, rank: int, faceUp: bool}>,
     *     waste: list<array{suit: string, rank: int, faceUp: bool}>,
     *     foundations: array{
     *         hearts: list<array{suit: string, rank: int, faceUp: bool}>,
     *         diamonds: list<array{suit: string, rank: int, faceUp: bool}>,
     *         clubs: list<array{suit: string, rank: int, faceUp: bool}>,
     *         spades: list<array{suit: string, rank: int, faceUp: bool}>
     *     },
     *     tableaus: list<list<array{suit: string, rank: int, faceUp: bool}>>
     * } $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            stock: array_map(Card::fromArray(...), $data['stock']),
            waste: array_map(Card::fromArray(...), $data['waste']),
            foundations: [
                'hearts' => array_map(Card::fromArray(...), $data['foundations']['hearts']),
                'diamonds' => array_map(Card::fromArray(...), $data['foundations']['diamonds']),
                'clubs' => array_map(Card::fromArray(...), $data['foundations']['clubs']),
                'spades' => array_map(Card::fromArray(...), $data['foundations']['spades']),
            ],
            tableaus: array_map(
                fn (array $tableau) => array_map(Card::fromArray(...), $tableau),
                $data['tableaus'],
            ),
        );
    }

    /**
     * @return array{
     *     stock: list<array{suit: string, rank: int, faceUp: bool}>,
     *     waste: list<array{suit: string, rank: int, faceUp: bool}>,
     *     foundations: array{
     *         hearts: list<array{suit: string, rank: int, faceUp: bool}>,
     *         diamonds: list<array{suit: string, rank: int, faceUp: bool}>,
     *         clubs: list<array{suit: string, rank: int, faceUp: bool}>,
     *         spades: list<array{suit: string, rank: int, faceUp: bool}>
     *     },
     *     tableaus: list<list<array{suit: string, rank: int, faceUp: bool}>>
     * }
     */
    public function toArray(): array
    {
        return [
            'stock' => array_map(fn (Card $card) => $card->toArray(), $this->stock),
            'waste' => array_map(fn (Card $card) => $card->toArray(), $this->waste),
            'foundations' => [
                'hearts' => array_map(fn (Card $card) => $card->toArray(), $this->foundations['hearts']),
                'diamonds' => array_map(fn (Card $card) => $card->toArray(), $this->foundations['diamonds']),
                'clubs' => array_map(fn (Card $card) => $card->toArray(), $this->foundations['clubs']),
                'spades' => array_map(fn (Card $card) => $card->toArray(), $this->foundations['spades']),
            ],
            'tableaus' => array_map(
                fn (array $tableau) => array_map(fn (Card $card) => $card->toArray(), $tableau),
                $this->tableaus,
            ),
        ];
    }

    /**
     * @return array{
     *     stock: list<array{suit: string, rank: int, faceUp: bool}>,
     *     waste: list<array{suit: string, rank: int, faceUp: bool}>,
     *     foundations: array{
     *         hearts: list<array{suit: string, rank: int, faceUp: bool}>,
     *         diamonds: list<array{suit: string, rank: int, faceUp: bool}>,
     *         clubs: list<array{suit: string, rank: int, faceUp: bool}>,
     *         spades: list<array{suit: string, rank: int, faceUp: bool}>
     *     },
     *     tableaus: list<list<array{suit: string, rank: int, faceUp: bool}>>
     * }
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
