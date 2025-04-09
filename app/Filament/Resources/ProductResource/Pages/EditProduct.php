<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Traits\EditActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    use EditActionsOnTop, RedirectsAfterSave;

    protected static string $resource = ProductResource::class;
}
