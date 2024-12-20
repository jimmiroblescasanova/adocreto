<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Traits\EditActionsOnTop;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ProductResource;

class EditProduct extends EditRecord
{
    use EditActionsOnTop;

    protected static string $resource = ProductResource::class;
}
