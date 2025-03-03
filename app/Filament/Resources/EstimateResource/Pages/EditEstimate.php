<?php

namespace App\Filament\Resources\EstimateResource\Pages;

use App\Filament\Resources\EstimateResource;
use App\Traits\EditActionsOnTop;
use App\Traits\ManageProductsFromModal;
use App\Traits\RedirectsAfterSave;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEstimate extends EditRecord
{
    use ManageProductsFromModal;
    use EditActionsOnTop;
    use RedirectsAfterSave;

    protected static string $resource = EstimateResource::class;
}
