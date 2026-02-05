<?php

namespace App\Casts;

use App\DTOs\Move;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements CastsAttributes<list<Move>, list<Move>>
 */
class MoveHistoryCast implements CastsAttributes
{
    /**
     * @param  string|null  $value
     * @param  array<string, mixed>  $attributes
     * @return list<Move>|null
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?array
    {
        if ($value === null) {
            return null;
        }

        $data = json_decode($value, true);

        return array_map(Move::fromArray(...), $data);
    }

    /**
     * @param  list<Move>|list<array<string, mixed>>|null  $value
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): ?string
    {
        if ($value === null) {
            return null;
        }

        $data = array_map(function ($move) {
            if ($move instanceof Move) {
                return $move->toArray();
            }

            return $move;
        }, $value);

        return json_encode($data);
    }
}
