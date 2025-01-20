<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum WarehouseType: int implements HasLabel
{
    case GENERAL = 1;
    case SUPPLIES = 2;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::GENERAL => 'General',
            self::SUPPLIES => 'Insumos',
        };
    }
}
