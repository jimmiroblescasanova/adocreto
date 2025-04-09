<?php

namespace App\Filament\Resources\InventoryInResource\Tables;

use Filament\Tables\Grouping\Group;

class TableGroups
{
    public static function groups(): array
    {
        return [
            Group::make('date')
                ->label('Fecha')
                ->date(),

            Group::make('status')
                ->label('Estado'),
        ];
    }
}
