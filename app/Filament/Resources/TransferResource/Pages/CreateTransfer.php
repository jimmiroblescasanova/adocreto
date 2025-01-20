<?php

namespace App\Filament\Resources\TransferResource\Pages;

use Filament\Actions;
use Illuminate\Support\Str;
use App\Traits\CreateActionsOnTop;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TransferResource;

class CreateTransfer extends CreateRecord
{
    use CreateActionsOnTop;
    
    protected static string $resource = TransferResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['uuid'] = Str::uuid();
        return $data;
    }
}
