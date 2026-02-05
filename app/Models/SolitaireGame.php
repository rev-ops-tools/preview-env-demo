<?php

namespace App\Models;

use App\Casts\GameStateCast;
use App\Casts\MoveHistoryCast;
use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolitaireGame extends Model
{
    use HasFactory, HasUlids;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'status',
        'move_count',
        'score',
        'elapsed_seconds',
        'state',
        'move_history',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => GameStatus::class,
            'move_count' => 'integer',
            'score' => 'integer',
            'elapsed_seconds' => 'integer',
            'state' => GameStateCast::class,
            'move_history' => MoveHistoryCast::class,
        ];
    }

    public function isWon(): bool
    {
        return $this->status === GameStatus::Won;
    }

    public function isPlaying(): bool
    {
        return $this->status === GameStatus::Playing;
    }
}
