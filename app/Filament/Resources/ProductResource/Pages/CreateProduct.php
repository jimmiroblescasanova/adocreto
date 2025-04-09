<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Traits\CreateActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    use CreateActionsOnTop, RedirectsAfterSave;

    protected static string $resource = ProductResource::class;
}
