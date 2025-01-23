<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use Filament\Actions;
use App\Traits\EditActionsOnTop;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ProductionResource;

class EditProduction extends EditRecord
{
    use EditActionsOnTop;
    
    protected static string $resource = ProductionResource::class;

}
