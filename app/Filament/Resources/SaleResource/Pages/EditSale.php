<?php

namespace App\Filament\Resources\SaleResource\Pages;

use App\Filament\Resources\SaleResource;
use App\Traits\EditActionsOnTop;
use Filament\Resources\Pages\EditRecord;

class EditSale extends EditRecord
{
    use EditActionsOnTop;

    protected static string $resource = SaleResource::class;
}
