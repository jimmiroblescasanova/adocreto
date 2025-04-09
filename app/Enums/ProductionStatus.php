<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum ProductionStatus: string implements HasColor, HasIcon, HasLabel
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'Pendiente',
            self::InProgress => 'En proceso',
            self::Completed => 'Completada',
            self::Cancelled => 'Cancelada',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::InProgress => 'info',
            self::Completed => 'success',
            self::Cancelled => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Pending => 'heroicon-m-clock',
            self::InProgress => 'heroicon-m-arrow-path',
            self::Completed => 'heroicon-m-check-circle',
            self::Cancelled => 'heroicon-m-x-circle',
        };
    }
}
