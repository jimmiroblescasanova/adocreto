<?php

namespace App\Filament\Resources\InventoryInResource\Pages;

use Filament\Actions;
use App\Traits\EditActionsOnTop;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\InventoryInResource;

class EditInventoryIn extends EditRecord
{
    use EditActionsOnTop; 

    protected static string $resource = InventoryInResource::class;
}
