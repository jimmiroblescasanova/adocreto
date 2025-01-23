<?php 

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum DocumentStatus: string implements HasLabel, HasColor
{
    case INCOMPLETE = 'incomplete';
    case PLACED = 'placed';
    case CANCELLED = 'cancelled';
    case LOCKED = 'locked';

    public function getLabel(): string
    {
        return match ($this) {
            self::INCOMPLETE => 'Incompleto',
            self::PLACED => 'Completo',
            self::CANCELLED => 'Cancelado',
            self::LOCKED => 'Bloqueado',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::INCOMPLETE => 'warning',
            self::PLACED => 'success',
            self::CANCELLED => 'danger',
            self::LOCKED => 'gray',
        };
    }
}