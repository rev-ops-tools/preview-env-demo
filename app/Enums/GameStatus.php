<?php

namespace App\Enums;

enum GameStatus: string
{
    case Playing = 'playing';
    case Won = 'won';
    case Abandoned = 'abandoned';
}
