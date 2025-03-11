<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DocumentType: int implements HasLabel
{
    case InventoryIn = 1;
    case InventoryOut = 2;
    case Estimate = 3;
    case Sale = 4;
    case Invoice = 5;

    public function getLabel(): string
    {
        return match ($this) {
            self::InventoryIn => 'Entrada',
            self::InventoryOut => 'Salida',
            self::Estimate => 'Cotizacion',
            self::Sale => 'Venta',
            self::Invoice => 'Factura',
        };
    }
}
