<?php

namespace App\Filament\Resources\InventoryOutResource\Pages;

use Filament\Actions;
use App\Traits\EditActionsOnTop;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\InventoryOutResource;

class EditInventoryOut extends EditRecord
{
    use EditActionsOnTop;
    
    protected static string $resource = InventoryOutResource::class;
}
