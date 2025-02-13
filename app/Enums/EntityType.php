<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum EntityType: int implements HasLabel
{
    case Client = 1;
    case Supplier = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::Client => 'Cliente',
            self::Supplier => 'Proveedor',
        };
    }
}
