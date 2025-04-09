<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Traits\EditActionsOnTop;
use App\Traits\RedirectsAfterSave;
use Filament\Resources\Pages\EditRecord;

class EditClient extends EditRecord
{
    use EditActionsOnTop, RedirectsAfterSave;

    protected static string $resource = ClientResource::class;
}
