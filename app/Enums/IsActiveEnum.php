<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum IsActiveEnum: int implements HasLabel, HasColor, HasIcon
{
    case YES = 1;
    case NO = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::YES => 'Activo',
            self::NO => 'Inactivo',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::YES => 'success',
            self::NO => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::YES => 'heroicon-m-check',
            self::NO => 'heroicon-m-no-symbol',
        };
    }
}
