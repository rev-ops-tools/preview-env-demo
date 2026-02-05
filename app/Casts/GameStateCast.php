<?php

namespace App\Casts;

use App\DTOs\GameState;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<GameState, GameState>
 */
class GameStateCast implements CastsAttributes
{
    /**
     * @param  string|null  $value
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?GameState
    {
        if ($value === null) {
            return null;
        }

        $data = json_decode($value, true);

        return GameState::fromArray($data);
    }

    /**
     * @param  GameState|array<string, mixed>|null  $value
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof GameState) {
            return json_encode($value->toArray());
        }

        return json_encode($value);
    }
}
