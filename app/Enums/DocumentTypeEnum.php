<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DocumentTypeEnum: int implements HasLabel
{
    case InventoryIn = 1;
    case InventoryOut = 2;
    case Order = 3;
    case Ticket = 4;
    case Invoice = 5;

    public function getLabel(): string
    {
        return match ($this) {
            self::InventoryIn => 'Entrada',
            self::InventoryOut => 'Salida',
            self::Order => 'Cotizacion',
            self::Ticket => 'Ticket',
            self::Invoice => 'Factura',
        };
    }
}
