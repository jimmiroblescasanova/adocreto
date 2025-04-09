<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use App\Filament\Resources\ProductionResource;
use App\Traits\EditActionsOnTop;
use Filament\Resources\Pages\EditRecord;

class EditProduction extends EditRecord
{
    use EditActionsOnTop;

    protected static string $resource = ProductionResource::class;
}
