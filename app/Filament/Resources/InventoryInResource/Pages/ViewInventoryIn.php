<?php

namespace App\Filament\Resources\InventoryInResource\Pages;

use App\Filament\Resources\InventoryInResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInventoryIn extends ViewRecord
{
    protected static string $resource = InventoryInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
