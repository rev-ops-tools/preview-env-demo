<?php

namespace App\Http\Requests\Solitaire;

use App\DTOs\Card;
use App\DTOs\MoveLocation;
use Illuminate\Foundation\Http\FormRequest;

class MakeMoveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'from' => ['required', 'array'],
            'from.type' => ['required', 'string', 'in:stock,waste,foundation,tableau'],
            'from.index' => ['nullable'],
            'to' => ['required', 'array'],
            'to.type' => ['required', 'string', 'in:stock,waste,foundation,tableau'],
            'to.index' => ['nullable'],
            'cards' => ['required', 'array', 'min:1'],
            'cards.*.suit' => ['required', 'string', 'in:hearts,diamonds,clubs,spades'],
            'cards.*.rank' => ['required', 'integer', 'min:1', 'max:13'],
            'cards.*.faceUp' => ['required', 'boolean'],
        ];
    }

    public function getFromLocation(): MoveLocation
    {
        return MoveLocation::fromArray($this->validated('from'));
    }

    public function getToLocation(): MoveLocation
    {
        return MoveLocation::fromArray($this->validated('to'));
    }

    /**
     * @return list<Card>
     */
    public function getCards(): array
    {
        return array_map(Card::fromArray(...), $this->validated('cards'));
    }
}
