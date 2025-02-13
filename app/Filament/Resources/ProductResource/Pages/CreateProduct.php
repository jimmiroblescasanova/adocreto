<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Traits\CreateActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductResource;

class CreateProduct extends CreateRecord
{
    use CreateActionsOnTop, RedirectsAfterSave;
    
    protected static string $resource = ProductResource::class;
}
