<?php

namespace App\Filament\Resources\TransferResource\Pages;

use Filament\Actions;
use App\Traits\EditActionsOnTop;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\TransferResource;

class EditTransfer extends EditRecord
{
    use EditActionsOnTop;
    
    protected static string $resource = TransferResource::class;

}
