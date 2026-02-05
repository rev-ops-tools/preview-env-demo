<?php

use App\DTOs\Card;
use App\DTOs\GameState;
use App\DTOs\MoveLocation;
use App\Services\Solitaire\MoveValidator;

beforeEach(function () {
    $this->validator = new MoveValidator;
});

function createEmptyState(): GameState
{
    return new GameState(
        stock: [],
        waste: [],
        foundations: [
            'hearts' => [],
            'diamonds' => [],
            'clubs' => [],
            'spades' => [],
        ],
        tableaus: [[], [], [], [], [], [], []],
    );
}

test('ace can be moved to empty foundation', function () {
    $state = createEmptyState();
    $card = new Card(suit: 'hearts', rank: 1, faceUp: true);

    $isValid = $this->validator->isValidFoundationMove($state, [$card]);

    expect($isValid)->toBeTrue();
});

test('non-ace cannot be moved to empty foundation', function () {
    $state = createEmptyState();
    $card = new Card(suit: 'hearts', rank: 2, faceUp: true);

    $isValid = $this->validator->isValidFoundationMove($state, [$card]);

    expect($isValid)->toBeFalse();
});

test('card can be moved to foundation if next rank', function () {
    $state = new GameState(
        stock: [],
        waste: [],
        foundations: [
            'hearts' => [new Card(suit: 'hearts', rank: 1, faceUp: true)],
            'diamonds' => [],
            'clubs' => [],
            'spades' => [],
        ],
        tableaus: [[], [], [], [], [], [], []],
    );
    $card = new Card(suit: 'hearts', rank: 2, faceUp: true);

    $isValid = $this->validator->isValidFoundationMove($state, [$card]);

    expect($isValid)->toBeTrue();
});

test('card cannot skip ranks on foundation', function () {
    $state = new GameState(
        stock: [],
        waste: [],
        foundations: [
            'hearts' => [new Card(suit: 'hearts', rank: 1, faceUp: true)],
            'diamonds' => [],
            'clubs' => [],
            'spades' => [],
        ],
        tableaus: [[], [], [], [], [], [], []],
    );
    $card = new Card(suit: 'hearts', rank: 3, faceUp: true);

    $isValid = $this->validator->isValidFoundationMove($state, [$card]);

    expect($isValid)->toBeFalse();
});

test('only single card can move to foundation', function () {
    $state = createEmptyState();
    $cards = [
        new Card(suit: 'hearts', rank: 1, faceUp: true),
        new Card(suit: 'hearts', rank: 2, faceUp: true),
    ];

    $isValid = $this->validator->isValidFoundationMove($state, $cards);

    expect($isValid)->toBeFalse();
});

test('king can be moved to empty tableau', function () {
    $state = createEmptyState();
    $card = new Card(suit: 'hearts', rank: 13, faceUp: true);
    $to = new MoveLocation(type: 'tableau', index: 0);

    $isValid = $this->validator->isValidTableauMove($state, $to, [$card]);

    expect($isValid)->toBeTrue();
});

test('non-king cannot be moved to empty tableau', function () {
    $state = createEmptyState();
    $card = new Card(suit: 'hearts', rank: 12, faceUp: true);
    $to = new MoveLocation(type: 'tableau', index: 0);

    $isValid = $this->validator->isValidTableauMove($state, $to, [$card]);

    expect($isValid)->toBeFalse();
});

test('card can be moved to tableau if opposite color and one rank lower', function () {
    $state = new GameState(
        stock: [],
        waste: [],
        foundations: [
            'hearts' => [],
            'diamonds' => [],
            'clubs' => [],
            'spades' => [],
        ],
        tableaus: [
            [new Card(suit: 'hearts', rank: 7, faceUp: true)],
            [], [], [], [], [], [],
        ],
    );
    $card = new Card(suit: 'spades', rank: 6, faceUp: true);
    $to = new MoveLocation(type: 'tableau', index: 0);

    $isValid = $this->validator->isValidTableauMove($state, $to, [$card]);

    expect($isValid)->toBeTrue();
});

test('card cannot be moved to tableau if same color', function () {
    $state = new GameState(
        stock: [],
        waste: [],
        foundations: [
            'hearts' => [],
            'diamonds' => [],
            'clubs' => [],
            'spades' => [],
        ],
        tableaus: [
            [new Card(suit: 'hearts', rank: 7, faceUp: true)],
            [], [], [], [], [], [],
        ],
    );
    $card = new Card(suit: 'diamonds', rank: 6, faceUp: true);
    $to = new MoveLocation(type: 'tableau', index: 0);

    $isValid = $this->validator->isValidTableauMove($state, $to, [$card]);

    expect($isValid)->toBeFalse();
});

test('card cannot be moved to tableau if not one rank lower', function () {
    $state = new GameState(
        stock: [],
        waste: [],
        foundations: [
            'hearts' => [],
            'diamonds' => [],
            'clubs' => [],
            'spades' => [],
        ],
        tableaus: [
            [new Card(suit: 'hearts', rank: 7, faceUp: true)],
            [], [], [], [], [], [],
        ],
    );
    $card = new Card(suit: 'spades', rank: 5, faceUp: true);
    $to = new MoveLocation(type: 'tableau', index: 0);

    $isValid = $this->validator->isValidTableauMove($state, $to, [$card]);

    expect($isValid)->toBeFalse();
});

test('valid sequence is recognized', function () {
    $cards = [
        new Card(suit: 'hearts', rank: 7, faceUp: true),
        new Card(suit: 'spades', rank: 6, faceUp: true),
        new Card(suit: 'diamonds', rank: 5, faceUp: true),
    ];

    $isValid = $this->validator->isValidSequence($cards);

    expect($isValid)->toBeTrue();
});

test('invalid sequence with same color is rejected', function () {
    $cards = [
        new Card(suit: 'hearts', rank: 7, faceUp: true),
        new Card(suit: 'diamonds', rank: 6, faceUp: true),
    ];

    $isValid = $this->validator->isValidSequence($cards);

    expect($isValid)->toBeFalse();
});

test('invalid sequence with wrong ranks is rejected', function () {
    $cards = [
        new Card(suit: 'hearts', rank: 7, faceUp: true),
        new Card(suit: 'spades', rank: 5, faceUp: true),
    ];

    $isValid = $this->validator->isValidSequence($cards);

    expect($isValid)->toBeFalse();
});

test('cannot pick up face down cards', function () {
    $state = createEmptyState();
    $cards = [new Card(suit: 'hearts', rank: 7, faceUp: false)];
    $from = new MoveLocation(type: 'tableau', index: 0);

    $canPickUp = $this->validator->canPickUp($state, $from, $cards);

    expect($canPickUp)->toBeFalse();
});

test('can pick up single card from waste', function () {
    $state = createEmptyState();
    $cards = [new Card(suit: 'hearts', rank: 7, faceUp: true)];
    $from = new MoveLocation(type: 'waste');

    $canPickUp = $this->validator->canPickUp($state, $from, $cards);

    expect($canPickUp)->toBeTrue();
});

test('cannot pick up multiple cards from waste', function () {
    $state = createEmptyState();
    $cards = [
        new Card(suit: 'hearts', rank: 7, faceUp: true),
        new Card(suit: 'spades', rank: 6, faceUp: true),
    ];
    $from = new MoveLocation(type: 'waste');

    $canPickUp = $this->validator->canPickUp($state, $from, $cards);

    expect($canPickUp)->toBeFalse();
});
