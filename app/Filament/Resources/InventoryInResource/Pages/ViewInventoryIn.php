<?php

namespace App\Filament\Resources\InventoryInResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Components\Actions\BackButton;
use App\Filament\Resources\InventoryInResource;

class ViewInventoryIn extends ViewRecord
{
    protected static string $resource = InventoryInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            BackButton::make(),
        ];
    }
}
