<?php

namespace App\Filament\Resources\InventoryOutResource\Pages;

use App\Filament\Resources\InventoryOutResource;
use App\Traits\EditActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\EditRecord;

class EditInventoryOut extends EditRecord
{
    use EditActionsOnTop, RedirectsAfterSave;

    protected static string $resource = InventoryOutResource::class;
}
