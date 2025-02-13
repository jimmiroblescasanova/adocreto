<?php 

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum DocumentStatus: string implements HasLabel, HasColor
{
    case Incomplete = 'incomplete';
    case Placed = 'placed';
    case Cancelled = 'cancelled';
    case Locked = 'locked';

    public function getLabel(): string
    {
        return match ($this) {
            self::Incomplete => 'Incompleto',
            self::Placed => 'Completo',
            self::Cancelled => 'Cancelado',
            self::Locked => 'Bloqueado',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Incomplete => 'warning',
            self::Placed => 'success',
            self::Cancelled => 'danger',
            self::Locked => 'gray',
        };
    }
}