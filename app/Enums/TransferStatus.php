<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TransferStatus: string implements HasLabel
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'Pendiente',
            self::ACCEPTED => 'Aceptado',
            self::REJECTED => 'Rechazado',
        };
    }
}
