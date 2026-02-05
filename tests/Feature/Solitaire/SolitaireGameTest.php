<?php

use App\Models\SolitaireGame;

test('can create a new game', function () {
    $response = $this->post(route('solitaire.store'));

    $response->assertRedirect();

    $this->assertDatabaseCount('solitaire_games', 1);

    $game = SolitaireGame::first();
    expect($game->status->value)->toBe('playing');
    expect($game->move_count)->toBe(0);
    expect($game->state->stock)->toHaveCount(24);
    expect($game->state->waste)->toHaveCount(0);
    expect($game->state->tableaus)->toHaveCount(7);
});

test('can view a game', function () {
    $game = SolitaireGame::factory()->create();

    $response = $this->get(route('solitaire.show', $game));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->component('Solitaire/Game')
        ->has('game.id')
        ->has('game.status')
        ->has('game.state')
    );
});

test('game redirects to correct ULID URL after creation', function () {
    $response = $this->post(route('solitaire.store'));

    $game = SolitaireGame::first();

    $response->assertRedirect(route('solitaire.show', $game));
});

test('can draw a card from stock', function () {
    $game = SolitaireGame::factory()->create();

    $initialStockCount = count($game->state->stock);

    $response = $this->postJson(route('solitaire.draw', $game));

    $response->assertOk();
    $response->assertJson(['success' => true]);

    $game->refresh();
    expect($game->state->stock)->toHaveCount($initialStockCount - 1);
    expect($game->state->waste)->toHaveCount(1);
});

test('cannot draw from empty stock', function () {
    $game = SolitaireGame::factory()->create();

    while (count($game->state->stock) > 0) {
        $this->postJson(route('solitaire.draw', $game));
        $game->refresh();
    }

    $response = $this->postJson(route('solitaire.draw', $game));

    $response->assertStatus(422);
    $response->assertJson(['success' => false]);
});

test('can reset stock from waste', function () {
    $game = SolitaireGame::factory()->create();

    while (count($game->state->stock) > 0) {
        $this->postJson(route('solitaire.draw', $game));
        $game->refresh();
    }

    $wasteCount = count($game->state->waste);

    $response = $this->postJson(route('solitaire.reset-stock', $game));

    $response->assertOk();
    $response->assertJson(['success' => true]);

    $game->refresh();
    expect($game->state->stock)->toHaveCount($wasteCount);
    expect($game->state->waste)->toHaveCount(0);
});

test('won game shows correct status', function () {
    $game = SolitaireGame::factory()->won()->create();

    $response = $this->get(route('solitaire.show', $game));

    $response->assertOk();
    $response->assertInertia(fn ($page) => $page
        ->where('game.status', 'won')
    );
});
