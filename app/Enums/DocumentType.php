<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DocumentType: int implements HasLabel
{
    case InventoryIn = 1;
    case InventoryOut = 2;
    case Transfer = 3;
    case Order = 4;
    case Ticket = 5;
    case Invoice = 6;

    public function getLabel(): string
    {
        return match ($this) {
            self::InventoryIn => 'Entrada',
            self::InventoryOut => 'Salida',
            self::Transfer => 'Traspaso',
            self::Order => 'Cotizacion',
            self::Ticket => 'Ticket',
            self::Invoice => 'Factura',
        };
    }
}
