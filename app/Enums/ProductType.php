<?php 

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProductType: int implements HasLabel
{
    case MATERIAL = 1;
    case PRODUCT = 2;
    case SERVICE = 3;
    case FINISHED_PRODUCT = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::MATERIAL => 'Insumo',
            self::PRODUCT => 'Producto',
            self::SERVICE => 'Servicio',
            self::FINISHED_PRODUCT => 'Producto compuesto',
        };
    }

    public static function getOptions(): array
    {
        return [
            self::PRODUCT->value => self::PRODUCT->getLabel(),
            self::SERVICE->value => self::SERVICE->getLabel(),
            self::FINISHED_PRODUCT->value => self::FINISHED_PRODUCT->getLabel(),
        ];
    }
}