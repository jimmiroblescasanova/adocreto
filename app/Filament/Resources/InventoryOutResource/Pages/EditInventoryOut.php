<?php

namespace App\Filament\Resources\InventoryOutResource\Pages;

use Filament\Actions;
use App\Traits\EditActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\InventoryOutResource;

class EditInventoryOut extends EditRecord
{
    use EditActionsOnTop, RedirectsAfterSave;
    
    protected static string $resource = InventoryOutResource::class;
}
