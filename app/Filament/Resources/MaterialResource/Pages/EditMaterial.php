<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use Filament\Actions;
use App\Traits\EditActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\MaterialResource;

class EditMaterial extends EditRecord
{
    use EditActionsOnTop, RedirectsAfterSave;
    
    protected static string $resource = MaterialResource::class;
}
