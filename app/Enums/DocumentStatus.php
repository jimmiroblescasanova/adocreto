<?php 

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum DocumentStatus: int implements HasLabel, HasColor
{
    case CANCELLED = -1;
    case INCOMPLETE = 0;
    case PLACED = 1;

    public function getLabel(): string
    {
        return match ($this) {
            self::PLACED => 'Completo',
            self::CANCELLED => 'Cancelado',
            self::INCOMPLETE => 'Incompleto',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PLACED => 'success',
            self::CANCELLED => 'gray',
            self::INCOMPLETE => 'warning',
        };
    }
}