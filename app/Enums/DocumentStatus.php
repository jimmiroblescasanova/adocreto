<?php 

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum DocumentStatus: int implements HasLabel, HasColor
{
    case INCOMPLETE = 0;
    case PLACED = 1;
    case CANCELLED = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::INCOMPLETE => 'Incompleto',
            self::PLACED => 'Completo',
            self::CANCELLED => 'Cancelado',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::INCOMPLETE => 'danger',
            self::PLACED => 'success',
            self::CANCELLED => 'gray',
        };
    }
}