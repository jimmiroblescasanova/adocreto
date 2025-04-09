<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum IsActive: int implements HasColor, HasIcon, HasLabel
{
    case Yes = 1;
    case No = 0;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Yes => 'Activo',
            self::No => 'Inactivo',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Yes => 'success',
            self::No => 'gray',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Yes => 'heroicon-m-check',
            self::No => 'heroicon-m-no-symbol',
        };
    }
}
