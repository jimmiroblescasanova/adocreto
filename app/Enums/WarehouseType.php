<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum WarehouseType: int implements HasLabel
{
    case General = 1;
    case Supplies = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::General => 'General',
            self::Supplies => 'Materias primas',
        };
    }
}
