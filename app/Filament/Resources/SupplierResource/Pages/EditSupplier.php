<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use Filament\Actions;
use App\Traits\EditActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\SupplierResource;

class EditSupplier extends EditRecord
{
    use EditActionsOnTop, RedirectsAfterSave;
    
    protected static string $resource = SupplierResource::class;
}
