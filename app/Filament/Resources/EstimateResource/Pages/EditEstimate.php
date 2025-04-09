<?php

namespace App\Filament\Resources\EstimateResource\Pages;

use App\Filament\Resources\EstimateResource;
use App\Traits\EditActionsOnTop;
use App\Traits\ManageProductsFromModal;
use Filament\Resources\Pages\EditRecord;

class EditEstimate extends EditRecord
{
    use EditActionsOnTop;
    use ManageProductsFromModal;

    protected static string $resource = EstimateResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('print', ['record' => $this->record]);
    }
}
