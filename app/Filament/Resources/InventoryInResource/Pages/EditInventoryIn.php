<?php

namespace App\Filament\Resources\InventoryInResource\Pages;

use App\Filament\Resources\InventoryInResource;
use App\Traits\EditActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\EditRecord;

class EditInventoryIn extends EditRecord
{
    use EditActionsOnTop, RedirectsAfterSave;

    protected static string $resource = InventoryInResource::class;
}
