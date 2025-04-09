<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ProductType: int implements HasLabel
{
    case Material = 1;
    case Product = 2;
    case Service = 3;
    case FinishedProduct = 4;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Material => 'Materia prima',
            self::Product => 'Producto',
            self::Service => 'Servicio',
            self::FinishedProduct => 'Producto compuesto',
        };
    }

    public static function getOptions(): array
    {
        return [
            self::Product->value => self::Product->getLabel(),
            self::Service->value => self::Service->getLabel(),
            self::FinishedProduct->value => self::FinishedProduct->getLabel(),
        ];
    }
}
