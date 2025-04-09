<?php

namespace App\Filament\Resources\InventoryOutResource\Pages;

use App\Filament\Resources\InventoryOutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventoryOuts extends ListRecords
{
    protected static string $resource = InventoryOutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
