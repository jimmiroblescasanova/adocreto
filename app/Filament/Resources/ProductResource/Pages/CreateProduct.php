<?php

namespace App\Filament\Resources\ProductResource\Pages;

use Filament\Actions;
use App\Traits\CreateActionsOnTop;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductResource;

class CreateProduct extends CreateRecord
{
    use CreateActionsOnTop;
    
    protected static string $resource = ProductResource::class;
}
