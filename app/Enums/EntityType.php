<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EntityType: int implements HasLabel
{
    case CLIENT = 1;
    case PROVIDER = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::CLIENT => 'Cliente',
            self::PROVIDER => 'Proveedor',
        };
    }
}
