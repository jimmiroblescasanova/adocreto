<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum DocumentType: int implements HasLabel
{
    case InventoryIn = 1;
    case InventoryOut = 2;
    case Estimate = 3;
    case Order = 4;
    case Sale = 5;
    case Invoice = 6;

    public function getLabel(): string
    {
        return match ($this) {
            self::InventoryIn => 'Entrada',
            self::InventoryOut => 'Salida',
            self::Estimate => 'Cotizacion',
            self::Order => 'Pedido',
            self::Sale => 'Venta',
            self::Invoice => 'Factura',
        };
    }
}
