<?php

namespace App\DTOs;

use JsonSerializable;

final readonly class Card implements JsonSerializable
{
    public const array SUITS = ['hearts', 'diamonds', 'clubs', 'spades'];

    public const array RED_SUITS = ['hearts', 'diamonds'];

    public const array BLACK_SUITS = ['clubs', 'spades'];

    public function __construct(
        public string $suit,
        public int $rank,
        public bool $faceUp = false,
    ) {}

    public function isRed(): bool
    {
        return in_array($this->suit, self::RED_SUITS, true);
    }

    public function isBlack(): bool
    {
        return in_array($this->suit, self::BLACK_SUITS, true);
    }

    public function isOppositeColor(Card $other): bool
    {
        return $this->isRed() !== $other->isRed();
    }

    public function withFaceUp(bool $faceUp = true): self
    {
        return new self($this->suit, $this->rank, $faceUp);
    }

    /**
     * @param  array{suit: string, rank: int, faceUp: bool}  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            suit: $data['suit'],
            rank: $data['rank'],
            faceUp: $data['faceUp'] ?? false,
        );
    }

    /**
     * @return array{suit: string, rank: int, faceUp: bool}
     */
    public function toArray(): array
    {
        return [
            'suit' => $this->suit,
            'rank' => $this->rank,
            'faceUp' => $this->faceUp,
        ];
    }

    /**
     * @return array{suit: string, rank: int, faceUp: bool}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
