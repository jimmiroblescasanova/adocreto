<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Filament\Resources\SupplierResource;
use App\Traits\EditActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\EditRecord;

class EditSupplier extends EditRecord
{
    use EditActionsOnTop, RedirectsAfterSave;

    protected static string $resource = SupplierResource::class;
}
