<?php

namespace App\Filament\Resources\TransferResource\Pages;

use App\Enums\TransferStatus;
use App\Traits\CreateActionsOnTop;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TransferResource;

class CreateTransfer extends CreateRecord
{
    use CreateActionsOnTop;
    
    protected static string $resource = TransferResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['status'] = TransferStatus::PENDING;
        return $data;
    }
}
