<?php

namespace App\Filament\Resources\TransferResource\Pages;

use App\Filament\Resources\TransferResource;
use App\Traits\EditActionsOnTop;
use Filament\Resources\Pages\EditRecord;

class EditTransfer extends EditRecord
{
    use EditActionsOnTop;

    protected static string $resource = TransferResource::class;
}
