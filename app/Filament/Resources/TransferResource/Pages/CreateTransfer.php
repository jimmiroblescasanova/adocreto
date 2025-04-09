<?php

namespace App\Filament\Resources\TransferResource\Pages;

use App\Enums\TransferStatus;
use App\Filament\Resources\TransferResource;
use App\Traits\CreateActionsOnTop;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateTransfer extends CreateRecord
{
    use CreateActionsOnTop;

    protected static string $resource = TransferResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = auth()->id();
        $data['status'] = TransferStatus::Pending;
        $data['uuid'] = Str::uuid();

        return $data;
    }
}
