<?php

namespace App\Filament\Resources\InventoryOutResource\Pages;

use App\Filament\Components\Actions\BackButton;
use App\Filament\Resources\InventoryOutResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewInventoryOut extends ViewRecord
{
    protected static string $resource = InventoryOutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),

            BackButton::make(),
        ];
    }
}
