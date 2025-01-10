<?php

namespace App\Filament\Resources\InventoryInResource\Pages;

use App\Filament\Resources\InventoryInResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventoryIn extends EditRecord
{
    protected static string $resource = InventoryInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
