<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Filament\Resources\MaterialResource;
use App\Traits\EditActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\EditRecord;

class EditMaterial extends EditRecord
{
    use EditActionsOnTop, RedirectsAfterSave;

    protected static string $resource = MaterialResource::class;
}
