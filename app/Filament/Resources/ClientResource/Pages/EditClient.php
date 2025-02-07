<?php

namespace App\Filament\Resources\ClientResource\Pages;

use Filament\Actions;
use App\Traits\EditActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\ClientResource;

class EditClient extends EditRecord
{
    use EditActionsOnTop, RedirectsAfterSave;
    
    protected static string $resource = ClientResource::class;
}
