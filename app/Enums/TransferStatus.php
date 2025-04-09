<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TransferStatus: string implements HasColor, HasIcon, HasLabel
{
    case Pending = 'pending';
    case InRoute = 'in_route';
    case Delivered = 'delivered';
    case Rejected = 'rejected';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::InRoute => 'En ruta',
            self::Delivered => 'Entregado',
            self::Rejected => 'Rechazado',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Pending => 'heroicon-m-clock',
            self::InRoute => 'heroicon-m-truck',
            self::Delivered => 'heroicon-m-check',
            self::Rejected => 'heroicon-m-x-circle',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => 'warning',
            self::InRoute => 'info',
            self::Delivered => 'success',
            self::Rejected => 'danger',
        };
    }
}
