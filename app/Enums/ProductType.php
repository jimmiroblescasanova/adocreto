<?php 

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProductType: int implements HasLabel
{
    case MATERIAL = 1;
    case PRODUCT = 2;
    case SERVICE = 3;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MATERIAL => 'Insumo',
            self::PRODUCT => 'Producto Terminado',
            self::SERVICE => 'Servicio',
        };
    }
}